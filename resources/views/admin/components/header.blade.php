<header class="topnavbar-wrapper">
   <!-- START Top Navbar-->
   <nav class="navbar topnavbar">

      <!-- START navbar header-->
      <div class="navbar-header">
         <a class="navbar-brand" href="{{route('user.event')}}">
            <div class="brand-logo">
               <img class="img-fluid" src="{{ asset('images/icon.png') }}" alt="App Logo" width="20%">
            </div>
            <div class="brand-logo-collapsed">
               <img class="img-fluid" src="{{ asset('images/icon.png') }}" alt="App Logo">
            </div>
         </a>
      </div><!-- END navbar header-->

      <!-- START Left navbar-->
      <ul class="navbar-nav mr-auto flex-row">
         <li class="nav-item">
            <a class="nav-link d-none d-md-block d-lg-block d-xl-block" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
               <em class="fas fa-bars"></em>
            </a>
            <a class="nav-link sidebar-toggle d-md-none" href="#" data-toggle-state="aside-toggled" data-no-persist="true">
               <em class="fas fa-bars"></em>
            </a>
         </li>
         <!-- <li class="nav-item d-none d-md-block">
            <a class="nav-link" id="user-block-toggle" href="#user-block" data-toggle="collapse">
               <em class="icon-user"></em>
            </a>
         </li> -->
      </ul><!-- END Left navbar-->


      <!-- START Right Navbar-->
      <ul class="navbar-nav flex-row">
         @unless (Auth::guard('admin')->check())
         <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
         </li>
         @if (Route::has('admin.register'))
         <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.register') }}">{{ __('Register') }}</a>
         </li>
         @endif
         @else
         <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
               {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
               <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
               </a>

               <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                  @csrf
               </form>
            </div>
         </li>
         @endunless

         <!-- <li class="nav-item d-none d-md-block">
            <a class="nav-link" href="#" data-toggle-fullscreen="">
               <em class="fas fa-expand"></em>
            </a>
         </li> -->

         <!-- <li class="nav-item">
            <a class="nav-link" href="#" data-search-open="">
               <em class="icon-magnifier"></em>
            </a>
         </li> -->

         <!-- <li class="nav-item dropdown dropdown-list">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-toggle="dropdown">
               <em class="icon-bell"></em>
               <span class="badge badge-danger"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right animated flipInX">
               <div class="dropdown-item">
                  <div class="list-group">
                     <div class="list-group-item list-group-item-action">
                        <div class="media">
                           <div class="align-self-start mr-2"><em class="fab fa-twitter fa-2x text-info"></em></div>
                           <div class="media-body">
                              <p class="m-0">New followers</p>
                              <p class="m-0 text-muted text-sm">1 new follower</p>
                           </div>
                        </div>
                     </div>
                     <div class="list-group-item list-group-item-action">
                        <div class="media">
                           <div class="align-self-start mr-2"><em class="fas fa-envelope fa-2x text-warning"></em></div>
                           <div class="media-body">
                              <p class="m-0">New e-mails</p>
                              <p class="m-0 text-muted text-sm">You have 10 new emails</p>
                           </div>
                        </div>
                     </div>
                     <div class="list-group-item list-group-item-action">
                        <div class="media">
                           <div class="align-self-start mr-2"><em class="fas fa-tasks fa-2x text-success"></em></div>
                           <div class="media-body">
                              <p class="m-0">Pending Tasks</p>
                              <p class="m-0 text-muted text-sm">11 pending task</p>
                           </div>
                        </div>
                     </div>
                     <div class="list-group-item list-group-item-action"><span class="d-flex align-items-center"><span class="text-sm">More notifications</span><span class="badge badge-danger ml-auto">14</span></span></div>
                  </div>
               </div>
            </div>
         </li> -->

         <!-- <li class="nav-item">
            <a class="nav-link" href="#" data-toggle-state="offsidebar-open" data-no-persist="true"><em class="icon-notebook"></em></a>
         </li> -->
      </ul>
      <!-- START Search form-->
      <!-- <form class="navbar-form" role="search" action="search.html">
         <div class="form-group"><input class="form-control" type="text" placeholder="Type and hit enter ...">
            <div class="fas fa-times navbar-form-close" data-search-dismiss=""></div>
         </div><button class="d-none" type="submit">Submit</button>
      </form> -->
   </nav>

</header><!-- sidebar-->