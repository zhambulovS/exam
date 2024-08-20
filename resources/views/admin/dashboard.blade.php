@extends('layouts/admin/admin-temp')
@section('content')
    <h1>
        Subjects
    </h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubject">
       Add subject
    </button>
    {{--ADD SUBJECT MODAL--}}
    <div class="modal fade" id="addSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addSubjectForm" method="POST">
            @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label>Subject: </label>
                        <input type="text" name="subject" placeholder="Enter subject name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{--  EDIT MODAL  --}}
    <div class="modal fade" id="editSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editSubjectForm" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label>Subject: </label>
                            <input type="text" name="subject" id="edit_subject" placeholder="Enter subject name" required>
                            <input type="hidden" name="id" id="edit_subject_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    {{--  DELETE MODAL  --}}
    <div class="modal fade" id="deleteSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteSubjectForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure delete this subject?</p>
                        <input type="hidden" name="id" id="delete_subject_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{--  SUBJECTS TABLE  --}}
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Subjects</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
            @if(count($subjects)>0)
                @foreach($subjects as $subject)
                    <tr>
                        <th scope="row">{{$subject->id}}</th>
                        <td>{{$subject->subject}}</td>
                        <td><button class="btn btn-info editButtonSubject" data-bs-toggle="modal" data-bs-target="#editSubject" data-id="{{$subject->id}}" data-subject="{{$subject->subject}}">Edit</button></td>
                        <td><button class="btn btn-danger deleteButtonSubject" data-bs-toggle="modal" data-bs-target="#deleteSubject" data-id="{{$subject->id}}">Delete</button></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

@endsection
