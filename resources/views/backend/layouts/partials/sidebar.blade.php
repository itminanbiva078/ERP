@php
use App\Helpers\Helper;
$allNavigations = explode(",",Helper::getRoleAccessParent());
$parentMenu =
App\Models\Navigation::select('id','label','icon')->whereIn('id',Helper::getRoleRootList())->get();
$activeClass = Helper::getMenuParent(Route::currentRouteName());
@endphp

<aside class=" elevation-4    main-sidebar elevation-4 sidebar-light-danger">
    <div class="sidebar_top_profile">
        <div class="container-fluid">
            <div class="user_profile_section">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <div class="profile_img">
                            <a href="{{ route('home') }}">
                                <img src="https://www.pngarts.com/files/8/Github-Logo-PNG-Transparent-Image.png" alt="">
                            </a>
                        </div> -->
                        <!-- <div class="profile_img_mini">
                            <a href="#">
                                {{-- <img src="http://127.0.0.1:8000/backend/assets/image/logo.png" alt=""> --}}
                            </a>
                        </div> -->
                        <div class="profile_information">
                            <a href="#">MASTER ERP</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar" id="main_admin_sidebar_section">
        <nav class="mt-2" id="main-sidebar-section">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item active">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="fas fa-border-all"></i>
                        <p>  Dashboard </p>
                    </a>
                </li>
                @foreach($parentMenu as $key => $value)
                @php
                $subMenu =
                App\Models\Navigation::select('id','label','icon')->where('active',1)->where('parent_id',$value->id)->whereIn('id',$allNavigations)->get();
                @endphp
                    <li id="{{str_replace(' ','_',$value->label)}}" class="nav-item ">
                        <a href="#" class="nav-link">
                            <i class="fas {{$value->icon}} "></i>
                            <p>
                                {{ucfirst($value->label)}}
                                <i class=" right fas fa-angle-right"></i>
                            </p>
                        </a>
                        @if(!empty($subMenu))
                            <ul class="nav nav-treeview">
                                @foreach($subMenu as $key => $childMenu)
                                    @php
                                        $childInfo =
                                        App\Models\Navigation::select('route')->where('parent_id',$childMenu->id)->where('navigate_status',1)->first();
                                    @endphp
                                @if(!empty($childInfo))
                                    <li class="nav-item">
                                        <a href="{{ route($childInfo->route) }}"
                                            class="nav-link {{str_replace(' ','_',$childMenu->label)}}">
                                            <i class="far fa-circle"></i>
                                            <p>{{ucfirst($childMenu->label) }}</p>
                                        </a>
                                    </li>
                                @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>

<script>
    document.getElementById('<?php echo $activeClass; ?>').classList.add('menu-open');
</script>