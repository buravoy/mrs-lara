@extends(backpack_view('blank'))

@section('content')
    <div class="row">
        <div class="col-3">
            <button class="btn btn-primary count-goods-in-menu">Посчитать товары меню категорий</button>
        </div>
    </div>
@endsection


@push('after_scripts')
    <script>
        $('.count-goods-in-menu').on('click', function () {
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: '{{ route('count-goods-in-menu') }}',
                success: (response) => {  console.log(response) }
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