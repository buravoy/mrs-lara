@if (!$entry->deleted_at && $crud->hasAccess('show') && !$crud->model->translationEnabled())
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}" class="btn btn-sm btn-outline-dark pb-0 mr-1">
		<i class="las la-file-alt"></i>
	</a>
@endif

