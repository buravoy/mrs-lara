<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<input
    type="text"
    name="{{ $field['name'] }}"
    value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
    @include('crud::fields.inc.attributes')
>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_scripts')
        <script>
            const
                $name = $('input[name=name]'),
                $slug = $('input[name=slug]');

            $name.on('input', function () {
                $.ajax({
                    type: "POST",
                    url: '/create-slug',
                    data: {
                        name:$name.val(),
                    },
                    success: function (response) {
                        $slug.val(response)
                    },
                })
            });
        </script>


    @endpush
@endif
