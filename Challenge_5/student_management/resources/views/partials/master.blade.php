<!doctype html>
<html lang="en">
<head>
    <title>Student management system</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
        #page-content {
            padding-left: 0;
        }

        #sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0);
        }

    </style>
    @yield('style')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0">
    <a href="#" class="navbar-brand col-sm-3 col-md-2 mr-0">VCS School</a>
    <input class="form-control w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-item" role="button" href="{{ route('logout') }}">Sign out</a>
        </li>
    </ul>
</nav>


<div class="container-fluid">
    <div class="row">
        <nav id="sidebar" class="col-sm-3 col-md-2 bg-light">
            <div class="list-group">
                <a id="dashboard" href="" class="list-group-item list-group-item-action nav-button">Dashboard</a>
                <a id="student" href=" {{ route('students') }}"
                   class="list-group-item list-group-item-action nav-button">Student</a>
                <a id="teacher" href=" {{route('teachers')}} "
                   class="list-group-item list-group-item-action nav-button">Teacher</a>
                <a id="assignment" href="{{ route('assignment') }}"
                   class="list-group-item list-group-item-action nav-button">Assignment</a>
                <a id="challenge" href="{{ route('challenge') }}"
                   class="list-group-item list-group-item-action nav-button">Challenge</a>
                <a id="profile" href="{{ route('user.edit', ['id' => \Auth::id()]) }}"
                   class="list-group-item list-group-item-action nav-button">Profile</a>
            </div>
        </nav>

        <div id="page-content" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4 justify-content-center">
            @yield('content')
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    @yield('script')
</div>
</body>
