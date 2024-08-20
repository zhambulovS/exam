<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <title>Examination</title>
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
                <a href="{{route('admin.dashboard')}}"><span class="fa fa-book mr-3"></span> Subjects</a>
            </li>
            <li>
                <a href="{{route('admin.examDashboard')}}"><span class="fa fa-desktop mr-3"></span> Exams</a>
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
            $.ajax({
                url: "{{ route('addSubject') }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    if (data.success == true) {
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                }

            });
        });
    });

        $('#editSubjectForm').submit(function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('editSubject') }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    if (data.success == true) {
                        location.reload();
                    } else {
                        alert(data.msg);
                    }
                }
            });
        });
        $(".editButtonSubject").click(function () {
            var subject_id = $(this).attr('data-id');
            var subject = $(this).attr('data-subject');
            $("#edit_subject").val(subject);
            $("#edit_subject_id").val(subject_id);  // Use the correct input ID
        });

    $('#deleteSubjectForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('deleteSubject') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data){
                if (data.success == true) {
                    location.reload();
                } else {
                    alert(data.msg);
                }
            }
        });
    });
    $(".deleteButtonSubject").click(function () {
        var subject_id = $(this).attr('data-id');
        $("#delete_subject_id").val(subject_id);  // Use the correct input ID
    });

    $('#addExamForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('addExam') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data){
                if (data.success == true) {
                    location.reload();
                } else {
                    alert(data.msg);
                }
            }
        });
    });

    $('#editExamForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('editExam') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data){
                if (data.success == true) {
                    location.reload();
                } else {
                    alert(data.msg);
                }
            }
        });
    });
    $(".editButtonExam").click(function () {
        var id = $(this).attr('data-id');
        $("#exam_id").val(id);

        var url = '{{route("getExamDetail", "id")}}';
        url = url.replace('id', id);

        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                if (data.success == true) {
                    var exam = data.data[0];
                    $("#exam_name").val(exam.exam_name);
                    $("#subject_id").val(exam.subject_id);
                    $("#date").val(exam.date);
                    $("#time").val(exam.time);
                    $("#attempt").val(exam.attempt);
                } else {
                    alert(data.msg);
                }
            }
        });
    });

    $('#deleteExamForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('deleteExam') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data){
                if (data.success == true) {
                    location.reload();
                } else {
                    alert(data.msg);
                }
            }
        });
    });
    $(".deleteButtonExam").click(function () {
        var id = $(this).attr('data-id');
        $("#deleteExamId").val(id);
    });

</script>
</body>
</html>
