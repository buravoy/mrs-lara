<!-- field_type_name -->

@php
    $fieldValue = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';
    $attributesSelected = json_decode($fieldValue);
@endphp


@include('crud::fields.inc.wrapper_start')

<textarea class="form-control" name="{{ $field['name'] }}" hidden>{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}</textarea>

@foreach($field['attributes'] as $group)
    <div class="form-group col-md-12">
        <label>{{ $group->name }}</label>
        <select name="{{ $group->slug }}" class="attribute" style="width: 100%" multiple>
            @foreach($group['attributes'] as $attribute)
                <option
                    value="{{ $attribute->id }}"
                    @if(in_array($attribute->id,  $attributesSelected->{ $group->slug } ?? []))
                    selected
                    @endif
                >
                    {{ $attribute->name }}
                </option>
            @endforeach
        </select>

    </div>
@endforeach

@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_scripts')

        <script>
            const
                $select = $('.attribute'),
                $attributes = $('[name={{ $field['name'] }}]');

            let attributes = $attributes.text();

            console.log(attributes)

            if (attributes !== '') attributes = JSON.parse(attributes);

            $select.select2({theme: 'bootstrap'});

            $select.on('change', function (e) {
                const
                    attributeName = e.target.name,
                    attributeValues = $(this).select2("val"),
                    newAttrObj = {[attributeName]: attributeValues};

                attributes ? Object.assign(attributes, newAttrObj) : attributes = newAttrObj;

                $attributes.text(JSON.stringify(attributes))
            })
        </script>
    @endpush
@endif
