@if ($field['file_info'])
    <div class="form-group col-md-8 d-flex mb-4 align-items-center flex-wrap">
        <button type="button"
                class="btn btn-primary mr-3"
                id="handle-offers"
                data-name="{{ $field['file_info']['name'] }}">Получить офферы из XML
        </button>

        <div class="form-group d-flex align-items-center mb-0">
            <label class="mb-0 mr-2">Загрузить первые:</label>
            <input type="text" name="count" class="w-auto form-control form-control-sm" value="100">
        </div>
    </div>

    <div class="form-group col-md-4">
        <button type="button"
                class="btn btn-success ml-auto d-block"
                id="parse-xml"
                data-id="{{ $field['data']['id'] }}"
                data-name="{{ $field['data']['slug'] }}">Запустить парсер
        </button>

    </div>

    <div id="parser-fields" class="col-md-8">
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
            <label class="mr-3">Описание:</label>
            <input name="offer_desc" type="text" class="form-control">
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

    <div id="offer-info" class="col-md-4" style="display: none">
        <div class="d-flex align-items-center mb-2">
            <button type="button" class="btn btn-sm btn-outline-primary mb-0" onclick="renderXML(-1)">prev</button>
            <input type="text" name="current" class="w-auto form-control form-control-sm mx-2 font-weight-bold text-center border-0" readonly>
            <button type="button" class="btn btn-sm btn-outline-primary mb-0" onclick="renderXML(1)">next</button>
        </div>

        <pre id="xml" class="w-100 border rounded p-2 font-sm"></pre>
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
            $parseXml = $('#parse-xml'),
            $xmlView = $('#xml'),
            $xmlCounter = $('[name=current]'),
            $parser = $('[name={{ $field['name'] }}]'),
            $parserFields = $('#parser-fields'),
            $count = $('[name=count]');

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
                name = $t.data('name'),
                count = $count.val();

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('handle-offers') }}',
                data: { name: name, count: count },
                success: (response) => {
                    parserData = response
                    const beautifyString = html_beautify(parserData.xml[0],{ indent_size: 2, space_in_empty_paren: true });
                    $('#offer-info').fadeIn(200);
                    $xmlView.text(beautifyString);
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


        function renderXML(direction) {
            const
                currant = +$xmlCounter.val(),
                currentView = currant + direction;
            if (currentView < 0 || currentView > (+$count.val() - 1)) return;

            const beautifyString = html_beautify(parserData.xml[currentView],{ indent_size: 2, space_in_empty_paren: true })
            $xmlView.text(beautifyString);
            $xmlCounter.val(currentView);
        }
    </script>
@endpush
