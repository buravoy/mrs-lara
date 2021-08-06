@extends(backpack_view('layouts.top_left'))

@php
	// Merge widgets that were fluently declared with widgets declared without the fluent syntax: 
	// - $data['widgets']['before_content']
	// - $data['widgets']['after_content']
	if (isset($widgets)) {
		foreach ($widgets as $section => $widgetSection) {
			foreach ($widgetSection as $key => $widget) {
				\Backpack\CRUD\app\Library\Widget::add($widget)->section($section);
			}
		}
	}
@endphp

@section('before_breadcrumbs_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'before_breadcrumbs')->toArray() ])
@endsection

@section('after_breadcrumbs_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'after_breadcrumbs')->toArray() ])
@endsection

@section('before_content_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'before_content')->toArray() ])
@endsection

@section('content')
@endsection

@section('after_content_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'after_content')->toArray() ])
@endsection

@push('after_scripts')
<script>
		$(document).on('click','.count-goods', function (){
			const
				$t = $(this),
				id = $t.data('id');

			$.ajax({
				async: true,
				type: "POST",
				dataType: "json",
				url: '{{ route('count-goods') }}',
				data: { id: id },
			})
					.done(function (response) {

						$t.text(response)

						new Noty({
							type: "success",
							text: 'Значение сохранено: ' + response,
							timeout: 300
						}).show();
					})

					.catch(function (error) {
						new Noty({
							type: "error",
							text: error.responseJSON.exception + '<br>' + error.responseJSON.message,
							timeout: false
						}).show();
						console.log(error.responseJSON)
					})
		})
</script>
@endpush