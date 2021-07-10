<!-- text input -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')

@if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
    @if(isset($field['prefix'])) <div class="input-group-prepend"><span class="input-group-text">{!! $field['prefix'] !!}</span></div> @endif
    <input
        type="text"
        name="{{ $field['name'] }}"
        value="{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}"
        @include('crud::fields.inc.attributes')
    >
    @if(isset($field['suffix'])) <div class="input-group-append"><span class="input-group-text">{!! $field['suffix'] !!}</span></div> @endif
    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

@include('crud::fields.inc.wrapper_end')

@push('crud_fields_scripts')
    <script>
        const
            $price = $('[name=price]'),
            $oldPrice = $('[name=old_price]'),
            $discount = $('[name=discount]');

        $price.on('input', function () {
            $discount.val(calcDiscount($price.val(), $oldPrice.val()));
        })

        $oldPrice.on('input', function () {
            $discount.val(calcDiscount($price.val(), $oldPrice.val()));
        })

        function calcDiscount(newPrice, oldPrice) {
            if (!newPrice || !oldPrice) return;
            return Math.round((oldPrice - newPrice)/oldPrice*100);
        }

    </script>
@endpush
