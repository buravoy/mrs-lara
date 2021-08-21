@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Главная' => backpack_url('dashboard'),
        'Генераторы' => false,
    ];
@endphp


@section('content')

    <h2 class="mb-5">Настройка генераторов СЕО контента</h2>


    <div class="tab-container  mb-2">

        <div class="nav-tabs-custom " id="form_tabs">
            <ul class="nav nav-tabs " role="tablist">
                @foreach($generators as $generator)
                    <li class="nav-item">
                        <a href="#{{ $generator->type }}" data-toggle="tab" class="nav-link @if($loop->first) active @endif">{{ $generator->name }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content p-0 ">
                @foreach($generators as $generator)
                    <div role="tabpanel" class="tab-pane fade @if($loop->first) active show @else @endif" id="{{ $generator->type }}">
                        <h4 class="mb-3">{{ $generator->name }}
                            <span class="font-sm text-muted">({{ $generator->type }})</span>
                        </h4>

                        <form action="{{ route('save-meta-generator') }}">
                            @csrf
                            <input hidden type="text" name="type" value="{{ $generator->type }}">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>META Title</label>
                                    <input type="text" name="template_meta_title" class="form-control" value="{{ $generator->template_meta_title }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>META Description</label>
                                    <input type="text" class="form-control" name="template_meta_description" value="{{ $generator->template_meta_description }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <label>Title (H1)</label>
                                    <textarea class="form-control" rows="5" name="template_title">{{ $generator->template_title }}</textarea>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Description 1</label>
                                    <textarea class="form-control" rows="5" name="template_description1">{{ $generator->template_description1 }}</textarea>
                                </div>
                                <div class="form-group col-md-4 col-12">
                                    <label>Description 2</label>
                                    <textarea class="form-control" rows="5" name="template_description2">{{ $generator->template_description2 }}</textarea>
                                </div>
                            </div>
                            <p class="mb-1">Переменные: <i><b>$name$ $count$ $discountMax$ $discountMin$ $priceMax$ $priceMin$</b></i></p>
                            <p class="mb-1">Подстановка слов: <b>[слово/ второе слово/ третье слово]</b></p>
                            <p class="mb-1">Исключения: между такими <b>{ ... }</b> скобками весь текст включая <i><b>[подстановочные/ слова]</b></i> будет ИКСКЛЮЧЕН, если <i><b>$переменная$</b></i> не определена<b></b></p>
                            @if($generator->type == 'filter')
                                <p class="mb-1">Использование атрибутов: <b>[$group$]</b> подставит атрибуты группы, <b>[$attributes$]</b> подставит оставшиеся атрибуты</p>
                            @endif
                            <button type="submit" class="btn btn-success d-block mt-5">
                                <span class="la la-save"></span> &nbsp;Сохранить
                            </button>
                        </form>


                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection


@push('after_scripts')
    <script>
        $('#myTab li:last-child a').tab('show')

        $('form').on('submit', function (e) {
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
            })
                .done(function (response) {
                    new Noty({
                        type: "success",
                        text: response,
                        timeout: 2000
                    }).show();
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
    </script>
@endpush
