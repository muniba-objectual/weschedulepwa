<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>We-Schedule.ca</title>
    <meta name="description" content="We-Schedule.ca">
    <meta name="keywords" content="We-Schedule.ca" />
    <link rel="icon" type="image/png" href="/mobilekit/assets/img/icon/favicon-32x32.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="/mobilekit/assets/img/icon/apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="/mobilekit/assets/css/style.css">
    <link rel="manifest" href="/mobilekit/__manifest.json">


</head>

    <body>

        <!-- loader -->
        <div id="loader">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
        <!-- * loader -->

        <!-- App Header -->
        @yield('header')
        <!-- * App Header -->

        <!-- Search Component -->
        <!--
        <div id="search" class="appHeader">
            <form class="search-form">
                <div class="form-group searchbox">
                    <input type="text" class="form-control" placeholder="Search...">
                    <i class="input-icon">
                        <ion-icon name="search-outline"></ion-icon>
                    </i>
                    <a href="#" class="ms-1 close toggle-searchbox">
                        <ion-icon name="close-circle"></ion-icon>
                    </a>
                </div>
            </form>
        </div>
    -->
        <!-- * Search Component -->

        <!-- page body starts (template) -->
        <!-- App Capsule -->
        @yield('content')
        <!-- * App Capsule -->
        <!-- page body ends (template) -->

        <!-- App Footer -->




        <!-- App Bottom Menu -->

        <div class="appBottomMenu">
            <a href="/mobile" class="item active">
                <div class="col">
                    <!-- <ion-icon name="home-outline"></ion-icon> -->
                    <img width="" src="/mobilekit/assets/img/home.svg" class="mx-auto d-block"/>
                </div>
            </a>
           <!--
            <a href="#" class="item">
                <div class="col">
                    <ion-icon name="calendar-outline"></ion-icon>
                </div>
            </a>
            <a href="/#" class="item">
                <div class="col">
                    <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                    <span class="badge badge-danger">5</span>
                </div>
            </a>
            <a href="#" class="item">
                <div class="col">
                    <ion-icon name="cog-outline"></ion-icon>
                </div>
            </a>
            -->
            <a href="#sidebarPanel" class="item" data-bs-toggle="offcanvas">
                <div class="col">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </a>
        </div>
        <!-- * App Bottom Menu -->

        <!-- App Sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarPanel">
            <div class="offcanvas-body">
            <a href="#" class="close-sidebar-button" data-bs-dismiss="offcanvas">
                        <ion-icon name="close"></ion-icon>
                    </a>
                <!-- profile box -->
                <img width="50%" src="/img/ws_orig.png" class="mx-auto d-block mb-3 mt-3">
                <div class="profileBox text-basic">
                    <div class="image-wrapper">
                        @if (!$user->profile_pic)
                            <img src="/img/ws_icon.jpg" alt="avatar" class="imaged rounded" />
                        @else
                            <img src="/storage/profile_pic/{{substr($user->profile_pic,20)}}" alt="avatar" class="imaged rounded">
                        @endif
                    </div>
                    <div class="in">
                        <strong>{{$user->name}}</strong>
                        <div class="text-muted">
                            <ion-icon name="timer"></ion-icon>
                            {{$user->get_user_type->name}}
                        </div>
                    </div>
                  
                </div>
                <!-- * profile box -->

                <ul class="listview flush transparent no-line image-listview mt-2 ios-detection">
                    <li>
                        <a href="/mobile" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="home-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Dashboard
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/mobile/MyProfile/{{$user->id}}" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="person-circle-outline"></ion-icon>
                            </div>
                            <div class="in">
                                My Profile
                            </div>
                        </a>
                    </li>

                    @if(true)
                        <li>
                            <a href="{{route('mobile.expenses.index')}}" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="cash-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    My Expenses
                                </div>
                            </a>
                        </li>
                    @endif

                    <!--
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Shifts
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Messages</div>
                                <span class="badge badge-danger">5</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="cog-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Settings</div>

                            </div>
                        </a>
                    </li>
                   -->
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="moon-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Dark Mode</div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input dark-mode-switch" type="checkbox" id="darkmodesidebar">
                                    <label class="form-check-label" for="darkmodesidebar"></label>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <a href="javascript:iosAddtoHome()" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="add-circle-outline"></ion-icon>
                            </div>
                            <div class="none">
                                <div>Add App to Home Screen</div>
                            </div>
                        </a>
                    </li>

                </ul>

                <ul class="listview flush transparent no-line image-listview mt-2 android-detection">
                    <li>
                        <a href="/mobile" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="home-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Dashboard
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/mobile/MyProfile/{{$user->id}}" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="person-circle-outline"></ion-icon>
                            </div>
                            <div class="in">
                                My Profile
                            </div>
                        </a>
                    </li>

                    @if(true)
                        <li>
                            <a href="{{route('mobile.expenses.index')}}" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="cash-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    My Expenses
                                </div>
                            </a>
                        </li>
                    @endif

                    <!--
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Shifts
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Messages</div>
                                <span class="badge badge-danger">5</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="cog-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Settings</div>

                            </div>
                        </a>
                    </li>
                   -->
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="moon-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Dark Mode</div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input dark-mode-switch" type="checkbox" id="darkmodesidebar">
                                    <label class="form-check-label" for="darkmodesidebar"></label>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <a href="javascript:androidAddtoHome()" class="item">

                            <div class="icon-box bg-primary">
                                <ion-icon name="add-circle-outline"></ion-icon>
                            </div>
                            <div class="none">
                                <div class="font-basic">Add App to Home Screen</div>

                            </div>
                        </a>
                    </li>

                </ul>

                <ul class="listview flush transparent no-line image-listview mt-2 non-mobile-detection">
                    <li>
                        <a href="/mobile" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="home-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Dashboard
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="/mobile/MyProfile/{{$user->id}}" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="person-circle-outline"></ion-icon>
                            </div>
                            <div class="in">
                                My Profile
                            </div>
                        </a>
                    </li>

                    @if(true)
                        <li>
                            <a href="{{route('mobile.expenses.index')}}" class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="cash-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    My Expenses
                                </div>
                            </a>
                        </li>
                    @endif

                    <!--
                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Shifts
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Messages</div>
                                <span class="badge badge-danger">5</span>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="cog-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Settings</div>

                            </div>
                        </a>
                    </li>
                   -->

                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="moon-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Dark Mode</div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input dark-mode-switch" type="checkbox" id="darkmodesidebar">
                                    <label class="form-check-label" for="darkmodesidebar"></label>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>

            </div>
            <!-- sidebar buttons -->
            <div class="sidebar-buttons">
                <!--
                <a href="#" class="button">
                    <ion-icon name="person-outline"></ion-icon>
                </a>
                <a href="#" class="button">
                    <ion-icon name="archive-outline"></ion-icon>
                </a>


    -->



                <a href="{{ route('mobilelogout') }}" class="button">
                    <ion-icon name="log-out-outline"></ion-icon>
                </a>
            </div>
            <!-- * sidebar buttons -->
        </div>
        <!-- * App Sidebar -->


        <!-- add to home -->
        <!-- iOS Add to Home Action Sheet -->
        <div class="offcanvas offcanvas-bottom action-sheet inset ios-add-to-home" tabindex="-1"
             id="ios-add-to-home-screen">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Add to Home Screen</h5>
                <a href="#" class="close-button" data-bs-dismiss="offcanvas">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="offcanvas-body">
                <div class="action-sheet-content text-center">
                    <div class="mb-1"><img src="/img/ws.png" alt="image" alt="image" class="imaged w48">
                    </div>
                    <h4>We-Schedule.ca</h4>
                    <div>
                        Install We-Schedule.ca on your iPhone's home screen.
                    </div>
                    <div>
                        Tap <ion-icon name="share-outline"></ion-icon> and Add to homescreen.
                    </div>
                </div>
            </div>
        </div>
        <!-- * iOS Add to Home Action Sheet -->


        <!-- Android Add to Home Action Sheet -->
        <div class="offcanvas offcanvas-top action-sheet inset android-add-to-home" tabindex="-1"
             id="android-add-to-home-screen">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Add to Home Screen</h5>
                <a href="#" class="close-button" data-bs-dismiss="offcanvas">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="offcanvas-body">
                <div class="action-sheet-content text-center">
                    <div class="mb-1"><img src="/img/ws.png" alt="image" alt="image" class="imaged w48">
                    </div>
                    <h4>We-Schedule.ca</h4>
                    <div>
                        Install We-Schedule.ca on your Android's home screen.
                    </div>
                    <div>
                        Tap <ion-icon name="ellipsis-vertical"></ion-icon> and Add to homescreen.
                    </div>
                </div>
            </div>
        </div>
        <!-- * Android Add to Home Action Sheet -->

        <!-- * add to home -->


        <!-- ============== Js Files ==============  -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="  crossorigin="anonymous"></script>

        <!-- Bootstrap -->
        <script src="/mobilekit/assets/js/lib/bootstrap.min.js"></script>
        <!-- Ionicons -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <!-- Splide -->
        <script src="/mobilekit/assets/js/plugins/splide/splide.min.js"></script>
        <!-- ProgressBar js -->
        <script src="/mobilekit/assets/js/plugins/progressbar-js/progressbar.min.js"></script>
        <!-- Base Js File -->
        <script src="/mobilekit/assets/js/base.js"></script>
        <!--<script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js" ></script>-->



    </body>

</html>
