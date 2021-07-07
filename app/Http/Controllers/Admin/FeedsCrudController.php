<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeedsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use function PHPUnit\Framework\objectEquals;

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
            'name' => 'xml_url',
            'type' => 'text',
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(FeedsRequest::class);

        $entry = CRUD::getCurrentEntry();

        if (isset($entry->slug)) {
            $file = base_path('uploads/xml/feeds/').$entry->slug.'.xml';

            if (file_exists($file)) {
                $fileInfo = [
                    'name' => basename($file),
                    'size' => number_format((filesize($file)/1024/1024), 2, ',', ' '),
                    'upd' => date ("d F Y - H:i:s.", filemtime($file))
                ];
            }
        }

//        CRUD::setFromDb(); // fields

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
            'label' => 'Расписание',
            'type' => 'text',
            'tab' => 'Информация',
            'attributes' => [
                'class' => 'form-control col-md-4'
            ],
            'wrapper'   => [
                'class'      => 'form-group col-12'
            ]
        ]);



        CRUD::addField([
            'name' => 'slug',
            'label' => 'Символьный код',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapper' => [
                'class' => 'form-group mt-5 col-md-8',
            ],
        ]);

        CRUD::addField([
            'name' => 'sort',
            'label' => 'Сортировка',
            'type' => 'text',
            'value' => !empty($entry->sort) ? $entry->sort : 500,
            'tab' => 'Информация',
            'wrapper' => [
                'class' => 'form-group col-md-2 mt-5 ml-auto',
            ],
        ]);

        CRUD::addField([
            'name' => 'parser',
            'type' => 'parser-config',
            'tab' => 'Настройки парсера',
            'data' => $entry,
            'file_info' => $fileInfo ?? null
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
