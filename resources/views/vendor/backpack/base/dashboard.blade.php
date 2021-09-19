@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Главная' => backpack_url('dashboard'),
        'Панель управления' => false,
    ];
@endphp

@section('content')
    <h2 class="mb-5">Панель управления</h2>
    <div class="row">
        <div class="col-12 col-md-3">
            <div class="border rounded p-3 mb-4 bg-white">
                <p class="mb-0">В базе <b>{{ $productsCount['all'] }}</b> товаров в <b>{{ $categoriesCount }}</b> категориях.</p>
                <p class="mb-0">Активных: <b>{{ $productsCount['active'] }}</b></p>
                <p class="mb-0">Не активных: <b>{{ $productsCount['trashed'] }}</b></p>
            </div>

            <button class="btn btn-sm btn-primary count-goods-in-menu mb-5">Посчитать товары во всех категориях</button>
        </div>

        <div class="col-12 col-md-9">
            <div class="border rounded p-3 mb-4 bg-white">
                <pre style="max-height: 600px; overflow-y: auto;"><b class="mb-3">Parsing.log</b><br><br>{{ $parserLog }}</pre>
            </div>
        </div>
    </div>
@endsection


@push('after_scripts')
    <script>
        $('.count-goods-in-menu').on('click', function () {

            $(this).attr('disabled', true);

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('count-goods-in-menu') }}',
                success: (response) => {
                    console.log(response)
                    $(this).attr('disabled', false);
                }
            })
                .done(function (response) {
                    console.log(response)
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
