<aside class="aside-container">
   <!-- START Sidebar (left)-->
   <div class="aside-inner">
      <nav class="sidebar" data-sidebar-anyclick-close="">
         <!-- START sidebar nav-->
         <ul class="sidebar-nav mt-5">

            <li class="@if($firstLevel == 'user_index')active @endif"><a href="{{ route('admin.users.index')}}" title="User">
                  <em class="icon-people"></em><span>ユーザー情報照会</span>
               </a>
            </li>

            <li class="@if($firstLevel == 'user_event')active @endif"><a href="#event" title="イベント情報" data-toggle="collapse"><em class="icon-note"></em><span data-localize="sidebar.nav.element.ELEMENTS">イベント情報</span></a>
            
               <ul class="sidebar-nav sidebar-subnav collapse @if($firstLevel == 'event_index')active @endif" id="event">
                  <li class="@if(Request::is('admin/event/index')) active @endif"><a href="{{ route('admin.events.index')}}" title="Standard"><span>イベント一覧</span></a></li>
                  <li class="@if(Request::is('admin/event/index')) active @endif"><a href="{{ route('admin.events.create')}}" title="Extended"><span>イベント作成</span></a></li>
               </ul>
            </li>

            <li class="@if($firstLevel == 'user_post')active @endif"><a href="#post" title="ショップ" data-toggle="collapse"><em class="icon-note"></em><span data-localize="sidebar.nav.element.ELEMENTS">ドックラン情報</span></a>
               <ul class="sidebar-nav sidebar-subnav collapse @if($firstLevel == 'posts_index')active @endif" id="post">
                  <li class="@if(Request::is('admin.places.index')) active @endif"><a href="{{ route('admin.places.index')}}" title="Standard"><span>ドックラン一覧</span></a></li>
                  <li class="@if(Request::is('admin.places.create')) active @endif"><a href="{{ route('admin.places.create')}}" title="Standard"><span>ドックラン作成</span></a></li>
               </ul>
            </li>

            <li class="@if($firstLevel == 'user_request')active @endif"><a href="{{ route('admin.contact.index')}}" title="request">
                  <em class="icon-people"></em><span>お問い合わせ</span>
               </a>
            </li>

         </ul><!-- END sidebar nav-->
      </nav>
   </div><!-- END Sidebar (left)-->
</aside><!-- offsidebar-->
