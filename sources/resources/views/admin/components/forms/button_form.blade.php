@if($buttonFormEntity === 'button_form.order.store')
    <form action="{{ route('admin.form.event.store') }}" method="post">
        @csrf
        <input type="hidden" name="key" value="{{ $key }}">
        <button type="submit" class="btn btn-success btn-lg">Опубликовать на сайте</button>
    </form>
@endif
