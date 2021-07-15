@if ($field['file_functions'])
    <div class="form-group col-md-12">
        <button type="button"
                class="btn btn-success ml-auto d-block parse-xml"
                data-id="{{ $field['data']['id'] }}"
                data-name="{{ $field['data']['slug'] }}">Запустить парсер
        </button>

    </div>

    <div class="col-md-8 d-flex font-sm">
        <textarea id="code" name="code" rows="50" hidden>{{ $field['file_functions']['content'] }}</textarea>
    </div>

    <div class="col-md-4 offer-info" style="display: none">
        <div class="d-flex align-items-center justify-content-center mb-2">
            <button type="button" class="btn btn-sm btn-outline-primary mb-0" onclick="renderXML(-1)">prev</button>
            <input type="text" name="current" class="w-auto form-control form-control-sm mx-2 font-weight-bold text-center border-0" readonly>
            <button type="button" class="btn btn-sm btn-outline-primary mb-0" onclick="renderXML(1)">next</button>
        </div>
        <div class="d-flex json-wrapper font-xs">
            <textarea id="json" class="json-view w-100"></textarea>
        </div>
    </div>
@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Сперва загрузите XML на сервер</p>
    </div>
@endif


@push('crud_fields_scripts')
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
            editor = { area: null, isInit: false },
            json = { area: null, isInit: false },
            $code = $('#code'),
            $json = $('.json-view'),
            $tab = $code.closest('.tab-pane'),
            $tabName = $tab.attr('id'),
            $thisTabLink = $("a[href^='#"+$tabName+"']")

        if (!editor.isInit && $tab.hasClass('active')) setTimeout( ()=>{ initCode() }, 100);
        $thisTabLink.on('click', function (){
            if (!editor.isInit) setTimeout( ()=>{ initCode() }, 100)
            setTimeout( ()=>{ initJson() }, 100)
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
                gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
            })

            editor.area.on('change', function (){
                const content = editor.area.getValue();

                $.ajax({
                    async: true,
                    type: "POST",
                    dataType: "json",
                    url: '{{ route('save-function') }}',
                    data: { value: content, filename: '{{ $field['file_functions']['name'] }}' },
                })
            })
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