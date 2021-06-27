<div class="categories">


    <div class="d-flex align-items-center">
        <p class="font-weight-bold">{{ $entry->name }}</p>
        @if($entry->parent)
            <i class="las la-long-arrow-alt-left ml-3 mr-1"></i>
            <p class="small">{{ $entry->parent->name ?? null }}</p>
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
</div>

