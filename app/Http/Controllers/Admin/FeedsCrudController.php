<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeedsRequest;
use App\Models\Groups;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;

/**
 * Class FeedsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FeedsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Feeds::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/feeds');
        CRUD::setEntityNameStrings('парсер', 'Парсеры');
        CRUD::orderBy('id');


    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
//        CRUD::setFromDb(); // columns

        CRUD::addColumn([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Название'
        ]);

        CRUD::addColumn([
            'name' => 'last_update',
            'type' => 'closure',
            'label' => 'Обновлен',
            'function' => function($entry) {
                if ($entry->last_update) return Carbon::parse($entry->last_update)->format('d M Y - H:i:s');
                return $entry->last_update;
            }
        ]);

        CRUD::addColumn([
            'name' => 'schedule',
            'label' => 'Автообновление',
            'type' => 'check',
            'wrapper' => [
                'class' => 'font-xl',
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(FeedsRequest::class);

        $entry = CRUD::getCurrentEntry();

        $attrGroups = Groups::all();

        foreach ($attrGroups as $group) $defaultFunctions['offer_'.$group['slug']] = $group['slug'];

        if (isset($entry->slug)) {
            $file = base_path('uploads/xml/feeds/').$entry->slug.'.xml';
            $fileFunctions = base_path('uploads/functions/').$entry->slug.'.php';

            if (file_exists($file)) {
                $fileInfo = [
                    'name' => basename($file),
                    'size' => number_format((filesize($file)/1024/1024), 2, ',', ' '),
                    'upd' => date ("d F Y - H:i:s.", filemtime($file))
                ];
            }

            if (file_exists($fileFunctions)) {
                $fileFunctionsInfo = [
                    'name' => basename($fileFunctions),
                    'content' => file_get_contents($fileFunctions)
                ];
            }
        }

        CRUD::addField([
            'name' => 'name',
            'label' => 'Название',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapper'   => [
                'class'      => 'form-group col-md-6'
            ],
        ]);

        CRUD::addField([
            'name' => 'xml_url',
            'label' => 'Ссылка на XML',
            'type' => 'text',
            'tab' => 'Информация',

        ]);

        CRUD::addField([
            'name' => 'xml',
            'type' => 'xml-feed-upload',
            'tab' => 'Информация',
            'data' => $entry,
            'file_info' => $fileInfo ?? null
        ]);

        CRUD::addField([
            'name' => 'schedule',
            'label' => 'Автообновление раз в сутки',
            'type'        => 'checkbox',
            'default'     => 0,
            'tab' => 'Информация',
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'parser',
            'type' => 'parser-config',
            'tab' => 'Настройки парсера',
            'data' => $entry,
            'file_info' => $fileInfo ?? null,
            'attr_groups' => $attrGroups
        ]);

        CRUD::addField([
            'name' => '',
            'type' => 'parser-functions',
            'tab' => 'Функции парсера',
            'data' => $entry,
            'file_functions' => $fileFunctionsInfo ?? null,
            'file_info' => $fileInfo ?? null
        ]);

        CRUD::addField([
            'name' => 'slug',
            'label' => 'Символьный код',
            'type' => 'text',
            'tab' => 'Дополнительо',
            'attributes'=>[ 'readonly' => true ],
            'wrapper' => [
                'class' => 'form-group col-md-8',
            ],
        ]);

        CRUD::addField([
            'name' => 'sort',
            'label' => 'Сортировка',
            'type' => 'text',
            'value' => !empty($entry->sort) ? $entry->sort : 500,
            'tab' => 'Дополнительо',
            'wrapper' => [
                'class' => 'form-group col-md-2 ml-auto',
            ],
        ]);
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
