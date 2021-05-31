<head>
    <meta charset="utf-8">

    <title>News App</title>
    <meta name="description" content="The News Application to wacth the latest news">
    <meta name="author" content="SitePoint">
    <link href="{{asset("assets/fontawesome/fontawesome.css",env("APP_ASSETS"))}}" rel="stylesheet">
    <script src="{{asset('assets/jquery/jquery.min.js',env("APP_ASSETS"))}}" crossorigin="anonymous"></script>
    <link href="{{asset('assets/boostrap/css/bootstrap.min.css',env("APP_ASSETS"))}}" rel="stylesheet" crossorigin="anonymous">
    <script src="{{asset('assets/boostrap/js/bootstrap.min.js',env("APP_ASSETS"))}}" crossorigin="anonymous"></script>
    <link href="{{asset('assets/css/application.css',env("APP_ASSETS"))}}" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        /* change font in top and bottom */
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .ui-button {
            color: red;
            font-family: 'courier'
        }

        /* change "height" caused by exaggerated padding */
        .dataTables_wrapper .ui-toolbar {
            padding: 0px;
        }

        .page-item.active .page-link {
            background-color: lightgrey !important;
            border: 1px solid black;
        }

        .page-link {
            color: black !important;
        }
    </style>
</head>
<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{url("top-headlines")}}"><img
                src="https://image.shutterstock.com/image-vector/illustration-flat-icon-tv-channel-600w-482689633.jpg"
                alt="Logo" height="40" width="40"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav w-100">
                <li class="nav-item active">
                    <a class="nav-link form-control-lg" href="{{url("top-headlines")}}">Top Headlines <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link form-control-lg" href="{{url("explore")}}">Explore</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link form-control-lg" href="{{url("followedKeywords")}}">Following Topics </a>
                </li>

                <li class="nav-item dropdown ml-auto">

                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false"> <span>{{auth()->user()->name}}</span>
                        <img
                            src="{{auth()->user()->avatar}}"
                            width="40" height="40" class="rounded-circle"> </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</header>
