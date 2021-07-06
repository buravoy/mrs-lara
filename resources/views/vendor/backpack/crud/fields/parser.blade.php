@dump($field)

@if($field['data'])

@include('crud::fields.inc.wrapper_start')

<button class="download-xml"
        type="button"
        data-url="{{ $field['data']->xml_url }}"
        data-name="{{ $field['data']->slug }}">
    Download
</button>


<p>Size: <span id="filesize"></span></p>

@endif


@include('crud::fields.inc.wrapper_end')


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
                data: { link: link, name: name },
                success: () => { clearInterval(loadingInterval) }
            })

            const loadingInterval = setInterval(() => {
                $.ajax({
                    async: true,
                    type: "POST",
                    dataType: "json",
                    url: '{{ route('get-size') }}',
                    data: { link: link, name: name },
                    success: function (response) {
                        $('#filesize').text(response.localSize + ' Mb')
                    }
                })
            }, 100);
        })
    </script>
@endpush
