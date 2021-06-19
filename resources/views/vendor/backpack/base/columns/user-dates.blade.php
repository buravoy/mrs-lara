<div class="dates">
    <p>Создан: {{ $entry->created_at }}</p>
    <p>Изменен: {{ $entry->updated_at }}</p>
    <p>Подтверджен:

            @if($entry->email_verified_at)
                {{ $entry->email_verified_at }}
            @else
                Не подтвержден
            @endif
    </p>
</div>

