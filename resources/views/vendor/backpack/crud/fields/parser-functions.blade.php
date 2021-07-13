@if ($field['file_functions'])
    <div class="w-100 d-flex mx-3">
        <textarea id="code" name="code" rows="50" hidden>{{ $field['file_functions']['content'] }}</textarea>
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
            $code = $('#code'),
            $tab = $code.closest('.tab-pane'),
            $tabName = $tab.attr('id'),
            $thisTabLink = $("a[href^='#"+$tabName+"']")

        if (!editor.isInit && $tab.hasClass('active')) setTimeout( ()=>{ initCode() }, 100);
        $thisTabLink.on('click', function (){ if (!editor.isInit) setTimeout( ()=>{ initCode() }, 100) })

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
    </script>
@endpush

@push('crud_fields_styles')
    <link rel="stylesheet" href="{{ asset('codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/theme/liquibyte.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/addon/scroll/simplescrollbars.css') }}">
    <link rel="stylesheet" href="{{ asset('codemirror/addon/fold/foldgutter.css') }}">
@endpush