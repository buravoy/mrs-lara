@if ($crud->hasAccess('create'))
    <a href="#" id='import-categories' class="btn btn-outline-primary" data-style="zoom-in">
        <span class="ladda-label">
            <i class="la la-plus-circle"></i> Импортировать {{ $crud->entity_name_plural}}</span>
    </a>
@endif


@push('after_scripts')
    <div class="modal fade" id="import-categories-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('file.upload.post') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $('#import-categories').on('click', function () {
            $('#import-categories-modal').modal('show')
        })
    </script>
@endpush
