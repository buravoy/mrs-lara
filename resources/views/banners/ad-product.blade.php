@php

  $blockId = 'R-A-1281564-7';

@endphp

<div class="card-wrapper">
    {{ $loopIteration }}
    <div id="yandex_rtb_{{ $blockId }}"></div>
    <script>
        window.yaContextCb.push(()=>{
            Ya.Context.AdvManager.render({
                renderTo: 'yandex_rtb_{{ $blockId }}',
                blockId: '{{ $blockId }}'
            })
        })
    </script>
</div>

