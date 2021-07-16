@if ($field['file_info'])
    <div class="form-group col-md-8 d-flex mb-4 align-items-center flex-wrap">
        <button type="button"
                class="btn btn-primary mr-3"
                id="handle-offers"
                data-name="{{ $field['file_info']['name'] }}">Получить офферы из XML
        </button>

        <div class="form-group d-flex align-items-center mb-0">
            <label class="mb-0 mr-2">Загрузить офферы c</label>
            <input type="text" name="count_from" class="text-center font-weight-bold form-control px-1" style="max-width: 70px" value="1">
            <label class="mb-0 mx-2">по</label>
            <input type="text" name="count" class="text-center font-weight-bold form-control px-1" style="max-width: 70px" value="100">
        </div>
    </div>

    <div class="form-group col-md-4">
        <button id="action-delete-goods"
                type="button"
                class="btn btn-error text-white"
                data-slug="{{ $field['data']['slug'] }}">Удалить товары
        </button>

        <button type="button"
                class="btn btn-success ml-auto float-right parse-xml"
                data-id="{{ $field['data']['id'] }}"
                data-name="{{ $field['data']['slug'] }}">Запустить парсер
        </button>
    </div>

    <div id="parser-fields" class="col-md-6">
        <label class="mb-3">Имя функции для полей:</label>

        <div class="form-group w-100">
            <label class="mr-3">Уникальный ID товара:</label>
            <input name="offer_uniq" type="text" class="form-control">
        </div>
        <div class="form-group w-100 d-flex">
            <label class="mr-3">Название:</label>
            <input name="offer_name" type="text" class="form-control">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3">Описание&nbsp;1:</label>
            <input name="offer_desc_1" type="text" class="form-control">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3">Описание&nbsp;2:</label>
            <input name="offer_desc_2" type="text" class="form-control">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3">Цена:</label>
            <input name="offer_price" type="text" class="form-control">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3">Старая&nbsp;цена:</label>
            <input name="offer_old" type="text" class="form-control">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3">Картинки:</label>
            <input name="offer_img" type="text" class="form-control">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3">Ссылка:</label>
            <input name="offer_href" type="text" class="form-control">
        </div>

    </div>

    <div class="offer-info col-md-6" style="display: none">
        <div class="d-flex align-items-center justify-content-center mb-2">
            <button type="button" class="btn btn-sm btn-outline-primary mb-0" onclick="renderXML(-1)">prev</button>
            <input type="text" name="current" class="w-auto form-control form-control-sm mx-2 font-weight-bold text-center border-0" readonly>
            <button type="button" class="btn btn-sm btn-outline-primary mb-0" onclick="renderXML(1)">next</button>
        </div>

        <pre class="xml-view w-100 border rounded p-2 font-sm"></pre>
    </div>
@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Сперва загрузите XML на сервер</p>
    </div>
@endif
<textarea hidden name="{{ $field['name'] }}">{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}</textarea>


@push('crud_fields_scripts')
    <script src="{{ asset('beautify/beautify.js') }}"></script>
    <script src="{{ asset('beautify/beautify-css.js') }}"></script>
    <script src="{{ asset('beautify/beautify-html.js') }}"></script>
    <script>
        const
            $handleOffers = $('#handle-offers'),
            $parseXml = $('.parse-xml'),
            $xmlView = $('.xml-view'),
            $jsonView = $('.json-view'),
            $xmlCounter = $('[name=current]'),
            $parser = $('[name={{ $field['name'] }}]'),
            $parserFields = $('#parser-fields'),
            $count = $('[name=count]'),
            $countFrom = $('[name=count_from]');

        let parserData = {json:[], xml:[]},
            parser = $parser.text();

        if (parser !== '') {
            parser = JSON.parse(parser);
            console.log(parser)

            $parserFields.find('input').each(function (index, field) {
                const fieldName = field.name;
                if (parser[fieldName]) field.value = parser[fieldName]
            })
        }

        $parserFields.find('input').on('input', function (){
            const
                $t = $(this),
                fieldName = $t.attr('name'),
                fieldValue = $t.val(),
                newParserObj = {[fieldName]: fieldValue};

            parser ? Object.assign(parser, newParserObj) : parser = newParserObj;

            $parser.text(JSON.stringify(parser))
        })

        $handleOffers.on('click', function (){
            const
                $t= $(this),
                name = $t.data('name');

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('handle-offers') }}',
                data: { name: name, count_from: $countFrom.val(), count_to: $count.val()},
                success: (response) => {
                    parserData = response
                    renderXML();
                    $('.offer-info').fadeIn(200);
                    $('json-wrapper').fadeIn(200);
                    $xmlCounter.val(0)
                }
            })
        })

        $parseXml.on('click', function (){
            const
                $t= $(this),
                name = $t.data('name');
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('parse-xml') }}',
                data: { name: name },
                success: (response) => { console.log(response) }
            })
                .done(function (){

                })
                .catch(function (error){
                    new Noty({
                        type: "error",
                        text: error.responseJSON.exception+'<br>'+error.responseJSON.message,
                        timeout:false
                    }).show();
                console.log(error.responseJSON)
            })
        })


        function renderXML(direction = 0) {
            const
                currant = +$xmlCounter.val(),
                currentView = currant + direction;
            if (currentView < 0 || currentView > (+$count.val() - (+$countFrom.val() + 1))) return;

            const
                beautifyString = html_beautify(parserData.xml[currentView],{ indent_size: 2, space_in_empty_paren: true }),
                jsonString = JSON.stringify(parserData.json[currentView], null, "\t")

            $xmlView.text(beautifyString);
            $jsonView.text(jsonString);
            $xmlCounter.val(currentView);
            initJson();
        }
    </script>
@endpush

@push('after_scripts')
    <div class="modal fade" id="delete-goods">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удалить все товары этого партнера?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="mb-3 font-11 font-weight-bold">Все товары будут удалены</p>
                    <p>Это действие нельзя отменить!</p>
                    <div class="form-check">
                        <input id="delete-check" type="checkbox" name="save" class="form-check-input">
                        <label class="form-check-label pointer" for="delete-check">Подтвердить удаление</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button"
                            class="btn btn-error text-white ml-auto d-block delete-all"
                            data-slug="{{ $field['data']['slug'] ?? null }}" disabled>Удалить товары</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function (){
            const
                $clearModal = $('#delete-goods'),
                $deleteAll = $('.delete-all');

            $clearModal.on('show.bs.modal', function (e) {
                $deleteAll.prop('disabled', true);
                $('#delete-check').prop('checked', false);
            });

            $('#action-delete-goods').on('click', function () {
                $clearModal.modal('show')
            });

            $('#delete-check').on('change', function () {
                $deleteAll.prop('disabled', !this.checked);
            });

            $deleteAll.on('click', function () {
                $clearModal.modal('hide')
                $.ajax({
                    async: true,
                    type: "POST",
                    dataType: "json",
                    url: '{{ route('delete-all-goods') }}',
                    data: { slug: $(this).data('slug') },
                })
            });
        })
    </script>
@endpush