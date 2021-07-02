<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')

@dump($entry)

@dump($field['attributes'])

@include('crud::fields.inc.wrapper_end')

{{--@php--}}
{{--    $attributesArray = json_decode($field['value']);--}}
{{--@endphp--}}

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_scripts')

        <script>

        </script>

    @endpush
@endif
