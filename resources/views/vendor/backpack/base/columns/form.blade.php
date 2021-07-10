<div class="d-flex">
    <div class="mr-3">
        <p class="mb-0 font-xs">Множественная:</p>
        <p class="mb-0 text-center">{!! json_decode($entry->form)->form_many ?? '<i class="las la-times-circle text-error"></i>' !!}</p>
    </div>
    <div class="mr-3">
        <p class="mb-0 font-xs">Мужская:</p>
        <p class="mb-0 text-center">{!! json_decode($entry->form)->form_male ?? '<i class="las la-times-circle text-error"></i>' !!}</p>
    </div>
    <div class="mr-3">
        <p class="mb-0 font-xs">Женская:</p>
        <p class="mb-0 text-center">{!! json_decode($entry->form)->form_female ?? '<i class="las la-times-circle text-error"></i>' !!}</p>
    </div>
    <div class="mr-3">
        <p class="mb-0 font-xs">Средняя:</p>
        <p class="mb-0 text-center">{!! json_decode($entry->form)->form_neutral ?? '<i class="las la-times-circle text-error"></i>' !!}</p>
    </div>
</div>

