<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <title>Examination app</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/admin/style.css')}}">
</head>
<body>

<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>
        <h1><a href="{{route('admin.dashboard')}}" class="logo">Admin dashboard</a></h1>
        <ul class="list-unstyled components mb-5">
            <li>
                <a href="#"><span class="fa fa-book mr-3"></span> Subjects</a>
            </li>
            <li>
                <a href="{{route('logout')}}"><span class="fa fa-sign-out mr-3"></span> Logout</a>
            </li>
        </ul>
    </nav>

    <div id="content" class="p-4 p-md-5 pt-5">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('assets/js/admin/popper.js')}}"></script>
<script src="{{asset('assets/js/admin/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/admin/main.js')}}"></script>

<script>
    $(document).ready(function (){
        $('#addSubjectForm').submit(function (e) {
            e.preventDefault();

            var formData = $(this).serialize();
            console.log(formData); // Check the serialized data

            $.ajax({
                url: "{{ route('addSubject') }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    console.log(data); // Log the response
                    if (data.success == true) {
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                }

            });
        });
    });



</script>

</body>
</html>
