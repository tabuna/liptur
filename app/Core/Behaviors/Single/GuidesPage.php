<?php

namespace App\Core\Behaviors\Single;

use Orchid\Platform\Behaviors\Single;
use Orchid\Platform\Http\Forms\Posts\UploadPostForm;

class GuidesPage extends Single
{
    /**
     * @var string
     */
    public $name = 'Информация для экскурсоводов';

    /**
     * @var string
     */
    public $slug = 'guides';

    /**
     * @var string
     */
    public $icon = 'fa fa-bell-o';

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'title'       => 'tag:input|type:text|name:title|max:255|required|title:Article Title|help:SEO title',
            'description' => 'tag:textarea|name:description|max:255|required|rows:5|title:Short description',
            'keywords'    => 'tag:tags|name:keywords|max:255|required|title:Keywords|help:SEO keywords',

        ];
    }

    /**
     * @return array
     */
    public function modules()
    {
        return [
            UploadPostForm::class,
        ];
    }
}
