@if($field['data'])
    @if ($field['file_info'])
        <div class="form-group col-12 mb-3">
            <label>Информация об XML фиде</label>
            <div class="d-flex flex-wrap">
                <div class="mr-3 border rounded p-2">Обновлен: <b id="info-upd">{{ $field['file_info']['upd'] }}</b></div>
                <div class="mr-3 border rounded p-2">Размер: <b id="info-size">{{ $field['file_info']['size'] }} Mb</b></div>
                <div class="mr-3 border rounded p-2">Файл: <b>{{ $field['file_info']['name'] }}</b></div>
            </div>
        </div>
    @endif

    <div class="form-group col-12 d-flex">
        <button class="download-xml btn btn-primary"
                type="button"
                data-url="{{ $field['data']->xml_url }}"
                data-name="{{ $field['data']->slug }}">
            Загрузить XML на сервер

        </button>

        <div id="uploading" class="row align-items-center ml-5" style="display: none !important;">
            <p class="mb-0">Загруженно: <span id="filesize" class="mx-2">0 B</span></p>
            <div class="spinner-border spinner-border-sm text-success"></div>
        </div>

        <div id="uploading-complete" class="row align-items-center ml-5" style="display: none !important;">
            <p class="mb-0">XML Загружен, обновите страницу (не обязательно)</p>
            <i class="ml-2 las la-check-circle text-success font-xl"></i>
        </div>
    </div>

@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Для загрузики XML, сперва сохраните парсер</p>
    </div>
@endif



@push('crud_fields_scripts')
    <script>
        const
            $downloadBtn = $('.download-xml'),
            $uploadMsg = $('#uploading'),
            $completeMsg = $('#uploading-complete');

        $downloadBtn.on('click', function (){
            const
                $t = $(this),
                link = $t.data('url'),
                name = $t.data('name');

            $downloadBtn.attr('disabled', 'disabled')
            $uploadMsg.fadeIn(200);

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('download-feed') }}',
                data: { link: link, name: name },
                success: () => {
                    clearInterval(loadingInterval);
                    $uploadMsg.fadeOut(0);
                    $completeMsg.fadeIn(200);
                    $downloadBtn.attr('disabled', false)
                    $('#info-upd').text('Только что').addClass('text-success')
                }
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
