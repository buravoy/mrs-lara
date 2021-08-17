@if ($crud->hasAccess('create'))
    <a href="#" id='import-categories' class="btn btn-outline-primary mr-5" data-style="zoom-in">
        <span class="ladda-label">
            <i class="la la-plus-circle"></i> Импортировать</span>
    </a>
@endif


@push('after_scripts')
    <div class="modal fade" id="import-categories-modal" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Импорт категорий</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


                <form method="post" action="{{ route('xml-category-upload') }}" enctype="multipart/form-data" class="xml-upload-category">
                    @csrf
                    <div class="modal-body">
                        <input type="file" name="file">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary controls">Загрузить XML</button>
                    </div>
                </form>

                <form method="post" action="{{ route('xml-category-import') }}" class="xml-import-category" style="display: none">
                    @csrf
                    <div class="modal-body">
                        <p id="original"></p>
                        <input hidden type="text" name="filename" class="form-control">

                        <div class="checkbox">
                            <input type="checkbox" id="update_name" name="update_name" checked>
                            <label class="form-check-label font-weight-normal" for="update_name">Обновлять названия</label>
                        </div>

                        <div class="checkbox">
                            <input type="checkbox" id="update_short" name="update_short">
                            <label class="form-check-label font-weight-normal" for="update_short">Обновлять короткие названия</label>
                        </div>

                        <div class="checkbox">
                            <input type="checkbox" id="update_form" name="update_form">
                            <label class="form-check-label font-weight-normal" for="update_form">Обновлять словоформы</label>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary controls">Импортировать XML</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        const $importModal = $('#import-categories-modal');
        const $formImport = $('form.xml-import-category');
        const $formUpload = $('form.xml-upload-category');

        $('#import-categories').on('click', function () {
            $importModal.modal('show')
        });

        $importModal.on('hidden.bs.modal', function () {
            $formImport.hide(0);
            $formUpload.show(0)
            $formUpload.find('input[name=file]').val(null)
        });

        $formUpload.on('submit', function (e){
            e.preventDefault();
            const
                $this = $(this),
                form = $this.closest('form'),
                action = form.attr('action'),
                formdata = new FormData(form[0]);

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                contentType: false,
                url: action,
                data: formdata,
                processData: false,
                success: function (response) {
                    new Noty({
                        type: "success",
                        text: response.message,
                        timeout: 3000
                    }).show();

                    form.fadeOut(0);
                    $formImport.find('input[name=filename]').val(response.filename);
                    $formImport.find('#original').text(response.original);
                    $formImport.fadeIn(200);
                },
                timeout: 10000
            })
                .catch(function (error) {
                    const errors = JSON.parse(error.responseText)
                    new Noty({
                        type: "error",
                        text: errors.errors.file[0],
                        timeout: false
                    }).show();
            });
        })

        $formImport.on('submit', function (e) {
            e.preventDefault();
            const
                $this = $(this),
                form = $this.closest('form'),
                action = form.attr('action'),
                formdata = new FormData(form[0]);

            $this.find('.controls').attr('disabled', true).text('Идет импорт...')

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                contentType: false,
                url: action,
                data: formdata,
                processData: false,
                success: function () {
                    $this.find('.controls').attr('disabled', false).text('Импортировать XML')
                    location.reload();
                },
            })
                .catch(function (error) {
                    const errors = JSON.parse(error.responseText)
                    new Noty({
                        type: "error",
                        text: errors.errors.file[0],
                        timeout: false
                    }).show(100);
                });
        });


    </script>
@endpush
