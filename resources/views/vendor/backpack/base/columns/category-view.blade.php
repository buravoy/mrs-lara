<div class="categories">
    <p><b>{{ $entry->name }}</b></p>

        <p class="small">
            Короткое:
            @if($entry->short_name)
                <span class="mr-3"><b>{{ $entry->short_name }}</b></span>
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

    <p class="small">
        Родительская:
        @if($entry->parent['name'])
            <b>{{ $entry->parent['name'] }}</b>
        @else
            <span class="text-error"><b>---</b></span>
        @endif
    </p>
</div>

