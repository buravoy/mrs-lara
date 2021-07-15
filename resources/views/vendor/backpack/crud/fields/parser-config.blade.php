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
        <button type="button"
                class="btn btn-success ml-auto d-block parse-xml"
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

    <textarea hidden name="{{ $field['name'] }}">{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}</textarea>

@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Сперва загрузите XML на сервер</p>
    </div>
@endif

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
                success: (response) => {
                    console.log(response)
                }
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
