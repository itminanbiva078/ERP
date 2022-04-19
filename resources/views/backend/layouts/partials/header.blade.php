<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-border-all"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href=" " class="nav-link"> Tracking</a>
        </li>
    </ul>

    <ul class="quick_access_btn">
        <li>
            <a href="#" class="btn btn-sm"> <i class="fab fa-sellsy"></i> Sell </a>
        </li>
        <li>
            <a href="#" class="btn btn-sm"> <i class="fab fa-opencart"></i> purchase </a>
        </li>
        <li>
            <a href="#" class="btn btn-sm"> <i class="fas fa-boxes"></i> Product's </a>
        </li>
        <li>
            <a href="#" class="btn btn-sm"> <i class="fas fa-crosshairs"></i> pos management </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item notificaton-box-section">
            <button class="btn" id="notification-btn">
                <span class="badge"> (59)</span>
                <i class="fas fa-bell"></i>
            </button>
            <!-- <a class="nav-link" data-widget="notification" href="#"  role="button">
                
            </a> -->
            <div class="notification-list" id="notification-container">
                <div class="notification-header">
                    <p> Notification  </p>
                </div>
                <ul>  
                    <li class="single-notification">
                        <a href="#">
                            <div class="notification-items">
                                <div class="section-icon">
                                    <i class="fas fa-gifts"></i>
                                </div>
                                <div class="section-contant">
                                    <h5> test notification items </h5>
                                </div>
                                <div class="notification-remove">
                                    <button class="btn btn-sm notification-remove-btn" > <i class="far fa-times-circle"></i> </button>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="single-notification">
                        <a href="#">
                            <div class="notification-items">
                                <div class="section-icon">
                                    <i class="fas fa-gifts"></i>
                                </div>
                                <div class="section-contant">
                                    <h5> test notification items </h5>
                                </div>
                                <div class="notification-remove">
                                    <button class="btn btn-sm notification-remove-btn"> <i class="far fa-times-circle"></i> </button>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="single-notification">
                        <a href="#">
                            <div class="notification-items">
                                <div class="section-icon">
                                    <i class="fas fa-gifts"></i>
                                </div>
                                <div class="section-contant">
                                    <h5> test notification items </h5>
                                </div>
                                <div class="notification-remove">
                                    <button class="btn btn-sm notification-remove-btn"> <i class="far fa-times-circle"></i> </button>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="single-notification">
                        <a href="#">
                            <div class="notification-items">
                                <div class="section-icon">
                                    <i class="fas fa-gifts"></i>
                                </div>
                                <div class="section-contant">
                                    <h5> test notification items </h5>
                                </div>
                                <div class="notification-remove">
                                    <button class="btn btn-sm notification-remove-btn"> <i class="far fa-times-circle"></i> </button>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="single-notification">
                        <a href="#">
                            <div class="notification-items">
                                <div class="section-icon">
                                    <i class="fas fa-gifts"></i>
                                </div>
                                <div class="section-contant">
                                    <h5> test notification items </h5>
                                </div>
                                <div class="notification-remove">
                                    <button class="btn btn-sm notification-remove-btn"> <i class="far fa-times-circle"> </i> </button>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="single-notification">
                        <a href="#">
                            <div class="notification-items">
                                <div class="section-icon">
                                    <i class="fas fa-gifts"></i>
                                </div>
                                <div class="section-contant">
                                    <h5> test notification items </h5>
                                </div>
                                <div class="notification-remove">
                                    <button class="btn btn-sm notification-remove-btn"> <i class="far fa-times-circle"> </i> </button>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="single-notification">
                        <a href="#">
                            <div class="notification-items">
                                <div class="section-icon">
                                    <i class="fas fa-gifts"></i>
                                </div>
                                <div class="section-contant">
                                    <h5> test notification items </h5>
                                </div>
                                <div class="notification-remove">
                                    <button class="btn btn-sm notification-remove-btn"> <i class="far fa-times-circle"> </i> </button>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="see-all-notification">
                    <a href="#" class="btn"> see all notication </a>
                </div>
            </div>
        </li>
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- <img src="{{ asset('backend/assets/image/logo.png') }}" class="user-image" alt="Company Logo"> -->
                <span class="hidden-xs"> {{ Auth()->user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header  bg-info">
                    <img src="{{ asset('backend/assets/image/logo.png') }}" class="img-circle" alt="User Image"> 
                    <p>
                        {{ Auth()->user()->name}}
                        <small>Member since Nov. 2012</small>
                    </p>
                </li>
                <!-- Menu Body -->

                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-right">
                        <a class="btn btn-default btn-flat btn-block" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('admin-logout-form').submit();">Log Out</a>
                        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </li>
        <li class="nav-item full-screen">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item" id="colorDynamicMenu">
            <a href="#" class="nav-link" >
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
