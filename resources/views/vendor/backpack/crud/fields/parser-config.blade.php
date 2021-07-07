@dump($field)

@if ($field['file_info'])
    <div class="form-group col-12 mb-3">
        <label>Скоро все будет</label>

        <button type="button"
                class=""
                id="handle-offers"
                data-name="{{ $field['file_info']['name'] }}">offers</button>

    </div>
@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Сперва загрузите XML на сервер</p>
    </div>
@endif

@push('crud_fields_scripts')
    <script>
        const
            $handleOffers = $('#handle-offers');


        $handleOffers.on('click', function (){


            const
                $t= $(this),
                name = $t.data('name');

            console.log(name)

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('handle-offers') }}',
                data: { name: name },
                success: (response) => {
                    console.log(response)
                }
            })
        })
    </script>
@endpush
