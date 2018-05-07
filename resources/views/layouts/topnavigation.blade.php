<!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right"> 
               <!--  <li>@if(Auth::check()) {{ Auth::user()->nama }} @endif</li> -->
                <li>
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user "></i>
                      @if (Auth::check())
                          {{Auth::user()->nama}} | <b>username:</b> {{Auth::user()->username}} (<b>{{Auth::user()->level}}</b>) |  {{session()->get('namaproyek')}}
                      @endif  
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                     <li>
                        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Keluar </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>         
                  </ul>
                </li>
                   
              </ul>
            </nav>
          </div>
        </div>
    