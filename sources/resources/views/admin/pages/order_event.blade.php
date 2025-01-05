<div class="container">
    <div class="mt-5 mb-5">
        <h3 class="text-center">Заявки на события</h3>
    </div>
    @include('admin.components.redundant_list', ['content' => $content, 'tableEntity' => 'orders'])
</div>
