@if(session()->has('success'))
    <div class="alert alert-success" id="mydiv">
      <span> {{ session()->get('success') }}</span>
    </div>
@endif

@if(session()->has('info'))
    <div class="alert alert-warning" id="mydiv">
     <span>   {{ session()->get('info') }}</span>
    </div>
@endif
@if(session()->has('danger'))
    <div class="alert alert-danger" id="mydiv">
       <span> {{ session()->get('danger') }}</span>
    </div>
@endif
