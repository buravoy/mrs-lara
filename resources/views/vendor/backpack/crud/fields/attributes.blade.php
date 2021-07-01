<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<input
    type="text"
    name="{{ $field['name'] }}"
    value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
    @include('crud::fields.inc.attributes')
>

@include('crud::fields.inc.wrapper_end')


{{--@php--}}
{{--    $attributesArray = json_decode($field['value']);--}}
{{--@endphp--}}

<div class="attributes">

    @foreach($field['data'] as $group)

        <h4>{{ $group->name }}</h4>

        <select name="{{ $group->slug }}">
            <option value="">Не использовать</option>
            @foreach($group->attributes as $attribute)

            <option value="{{ $attribute->slug }}">{{ $attribute->name }}</option>

            @endforeach
        </select>



    @endforeach
</div>

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_scripts')

        <script>

            $('select').select2()

            const $inputs = $('.attributes input')

            $inputs.on('input', function () {
                attributes = {}
                $inputs.each( function () {
                    const
                        $t = $(this),
                        name = $t.attr('name');

                    attributes[name] = $t.val();
                });

                $('input[name={{ $field['name'] }}]').val(JSON.stringify(attributes))
            })
        </script>

    @endpush
@endif
