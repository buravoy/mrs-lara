@if (! $entry->trashed())

    <a class="btn btn-sm btn-link" target="_self" href="{{ url($crud->route.'/'.$entry->id.'/block') }}" onclick="return confirm('Вы уверены?')"><i class="la la-arrow-down"></i> Деактивировать</a>

@endif

{{-- Кнопка показывается при одновременном соблюдении 3 условий: пользователь - админ; запись в состоянии soft deleted; в модели свойство disableDelete отсутствует либо равно false --}}
@if ($entry->trashed() && backpack_user()->hasRole('admin') && (bool) $crud->model->disableDelete == false)

    <a class="btn btn-sm btn-link" target="_self" href="{{ url($crud->route.'/'.$entry->id.'/custom_delete') }}" onclick="return confirm('Вы уверены?')"><i class="la la-trash"></i> Удалить</a>

@endif

@if ($entry->deleted_at != null)

    <a class="btn btn-sm btn-link" target="_self" href="{{ url($crud->route.'/'.$entry->id.'/unblock') }}" onclick="return confirm('Вы уверены?')"><i class="la la-arrow-up"></i> Активировать</a> &nbsp;&nbsp;

@endif


