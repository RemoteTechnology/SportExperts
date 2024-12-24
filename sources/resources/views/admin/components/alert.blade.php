@if(session()->get('success'))
    <div id="alert-form"
         class="alert alert-success position-absolute"
         role="alert"
         style="z-index: 9999999999;">{{ session()->get('success') }}</div>
@endif
@if(session()->get('error'))
    <div id="alert-form"
         class="alert alert-danger position-absolute"
         role="alert"
         style="z-index: 9999999999;">{{ session()->get('error') }}</div>
@endif
