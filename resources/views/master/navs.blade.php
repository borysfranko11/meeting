<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i></div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
            <!-- <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> -->
        <!-- <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> 
            </div>
        </nav> -->
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="/assets/img/u3.png" /></span>
                    <!-- <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"><strong class="font-bold">{{$user["name"]}}</strong></span>
                            <span class="text-muted text-xs block">{{$user["role"]}}<b class="caret"></b></span>
                        </span>
                    </a> -->
                    <!-- <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a class="J_menuItem" href="/User/profile/id/{{$user["id"]}}"><span class="nav-label">修改头像</span></a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="/User/personal/id/{{$user["id"]}}"><span class="nav-label">个人资料</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/Login/out">安全退出</a>
                        </li>
                    </ul> -->
                </div>
                <div class="logo-element">会唐网</div>
            </li>
            @foreach( $navs as $key => $nav )
                @if( empty( $nav["son"] ) )
                    <li>
                        <a class="J_menuItem" href="{{$nav["url"]}}">
                            <i class="{{$nav["icon"]}}"></i> <span class="nav-label">
                                @if( App::getLocale() =='en' )
                                {{$nav["alias"]}}
                                @else
                                {{$nav["name"]}}
                                @endif
                            </span>
                            @if( !empty( $nav["notice"] ) )
                                <span class="label label-warning pull-right">{{$nav["notice"]}}</span>
                            @endif
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{$nav["url"]}}">
                            <i class="{{$nav["icon"]}}"></i>
                            <span class="nav-label">
                                  @if( App::getLocale() =='en' )
                                    {{$nav["alias"]}}
                                @else
                                    {{$nav["name"]}}
                                @endif
                            </span>
                            @if( !empty( $nav["notice"] ) )
                                <span class="label label-warning pull-right">{{$nav["notice"]}}</span>
                                @else
                                <span class="fa arrow"></span>
                            @endif
                        </a>
                        <ul class="nav nav-second-level">
                            @foreach( $nav["son"] as $k_2 => $level2 )
                                <li>
                                    <a class="J_menuItem" href="{{$level2["url"]}}">
                                        <i class="{{$level2["icon"]}}"></i> <span class="nav-label">
                                              @if( App::getLocale() =='en' )
                                                {{$level2["alias"]}}
                                            @else
                                                {{$level2["name"]}}
                                            @endif
                                            </span>
                                        @if( !empty( $level2["notice"] ) )
                                            <span class="label label-warning pull-right">{{$level2["notice"]}}</span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary packUp " href="#"><i class="fa fa-bars"></i> </a> 
</nav>
