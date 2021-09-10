@if ($field['file_functions'])
    <div class="row px-3 mb-3 w-100 align-items-center">
        <div class="col-md-8 d-flex flex-wrap">
            <button type="button"
                    class="btn btn-primary mr-3 mb-2"
                    id="handle-offers"
                    data-name="{{ $field['file_info']['name'] }}">Получить офферы из XML
            </button>

            <div class="form-group d-flex flex-wrap align-items-center mb-2 mr-3">
                <label class="mb-0 mr-2">Загрузить офферы c</label>
                <input type="text" name="count_from" class="text-center font-weight-bold form-control px-1"
                       style="max-width: 70px" value="1">
                <label class="mb-0 mx-2">по</label>
                <input type="text" name="count" class="text-center font-weight-bold form-control px-1"
                       style="max-width: 70px" value="100">
            </div>
            <button type="button"
                    class="btn btn-success d-block parse-xml mb-2"
                    data-id="{{ $field['data']['id'] }}"
                    data-name="{{ $field['data']['slug'] }}">Запустить парсер
            </button>
            <div class="form-group d-flex align-items-center mb-2 ml-3">
                <input id="mode" type="checkbox" name="mode" class="" value="test">
                <label for="mode" class="mb-0 ml-2">Тестовый режим</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="d-flex align-items-center justify-content-center ml-auto">
                <button type="button" class="btn btn-sm btn-outline-primary mb-0 pb-0" onclick="renderXML(-1)"><i
                        class="la la-angle-double-left"></i></button>
                <input type="text" name="current" style="max-width: 110px;"
                       class="w-auto form-control form-control-sm mx-2 font-weight-bold text-center border-0" readonly>
                <button type="button" class="btn btn-sm btn-outline-primary mb-0 pb-0" onclick="renderXML(1)"><i
                        class="la la-angle-double-right"></i></button>
            </div>
        </div>

    </div>

    <div class="col-md-8 mb-2 ace_wrapper">
        <div id="ace_code">{{ $field['file_functions']['content'] }}</div>
    </div>

    <div class="col-md-4 mb-2 ace_wrapper">
        <div id="ace_json"></div>
    </div>

    <div class="form-group col-md-8 mt-2">
        <select name="ace_code_theme">
            <option value="ambiance">ambiance</option>
            <option value="chaos">chaos</option>
            <option value="chrome">chrome</option>
            <option value="clouds">clouds</option>
            <option value="clouds_midnight">clouds_midnight</option>
            <option value="cobalt">cobalt</option>
            <option value="crimson_editor">crimson_editor</option>
            <option value="dawn">dawn</option>
            <option value="dracula">dracula</option>
            <option value="dreamweaver">dreamweaver</option>
            <option value="eclipse">eclipse</option>
            <option value="github">github</option>
            <option value="gob">gob</option>
            <option value="gruvbox">gruvbox</option>
            <option value="idle_fingers">idle_fingers</option>
            <option value="iplastic">iplastic</option>
            <option value="katzenmilch">katzenmilch</option>
            <option value="kr_theme">kr_theme</option>
            <option value="kuroir">kuroir</option>
            <option value="merbivore">merbivore</option>
            <option value="merbivore_soft">merbivore_soft</option>
            <option value="mono_industrial">mono_industrial</option>
            <option value="monokai">monokai</option>
            <option value="nord_dark">nord_dark</option>
            <option value="pastel_on_dark">pastel_on_dark</option>
            <option value="solarized_dark">solarized_dark</option>
            <option value="solarized_light">solarized_light</option>
            <option value="sqlserver">sqlserver</option>
            <option value="terminal">terminal</option>
            <option value="textmate">textmate</option>
            <option value="tomorrow">tomorrow</option>
            <option value="tomorrow_night">tomorrow_night</option>
            <option value="tomorrow_night_blue">tomorrow_night_blue</option>
            <option value="tomorrow_night_bright">tomorrow_night_bright</option>
            <option value="tomorrow_night_eighties">tomorrow_night_eighties</option>
            <option value="twilight">twilight</option>
            <option value="vibrant_ink">vibrant_ink</option>
            <option value="xcode">xcode</option>
        </select>
    </div>
    <div class="form-group col-md-4 mt-2">
        <select name="ace_json_theme">
            <option value="ambiance">ambiance</option>
            <option value="chaos">chaos</option>
            <option value="chrome">chrome</option>
            <option value="clouds">clouds</option>
            <option value="clouds_midnight">clouds_midnight</option>
            <option value="cobalt">cobalt</option>
            <option value="crimson_editor">crimson_editor</option>
            <option value="dawn">dawn</option>
            <option value="dracula">dracula</option>
            <option value="dreamweaver">dreamweaver</option>
            <option value="eclipse">eclipse</option>
            <option value="github">github</option>
            <option value="gob">gob</option>
            <option value="gruvbox">gruvbox</option>
            <option value="idle_fingers">idle_fingers</option>
            <option value="iplastic">iplastic</option>
            <option value="katzenmilch">katzenmilch</option>
            <option value="kr_theme">kr_theme</option>
            <option value="kuroir">kuroir</option>
            <option value="merbivore">merbivore</option>
            <option value="merbivore_soft">merbivore_soft</option>
            <option value="mono_industrial">mono_industrial</option>
            <option value="monokai">monokai</option>
            <option value="nord_dark">nord_dark</option>
            <option value="pastel_on_dark">pastel_on_dark</option>
            <option value="solarized_dark">solarized_dark</option>
            <option value="solarized_light">solarized_light</option>
            <option value="sqlserver">sqlserver</option>
            <option value="terminal">terminal</option>
            <option value="textmate">textmate</option>
            <option value="tomorrow">tomorrow</option>
            <option value="tomorrow_night">tomorrow_night</option>
            <option value="tomorrow_night_blue">tomorrow_night_blue</option>
            <option value="tomorrow_night_bright">tomorrow_night_bright</option>
            <option value="tomorrow_night_eighties">tomorrow_night_eighties</option>
            <option value="twilight">twilight</option>
            <option value="vibrant_ink">vibrant_ink</option>
            <option value="xcode">xcode</option>
        </select>
    </div>

    <div class="offer-info col-md-12 mt-2">
        <pre class="xml-view w-100 border rounded p-2 font-sm"></pre>
    </div>
