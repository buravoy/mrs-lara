<div class="card-wrapper">
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