<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Orchid\Platform\Core\Models\Post;

class NewController extends Controller
{
    /**
     * NewController constructor.
     */
    public function __construct()
    {
        $this->middleware('cache');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->has('date')) {
            $date = Carbon::parse($request->date);
            $news = Post::published()->where('type', 'news')
                ->whereNotNull('options->locale->'.App::getLocale())
                ->whereDate('publish_at', $date->format('Y-m-d'))
                ->orderBy('publish_at', 'DESC')
                ->get();
        } else {
            $date = Carbon::now();
            $news = Post::published()->where('type', 'news')
                ->whereNotNull('options->locale->'.App::getLocale())
                ->orderBy('publish_at', 'DESC')
                ->simplePaginate(14);
        }

        return view('listings.news', [
            'news' => $news,
            'date' => $date,
            'page' => getPage('news'),
        ]);
    }

    /**
     * @param Post $new
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Post $new)
    {
        $tags = Post::select('id')->find($new->id)->tags->implode('slug', ', ');

        $similars = Post::withTag($tags)
            ->published()
            ->where('type', 'news')
            ->where('id', '!=', $new->id)
            ->orderBy('id', 'Desc')
            ->limit(2)
            ->get();

        return view('pages.news', [
            'new'      => $new,
            'similars' => $similars,
        ]);
    }

    /**
     * RSS.
     */
    public function rss()
    {
        $feed = App::make('feed');
        $feed->setCache(60, 'rss-news-'.App::getLocale());

        if (!$feed->isCached()) {  // creating rss feed with our most recent 20 posts

            $news = Post::where('type', 'news')
                ->whereNotNull('options->locale->'.App::getLocale())
                ->whereDate('publish_at', '<', time())
                ->orderBy('publish_at', 'DESC')
                ->limit(20)
                ->get();

            // set your feed's title, description, link, pubdate and language
            $feed->title = 'Липецкий туристический портал';
            $feed->description = 'Липецкий туристический портал';
            $feed->logo = config('app.url').'/img/tour/logo.png';
            $feed->link = url('rss');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            //$feed->pubdate = $posts[0]->created_at;
            $feed->lang = App::getLocale();
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text

            foreach ($news as $new) {
                // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                $feed->add(
                    $new->getContent('name'),
                    'Липецкий туристический портал',//$post->author,
                    URL::to($new->slug),
                    $new->created_at,
                    $new->getContent('description'),
                    $new->getContent('body')
                );
            }
        }

        return $feed->render('atom');
    }
}
