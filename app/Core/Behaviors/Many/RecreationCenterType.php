<?php

namespace App\Core\Behaviors\Many;

use App\Http\Filters\Common\RegionFilters;
use App\Http\Filters\RecrationCenter\CategoryFilters;
use App\Http\Forms\Posts\Category;
use App\Http\Forms\Posts\Options;
use Orchid\Platform\Behaviors\Many;
use Orchid\Platform\Http\Filters\CreatedFilter;
use Orchid\Platform\Http\Filters\SearchFilter;
use Orchid\Platform\Http\Filters\StatusFilter;
use Orchid\Platform\Http\Forms\Posts\BasePostForm;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;

class RecreationCenterType extends Many
{
    /**
     * @var string
     */
    public $name = 'Базы отдыха';

    /**
     * @var string
     */
    public $slug = 'recration-center';

    /**
     * @var string
     */
    public $icon = 'fa fa-bell-o';

    /**
     * @var string
     */
    public $image = '/img/category/recration-center.jpg';

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
     * Display global maps.
     *
     * @var bool
     */
    public $maps = true;

    /**
     * @var array
     */
    public $filters = [
        SearchFilter::class,
        StatusFilter::class,
        CreatedFilter::class,

        RegionFilters::class,
        CategoryFilters::class,
        //DistanceFilters::class,
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
            'name'            => 'tag:input|type:text|name:name|max:255|required|title:Название|help:Главный заголовок',
            'body'            => 'tag:wysiwyg|name:body|max:255|required|rows:10',
            'open'            => 'tag:datetime|type:text|name:open|max:255|required|title:Дата открытия|help:Открытие мероприятия состоиться',
            'close'           => 'tag:datetime|type:text|name:close|max:255|required|title:Дата закрытия',
            'place'           => 'tag:place|type:text|name:place|max:255|required|title:Место положение|help:Адрес на карте',
            'phone'           => 'tag:input|type:text|name:phone|max:255|required|title:Номер телефона|help:Записывается в свободной форме',
            'site'            => 'tag:input|type:url|name:site|title:Официальный сайт',
            'email'           => 'tag:input|type:email|name:email|title:Электронная почта',
            'price'           => 'tag:input|type:text|name:price|max:255|required|title:Стоимость|help:Записывается в свободной форме',
            'number-of-seats' => 'tag:input|type:numeric|name:number-of-seats|title:Число мест|help:Записывается в свободной форме',

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
            Category::class,
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function display()
    {
        return collect([
            'name'   => 'Базы отдыха',
            'icon'   => 'icon-lip-recliner',
            'svg'    => '/dist/svg/maps/recliner.svg',
            'mapUrl' => true,
            'time'   => false,
        ]);
    }

    /**
     * @return string
     */
    public function route(): string
    {
        return 'item';
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
