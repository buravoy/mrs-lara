<div class="categories">
    <div class="d-flex align-items-center">
        @if($entry->parent)
            <i class="las la-long-arrow-alt-left mr-1"></i>
            <p class="small"><b>{{ $entry->parent->name ?? null }}</b></p>
        @endif
    </div>

    <div class="d-flex align-items-center">
        <p class="small mr-3">
            Короткое:
            <span class="font-weight-bold">
                {!! !empty($entry->short_name) ? $entry->short_name : '<i class="las la-times-circle text-error"></i>' !!}
            </span>
        </p>
        <p class="small">
            Словоформа:
            <span class="font-weight-bold">
                {!! !empty($entry->form) ? $entry->form : '<i class="las la-times-circle text-error"></i>' !!}
            </span>
        </p>
    </div>
    <div class="d-flex align-items-center">
        <p class="mb-0 mr-5 count-goods" style="cursor: pointer" data-slug="{{ $entry->slug }}">Товаров: <b>{{ $entry->count }}</b></p>
        <a href="{{ route('category') }}/{{ $entry->slug }}" target="_blank">Перейти</a>
    </div>
</div>
