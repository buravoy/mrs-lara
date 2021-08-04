@if ($field['file_info'])
    <div class="form-group col-12">
        <button id="action-delete-goods"
                type="button"
                class="btn btn-error text-white ml-auto d-block"
                data-slug="{{ $field['data']['slug'] }}"><i class="las la-trash"></i>
        </button>
    </div>

    <div class="col-md-4 parser-fields">
        <label class="mb-3">Функции для основных полей:</label>

        <div class="form-group w-100 d-flex">
            <label class="mr-3 font-sm">Уникальный ID товара:</label>
            <input name="offer_uniq" type="text" class="form-control funk">
        </div>
        <div class="form-group w-100 d-flex">
            <label class="mr-3 font-sm">Название:</label>
            <input name="offer_name" type="text" class="form-control funk">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3 font-sm">Описание&nbsp;1:</label>
            <input name="offer_desc_1" type="text" class="form-control funk">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3 font-sm">Описание&nbsp;2:</label>
            <input name="offer_desc_2" type="text" class="form-control funk">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3 font-sm">Цена:</label>
            <input name="offer_price" type="text" class="form-control funk">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3 font-sm">Старая&nbsp;цена:</label>
            <input name="offer_old" type="text" class="form-control funk">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3 font-sm">Картинки:</label>
            <input name="offer_img" type="text" class="form-control funk">
        </div>

        <div class="form-group w-100 d-flex">
            <label class="mr-3 font-sm">Ссылка:</label>
            <input name="offer_href" type="text" class="form-control funk">
        </div>

    </div>

    <div class="col-md-4 parser-fields add_functions">
        <label class="mb-3">Функции аттрибутов:</label>
        @foreach($field['attr_groups'] as $attr)
            <div class="attr_group d-flex align-items-center mb-3">
                <label class="ml-2 mr-3 attr_label">{{ $attr->name }}</label>
                <input name="offer_{{ $attr->slug }}" type="text" class="form-control funk">
            </div>
        @endforeach
    </div>

    <div class="col-md-4 parser-fields">
        <label class="mb-3">Функция категорий:</label>

        <div class="form-group w-100">
            <input name="offer_category" type="text" class="form-control funk" value="category">
        </div>

        <p class="border rounded-md p-3">
            Должна возвращать массив <br> <span class="font-weight-bold"><i>НАЗВАНИЙ</i></span><br> конечных категорий.
            <br>
            <br>
            Например:
            <br>
            <span class="font-weight-bold">['Женские брюки', 'Спортивные брюки']</span>
        </p>

    </div>


@else
    <div class="form-group col-12">
        <p class="d-inline-block py-2 px-3 text-center bg-danger text-white rounded">Сперва загрузите XML на сервер</p>
    </div>
@endif

<textarea
        hidden
        class="w-100"
        name="{{ $field['name'] }}">{{ old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '' }}</textarea>


@push('crud_fields_scripts')
    <script>


        const
            $parser = $('[name={{ $field['name'] }}]'),
            $parserFields = $('.parser-fields'),
            $addFunctionsInputs = $('.add_functions').find('input');

        let parser = $parser.text(), parserData = {json:[], xml:[]};

        if (parser !== '') {
            parser = JSON.parse(parser);
            $parserFields.find('input.funk').each(function (index, field) {
                const fieldName = field.name;
                if (parser[fieldName]) field.value = parser[fieldName];
            })
        }

        $parserFields.find('input').on('input', function (){
            const
                $t = $(this),
                fieldName = $t.attr('name'),
                fieldValue = $t.val(),
                newParserObj = {[fieldName]: fieldValue};

            parser ? Object.assign(parser, newParserObj) : parser = newParserObj;

            parser = Object.entries(parser).reduce((a,[k,v]) => (v ? {...a, [k]:v} : a), {});
            delete parser['undefined'];
            $parser.text(JSON.stringify(parser))
        })

        $parserFields.find('input').trigger('input');

    </script>
@endpush

@push('after_scripts')
    <div class="modal fade" id="delete-goods">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удалить все товары этого партнера?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="mb-3 font-11 font-weight-bold">Все товары будут удалены</p>
                    <p>Это действие нельзя отменить!</p>
                    <div class="form-check">
                        <input id="delete-check" type="checkbox" name="save" class="form-check-input">
                        <label class="form-check-label pointer" for="delete-check">Подтвердить удаление</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button"
                            class="btn btn-error text-white ml-auto d-block delete-all"
                            data-slug="{{ $field['data']['slug'] ?? null }}" disabled>Удалить товары</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function (){
            const
                $clearModal = $('#delete-goods'),
                $deleteAll = $('.delete-all');

            $clearModal.on('show.bs.modal', function (e) {
                $deleteAll.prop('disabled', true);
                $('#delete-check').prop('checked', false);
            });

            $('#action-delete-goods').on('click', function () {
                $clearModal.modal('show')
            });

            $('#delete-check').on('change', function () {
                $deleteAll.prop('disabled', !this.checked);
            });

            $deleteAll.on('click', function () {
                $clearModal.modal('hide')
                $.ajax({
                    async: true,
                    type: "POST",
                    dataType: "json",
                    url: '{{ route('delete-all-goods') }}',
                    data: { slug: $(this).data('slug') },
                })
            });
        })
    </script>
@endpush
