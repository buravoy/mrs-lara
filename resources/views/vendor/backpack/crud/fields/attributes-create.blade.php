@push('crud_fields_scripts')
    <script>
        window.onload = function() {
            getType($('select[name=group_id]').val());
        };

        $('select[name=group_id]').on("select2:select", function (e) {
            getType(e.params.data.id);
            $('input[name=value]').val('#FFFFFF');
        });


        $('input[data-option=color]').on('input', function () {
            $('input[name=value]').val($(this).val())
        })

        function getType(id) {
            $.ajax({
                type: "POST",
                url: '/get-group-type',
                data: {id: id}
            })
                .done(function (response) {
                    const
                        data = JSON.parse(response),
                        $color = $('#color');


                    switch (data.type) {
                        case 'text' : {
                            $color.fadeOut(0);
                            break;
                        }

                        case 'color' : {
                            $color.fadeIn(200);
                            break
                        }

                        default : {
                            new Noty({
                                type: "error",
                                text: 'Ошибка типа атрибута',
                                timeout: 3000
                            }).show()
                        }
                    }
                })
                .catch(function (error) {
                    const errors = JSON.parse(error.responseText)
                    new Noty({
                        type: "error",
                        text: errors.errors.file[0],
                        timeout: false
                    }).show(300)
                });
        }

    </script>

@endpush

