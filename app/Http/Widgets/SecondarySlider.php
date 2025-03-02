<?php

namespace App\Http\Widgets;

use App\Core\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Orchid\Platform\Widget\Widget;
use Orchid\Setting\Facades\Setting;

class SecondarySlider extends Widget
{
    /**
     * @return mixed
     */
    public function run()
    {
        $carousel = Cache::remember('secondary-carousel-'.App::getLocale(), 5, function () {
            return Post::where('type', 'secondary-carousel')
                ->whereNotNull('options->locale->'.App::getLocale())
                ->whereDate('publish_at', '>=', Carbon::today()->toDateString())
                ->orderBy('publish_at', 'ASC')
                ->limit(10)
                ->get();
        });

        if ($carousel->count() != 0) {
            return view('partials.events.secondary', [
                'carousel' => $carousel,
                'weather'  => Setting::get('weather'),
            ]);
        }
    }
}
