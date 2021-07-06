@dump($field)

@if($field['data'])

@include('crud::fields.inc.wrapper_start')

<button class="download-xml" type="button" data-url="{{ $field['data']->xml_url }}" data-name="{{ $field['data']->slug }}">Download</button>

<div class="-4">

    @endif
</div>
@include('crud::fields.inc.wrapper_end')



@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_scripts')
        <script>
            const $downloadBtn = $('.download-xml')

            $downloadBtn.on('click', function (){
                const
                    $t = $(this),
                    link = $t.data('url'),
                    name = $t.data('name');

                $.ajax({
                    async: true,
                    type: "POST",
                    dataType: "json",
                    url: '{{ route('download-feed') }}',
                    data: {
                        link: link,
                        name: name
                    },
                    success: function (response) {

                    }
                })
                    .catch(function (error) {

                    });

            })
        </script>
    @endpush
@endif
