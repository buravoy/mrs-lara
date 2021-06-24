<div class="categories">
    <p>
        <b>{{ $entry->name }}</b>
        <span class="small ml-3">
            Короткое:
            @if($entry->short_name)
                <b>{{ $entry->short_name }}</b>
            @else
                <b class="text-error">---</b>
            @endif
        </span>
    </p>

    <p class="small">
        Родительская:
        @if($entry->parent['name'])
            <span class="mr-3"><b>{{ $entry->parent['name'] }}</b></span>
        @else
            <span class="mr-3 text-error"><b>---</b></span>
        @endif
        Словоформа:
        @if($entry->form)
            <span class="mr-3"><b>{{ $entry->form }}</b></span>
        @else
            <span class="text-error"><b>---</b></span>
        @endif
    </p>
</div>

