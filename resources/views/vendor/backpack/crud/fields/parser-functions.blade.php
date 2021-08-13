@if ($field['file_functions'])
    <div class="form-group col-md-12 d-flex align-items-center">
        <button type="button"
                class="btn btn-primary mr-3 mb-2"
                id="handle-offers"
                data-name="{{ $field['file_info']['name'] }}">Получить офферы из XML
        </button>

        <div class="form-group d-flex align-items-center mb-2 mr-3">
            <label class="mb-0 mr-2">Загрузить офферы c</label>
            <input type="text" name="count_from" class="text-center font-weight-bold form-control px-1" style="max-width: 70px" value="1">
            <label class="mb-0 mx-2">по</label>
            <input type="text" name="count" class="text-center font-weight-bold form-control px-1" style="max-width: 70px" value="100">
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


        <div class="d-flex align-items-center justify-content-center ml-auto">
            <button type="button" class="btn btn-sm btn-outline-primary mb-0 pb-0" onclick="renderXML(-1)"><i class="la la-angle-double-left"></i></button>
            <input type="text" name="current" class="w-auto form-control form-control-sm mx-2 font-weight-bold text-center border-0" readonly>
            <button type="button" class="btn btn-sm btn-outline-primary mb-0 pb-0" onclick="renderXML(1)"><i class="la la-angle-double-right"></i></button>
        </div>
    </div>

    <div class="col-md-8 d-flex font-sm">
        <textarea id="code" name="code" rows="50" hidden>{{ $field['file_functions']['content'] }}</textarea>
    </div>

    <div class="col-md-4 offer-info" style="display: none">

        <div class="d-flex json-wrapper font-xs h-100">
            <textarea id="json" class="json-view w-100"></textarea>
        </div>
    </div>

    <div class="offer-info col-md-12 mt-3" style="display: none">

        <pre class="xml-view w-100 border rounded p-2 font-sm"></pre>
    </div>
@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Сперва загрузите XML на сервер</p>
    </div>
@endif


@push('crud_fields_scripts')
    <script src="{{ asset('beautify/beautify.js') }}"></script>
    <script src="{{ asset('beautify/beautify-css.js') }}"></script>
    <script src="{{ asset('beautify/beautify-html.js') }}"></script>
    <script src="{{ asset('codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('codemirror/addon/edit/matchbrackets.js') }}"></script>
    <script src="{{ asset('codemirror/addon/edit/closebrackets.js') }}"></script>
    <script src="{{ asset('codemirror/addon/edit/continuelist.js') }}"></script>
    <script src="{{ asset('codemirror/addon/edit/matchtags.js') }}"></script>
    <script src="{{ asset('codemirror/addon/edit/trailingspace.js') }}"></script>
    <script src="{{ asset('codemirror/addon/scroll/simplescrollbars.js') }}"></script>
    <script src="{{ asset('codemirror/addon/edit/active-line.js') }}"></script>
    <script src="{{ asset('codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
    <script src="{{ asset('codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('codemirror/mode/clike/clike.js') }}"></script>
    <script src="{{ asset('codemirror/mode/php/php.js') }}"></script>
    <script src="{{ asset('codemirror/addon/fold/brace-fold.js') }}"></script>
    <script src="{{ asset('codemirror/addon/fold/comment-fold.js') }}"></script>
    <script src="{{ asset('codemirror/addon/fold/foldcode.js') }}"></script>
    <script src="{{ asset('codemirror/addon/fold/foldgutter.js') }}"></script>
    <script src="{{ asset('codemirror/addon/fold/indent-fold.js') }}"></script>
    <script src="{{ asset('codemirror/addon/fold/markdown-fold.js') }}"></script>
    <script src="{{ asset('codemirror/addon/fold/xml-fold.js') }}"></script>

    <script>
        const

            editor = {area: null, isInit: false},
            json = {area: null, isInit: false},
            $code = $('#code'),
            $tab = $code.closest('.tab-pane'),
            $tabName = $tab.attr('id'),
            $thisTabLink = $("a[href^='#" + $tabName + "']"),
            $xmlView = $('.xml-view'),
            $jsonView = $('.json-view'),
            $xmlCounter = $('[name=current]'),
            $parseXml = $('.parse-xml'),
            $count = $('[name=count]'),
            $countFrom = $('[name=count_from]'),
            $handleOffers = $('#handle-offers');

        if (!editor.isInit && $tab.hasClass('active')) setTimeout(() => { initCode() }, 100);

        $thisTabLink.on('click', function () {
            if (!editor.isInit) setTimeout(() => {initCode()}, 100)
            setTimeout(() => {initJson()}, 100)
        })

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
                success: (response) => {
                    console.log(response)
                    if (response) {
                        $t.attr('disabled', false);
                    }
                }
            })
                .done(function () {

                })

                .catch(function (error) {
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
                    parserData = response
                    renderXML();
                    $('.offer-info').fadeIn(200);
                    $('.json-wrapper').fadeIn(200);
                    $xmlCounter.val(0)
                }
            })
        })

        function initCode() {
            editor.isInit = true;
            editor.area = CodeMirror.fromTextArea(document.getElementById("code"), {
                theme: 'liquibyte',
                lineNumbers: true,
                matchBrackets: true,
                mode: "application/x-httpd-php",
                scrollbarStyle: 'simple',
                coverGutterNextToScrollbar: true,
                styleActiveLine: true,
                autoCloseBrackets: true,
                foldGutter: true,
                gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
                comments: true
            })

            editor.area.on('change', function () {
                const content = editor.area.getValue();

                $.ajax({
                    async: true,
                    type: "POST",
                    dataType: "json",
                    url: '{{ route('save-function') }}',
                    data: {
                        value: content,
                        filename: '{{ $field['file_functions']['name'] ?? null }}'
                    },
                })
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
                jsonString = JSON.stringify(parserData.json[currentView], null, "\t")

            $xmlView.text(beautifyString);
            $jsonView.text(jsonString);
            $xmlCounter.val(currentView);
            setTimeout(() => {
                initJson()
            }, 100)
        }

        function initJson() {
            $('.json-wrapper').find('.CodeMirror').remove();

            json.isInit = true;
            json.area = CodeMirror.fromTextArea(document.getElementById("json"), {
                lineNumbers: true,
                matchBrackets: true,
                mode: "application/ld+json",
                scrollbarStyle: 'simple',
                coverGutterNextToScrollbar: true,
                styleActiveLine: true,
                autoCloseBrackets: true,
                foldGutter: true,
                readOnly: true,
                gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
            })

        }
    </script>
@endpush

@push('crud_fields_styles')
    <link rel="stylesheet" href="{{ asset('codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/theme/liquibyte.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/addon/scroll/simplescrollbars.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/addon/fold/foldgutter.css') }}">
@endpush