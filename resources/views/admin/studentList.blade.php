@extends('layouts/admin/admin-temp')
@section('content')
    <h1>Students</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
        Add student
    </button>
    <table class="table">
        <thead>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Edit</th>
        <th>Delete</th>
        </thead>
        <tbody>
        @if(count($students)>0)
            @foreach($students as $student)
                <tr>
                    <td>{{$student->id}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->email}}</td>
                    <td><button class="btn btn-primary editButton" data-bs-toggle="modal" data-id="{{$student->id}}" data-name="{{$student->name}}" data-email="{{$student->email}}" data-bs-target="#editUserBtn">Edit</button> </td>
                    <td> <button class="btn btn-danger deleteButton" data-bs-toggle="modal" data-id="{{$student->id}}" data-name="{{$student->name}}" data-email="{{$student->email}}" data-bs-target="#deleteUserBtn">Delete</button></td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3">Students not found!</td>
            </tr>
        @endif
        </tbody>
    </table>
    {{--ADD USER MODAL--}}
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addUserForm" method="POST">
                    @csrf
                    <div class="modal-body AddUserModalBody">
                        <div class="row">
                            <div class="col">
                                <input class="w-100" type="text" name="name" placeholder="Enter new student name" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input class="w-100" type="text" name="email" placeholder="Enter new student email" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color: red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--Edit modal--}}
    <div class="modal fade" id="editUserBtn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    <div class="modal-body editStudent">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="id">
                                <input class="w-100" type="text" id="name" name="name" placeholder="Edit student name" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input class="w-100" type="text" id="email" name="email" placeholder="Edit student email" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="editError" style="color: red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{--    DELETE STUDENT--}}
    <div class="modal fade" id="deleteUserBtn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteUserForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure delete this student?</p>
                        <input type="hidden" name="id" id="student_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function (){
            $("#addUserForm").submit(function (e){
                e.preventDefault();

                var formData = $(this).serialize();
                $.ajax({
                    url:"{{route('addStudent')}}",
                    type: "POST",
                    data: formData,
                    success: function (data){
                        if (data.success==true){
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });

            $(".editButton").click(function (){
                $("#id").val( $(this).attr('data-id') );
                $("#name").val( $(this).attr('data-name') );
                $("#email").val( $(this).attr('data-email') );
            });

            $("#editUserForm").submit(function (e){
                e.preventDefault();
                $('.updateButton').prop('disable', true);
                var formData = $(this).serialize();
                $.ajax({
                    url:"{{route('editStudent')}}",
                    type: "POST",
                    data: formData,
                    success: function (data){
                        if (data.success==true){
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });
            $('.deleteButton').click(function (){
                var id = $(this).attr('data-id');
                $('#student_id').val(id);
            });
            $('#deleteUserForm').submit(function (e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('deleteStudent') }}",
                    type: "POST",
                    data: formData,
                    success: function (data) {
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

@endsection
