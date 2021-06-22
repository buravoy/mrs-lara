@if ($crud->hasAccess('create'))
    <a href="#" id="clear-categories" class="btn btn-outline-error" data-style="zoom-in">
        <span class="ladda-label">
            <i class="la la-trash"></i>
        </span>
    </a>
@endif


@push('after_scripts')
    <div class="modal fade" id="clear-categories-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удалить все категории</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{ route('delete-all-categories') }}">
                    @csrf
                    <div class="modal-body">
                        <p class="mb-3 font-11 font-weight-bold">Все категории будут удалены</p>
                        <p>Это действие нельзя отменить!</p>
                        <div class="form-check">
                            <input id="delete-cats" type="checkbox" name="save" class="form-check-input">
                            <label class="form-check-label pointer" for="delete-cats">Подтвердить удаление</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="action-delete-cats" type="submit" class="btn btn-primary" disabled>Удалить все категории</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const $clearModal = $('#clear-categories-modal');

        $clearModal.on('show.bs.modal', function (e) {
            $('#action-delete-cats').prop('disabled', true);
            $('#delete-cats').prop('checked', false);
        })

        $('#clear-categories').on('click', function () {
            $clearModal.modal('show')
        });

        $('#delete-cats').on('change', function () {
            $('#action-delete-cats').prop('disabled', !this.checked);
        })

    </script>
@endpush
