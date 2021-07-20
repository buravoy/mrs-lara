@if (!$entry->deleted_at && $crud->hasAccess('update') && !$crud->model->translationEnabled())
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}" class="btn btn-sm btn-primary pb-0 mr-5">
		<i class="la la-edit"></i>
	</a>
@endif