@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Сперва загрузите XML на сервер</p>
    </div>
@endif

@push('crud_fields_scripts')
    <script src="{{ asset('ace/ace.js') }}"></script>
    <script src="{{ asset('beautify/beautify.js') }}"></script>
    <script src="{{ asset('beautify/beautify-css.js') }}"></script>
    <script src="{{ asset('beautify/beautify-html.js') }}"></script>

    <script>
        const
            $codeTheme = $('select[name=ace_code_theme]'),
            $jsonTheme = $('select[name=ace_json_theme]');

        $codeTheme.find('option[value=' + getCookie('ace_code') + ']').attr('selected', true);
        $jsonTheme.find('option[value=' + getCookie('ace_json') + ']').attr('selected', true);

        $codeTheme.on('change', function () {
            ace_code.setTheme("ace/theme/" + $(this).val());
            setCookie('ace_code', $(this).val(), {secure: true, 'max-age': 315360000})
        })

        $jsonTheme.on('change', function () {
            ace_json.setTheme("ace/theme/" + $(this).val());
            setCookie('ace_json', $(this).val(), {secure: true, 'max-age': 315360000})
        })

        const ace_code = ace.edit("ace_code");
        ace_code.setTheme("ace/theme/" + getCookie('ace_code'));
        ace_code.session.setMode("ace/mode/php");
        ace_code.setShowPrintMargin(false);
        ace_code.getSession().on('change', function () {
            updateCode()
        });

        const ace_json = ace.edit("ace_json");
        ace_json.setTheme("ace/theme/" + getCookie('ace_json'));
        ace_json.session.setMode("ace/mode/json");
        ace_json.setReadOnly(true)

        const
            $xmlView = $('.xml-view'),
            $jsonView = $('#ace_json'),
            $xmlCounter = $('[name=current]'),
            $parseXml = $('.parse-xml'),
            $count = $('[name=count]'),
            $countFrom = $('[name=count_from]'),
            $handleOffers = $('#handle-offers');

        let parserData = {json: [], xml: []};

        $parseXml.on('click', function () {
            const
                $t = $(this),
                name = $t.data('name');

            $t.attr('disabled', true);

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('parse-xml') }}',
                data: {
                    name: name,
                    count_from: $countFrom.val(),
                    count_to: $count.val(),
                    mode: !!$('input[name=mode]').prop("checked")
                },
                success: () => {
                    $t.attr('disabled', false);
                }
            })
                .done(function () {
                    $t.attr('disabled', false);
                })

                .catch(function (error) {
                    $t.attr('disabled', false);
                    new Noty({
                        type: "error",
                        text: error.responseJSON.exception + '<br>' + error.responseJSON.message,
                        timeout: false
                    }).show();
                    console.log(error.responseJSON)
                })
        })

        $handleOffers.on('click', function () {
            const
                $t = $(this),
                name = $t.data('name');

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('handle-offers') }}',
                data: {
                    name: name,
                    count_from: $countFrom.val(),
                    count_to: $count.val()
                },
                success: (response) => {
                    parserData = response;
                    renderXML();
                    $xmlCounter.val(0);
                }
            })
        })

        function updateCode() {
            const value = ace_code.getSession().getValue();

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('save-function') }}',
                data: {
                    value: value,
                    filename: '{{ $field['file_functions']['name'] ?? null }}'
                },
            })
        }

        function renderXML(direction = 0) {
            const
                currant = +$xmlCounter.val(),
                currentView = currant + direction;

            if (currentView < 0 || currentView > (+$count.val() - (+$countFrom.val() + 1))) return;

            const
                beautifyString = html_beautify(parserData.xml[currentView], {
                    indent_size: 2,
                    space_in_empty_paren: true
                }),
                jsonString = JSON.stringify(parserData.json[currentView], null, "\t");

            $xmlView.text(beautifyString);
            $xmlCounter.val(currentView);

            ace_json.setValue(jsonString, 1);
        }

        function setCookie(name, value, options = {}) {
            options = {
                path: '/',
                ...options
            };

            if (options.expires instanceof Date) {
                options.expires = options.expires.toUTCString();
            }

            let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

            for (let optionKey in options) {
                updatedCookie += "; " + optionKey;
                let optionValue = options[optionKey];
                if (optionValue !== true) {
                    updatedCookie += "=" + optionValue;
                }
            }

            document.cookie = updatedCookie;
        }

        function getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : 'monokai';
        }
    </script>
@endpush

@push('crud_fields_styles')
    <style>
        .ace_wrapper {
            height: 700px;
        }

        #ace_code, #ace_json {
            position: absolute;
            top: 0;
            right: 15px;
            bottom: 0;
            left: 15px;
            border: 1px solid #b7b7b7;
            border-radius: 5px;
        }
    </style>
@endpush
