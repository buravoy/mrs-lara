@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Главная' => backpack_url('dashboard'),
        'Мета генераторы' => false,
    ];
@endphp


@section('content')
    <div class="row">
        <div class="col-12 col-md-3">
            @dump($generators)


            @foreach($generators as $generator)

                <form action="{{ route('save-meta-generator') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" class="form-control" value="{{ $generator->name }}">
                        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>

                    <button type="submit">qweqwe</button>
                </form>

            @endforeach

        </div>
    </div>
@endsection


@push('after_scripts')
    <script>
        $('form').on('submit', function (e) {
            e.preventDefault();

            const
                $this = $(this),
                form = $this.closest('form'),
                action = form.attr('action'),
                formdata = new FormData(form[0]);

            formdata.append('_token', $this.find('input[name=_token]').val());

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
