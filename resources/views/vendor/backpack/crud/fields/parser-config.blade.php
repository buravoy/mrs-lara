@dump($field)

@if ($field['file_info'])
    <div class="form-group col-12 mb-3">
        <label>Скоро все будет</label>
    </div>
@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Сперва загрузите XML на сервер</p>
    </div>
@endif

@push('crud_fields_scripts')
    <script>

    </script>
@endpush
