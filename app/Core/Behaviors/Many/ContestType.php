<?php

namespace App\Core\Behaviors\Many;

use App\Http\Filters\Common\RegionFilters;
use App\Http\Filters\Titz\TitzFilter;
use App\Http\Forms\Posts\Options;
use Orchid\Platform\Behaviors\Many;
use Orchid\Platform\Http\Filters\CreatedFilter;
use Orchid\Platform\Http\Filters\SearchFilter;
use Orchid\Platform\Http\Filters\StatusFilter;
use Orchid\Platform\Http\Forms\Posts\BasePostForm;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;

class ContestType extends Many
{
    /**
     * @var string
     */
    public $name = 'Конкурсы';

    /**
     * @var string
     */
    public $slug = 'contest';

    /**
     * @var string
     */
    public $icon = 'fa fa-folder-o';

    /**
     * @var string
     */
    public $image = '/img/category/contest.jpg';

    /**
     * Slug url /news/{name}.
     *
     * @var string
     */
    public $slugFields = 'name';

    /**
     * @var bool
     */
    public $category = true;

    /**
     * @var array
     */
    public $filters = [
        SearchFilter::class,
        StatusFilter::class,
        CreatedFilter::class,
        TitzFilter::class,

        RegionFilters::class,
        //DistanceFilters::class,
        // DateFilters::class,
    ];

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id'             => 'sometimes|integer|unique:posts',
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'name' => 'tag:input|type:text|name:name|max:255|required|title:Название|help:Главный заголовок',
            'body' => 'tag:wysiwyg|name:body|max:255|required|rows:10',

            'region'   => 'tag:region|name:region|title:Регион',
            'distance' => 'tag:input|type:number|name:distance|title:Удалённость от Липецка|help:Отсчёт с центра города (Почтамп)|placeholder:0',

            'title'       => 'tag:input|type:text|name:title|max:255|required|title:Заголовок статьи|help:Упоменение',
            'description' => 'tag:textarea|name:description|max:255|required|rows:5|title:Краткое описание',
            'keywords'    => 'tag:tags|name:keywords|max:255|required|title:Ключевые слова|help:Упоменение',

        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid(): array
    {
        return [
            'name'       => 'Название',
            'publish_at' => 'Дата публикации',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * @return array
     */
    public function modules()
    {
        return [
            BasePostForm::class,
            UploadPostForm::class,
            Options::class,
        ];
    }

    /**
     * @return string
     */
    public function route(): string
    {
        return 'item';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function display()
    {
        return collect([
            'name' => 'Конкурсы',
            'icon' => 'icon-lip-rapier',
            'time' => true,
        ]);
    }

    /**
     * Basic statuses possible for the object.
     *
     * @return array
     */
    public function status()
    {
        return [
            'publish' => 'Опубликовано',
            'draft'   => 'Черновик',
            'titz'    => 'Тиц',
        ];
    }
}
