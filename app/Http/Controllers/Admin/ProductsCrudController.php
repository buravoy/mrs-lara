<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attributes;
use App\Http\Requests\ProductsRequest;
use App\Models\Categories;
use App\Models\Groups;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Products::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/products');
        CRUD::setEntityNameStrings('товар', 'Товары');

        CRUD::addFilter(
            [
                'name' => 'id',
                'type' => 'select2',
                'label' => 'Категория',
            ],
            function () {
                return Categories::pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->query = $this->crud->query->whereHas('category', function ($query) use ($value) {
                    $query->where('category_id', $value);
                });
            }
        );
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
            'label' => 'Название',
        ]);

        CRUD::addColumn([
            'name' => 'category',
            'type' => 'relationship',
            'label' => 'Категория'
        ]);

        CRUD::addColumn([
            'name' => 'slug',
            'type' => 'text',
            'label' => 'Символьный код'
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
        CRUD::setValidation(ProductsRequest::class);

        $entry = CRUD::getCurrentEntry();
        $attrArr = Groups::with('attributes')->get();

        CRUD::addField([
            'name' => 'name',
            'label' => 'Название',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        CRUD::addField([
            'name' => 'category',
            'label' => 'Категории',
            'type' => 'select2_multiple',
            'pivot' => true,
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12',
            ],
        ]);

        CRUD::addField([
            'name' => 'price',
            'label' => 'Цена',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
        ]);

        CRUD::addField([
            'name' => 'old_price',
            'label' => 'Старая цена',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
        ]);

        CRUD::addField([
            'name' => 'discount',
            'label' => 'Скидка',
            'type' => 'text',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
        ]);

        CRUD::addField([
            'name' => 'description',
            'label' => 'Описание',
            'type' => 'textarea',
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12',
            ],
        ]);

        CRUD::addField([
            'name' => 'image',
            'label' => 'Картинки',
            'type' => 'browse_multiple',
            'multiple'   => true,
            'tab' => 'Информация',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-8',
            ],
        ]);

        CRUD::addField([
            'name' => 'attributes',
            'label' => 'Атрибуты',
            'type' => 'attributes-select',
            'tab' => 'Атрибуты',
            'attributes' => $attrArr
        ]);

        CRUD::addField([
            'name' => 'meta_title',
            'label' => 'МЕТА Title',
            'type' => 'text',
            'tab' => 'МЕТА',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12',
            ],
        ]);

        CRUD::addField([
            'name' => 'meta_description',
            'label' => 'META Description',
            'type' => 'textarea',
            'tab' => 'МЕТА',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12',
            ],
        ]);

        CRUD::addField([
            'name' => 'slug',
            'label' => 'Символьный код',
            'type' => 'text',
            'tab' => 'Дополнительно',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-8',
            ],
        ]);

        CRUD::addField([
            'name' => 'sort',
            'label' => 'Сортировака',
            'type' => 'text',
            'value' => !empty($entry->sort) ? $entry->sort : 500,
            'tab' => 'Дополнительно',
            'wrapperAttributes' => [
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
