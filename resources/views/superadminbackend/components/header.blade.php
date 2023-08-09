 {{-- Navbar --}}
  <nav class="main-header navbar navbar-expand navbar-light  navbar-dark ">
    {{-- Left navbar links --}}
    <ul class="navbar-nav">
      <li class="nav-item">
        <button class="btn d-none d-lg-block"  data-widget="pushmenu" data-id="{{ Auth::user()->id }}" name="status"  ><i class="fas fa-bars text-light" id="btn" ></i></button>
        <a class="nav-link d-lg-none " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>

      </li>
      <li class="nav-item">
        <h4 class="text-warning mt-2 ml-2">SuperAdmin</h4>
      </li>
    </ul>

    {{-- Right navbar links --}}
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <div class="mt-2 mr-2">
        <input type="checkbox"  data-id="{{ Auth::user()->id }}" name="status" {{ Auth::user()->mode == 1 ? 'checked' : '' }}
          class="js-switch" >
        </div>
     </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class='fas fa-expand-arrows-alt'></i>
        </a>

      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-user-cog"></i>
        </a>
      </li>
    </ul>
  </nav>
 <aside class="control-sidebar control-sidebar-dark" style="display: block;">
  <div class="p-3 control-sidebar-content">

    <ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown">

      <a id="#" class="nav-link text-center" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

        <strong> {{ Auth::user()->name }}</strong>
      </a>
    </li>
  </ul>
  <ul class="navbar-nav ml-2">
    <li class="nav-item pl-3 pt-2">
      <div class=" container">
        <a class="col btn btn-primary text-light" href="{{ route('logout') }}"
           onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">

            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    </li>
  </ul>
  </div>
</aside>
