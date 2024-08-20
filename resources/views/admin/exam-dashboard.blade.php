@extends('layouts/admin/admin-temp')
@section('content')
    <h1>
        Exams
    </h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubject">
        Add exam
    </button>
    {{--ADD SUBJECT MODAL--}}
    <div class="modal fade" id="addSubject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add exam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addExamForm" method="POST">
                        @csrf
                    <div class="modal-body">
                        <input class="w-100" type="text" name="exam_name" placeholder="Enter exam name" required>
                        <br><br>
                        <select name="subject_id" required class="w-100">
                            <option value="">Select subject</option>
                            @if(count($subjects)>0)
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                @endforeach
                            @endif
                        </select>
                        <br><br>
                        <input type="date" name="date" class="w-100" required>
                        <br><br>
                        <input type="time" name="time" class="w-100" required>
                        <br><br>
                        <input type="number" name="attempt" class="w-100" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    </form>
                </div>
        </div>
    </div>
    {{--  EDIT MODAL  --}}
    <div class="modal fade" id="editExam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editExamForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="exam_id">
                        <input class="w-100" id="exam_name" type="text" name="exam_name" placeholder="Enter exam name" required>
                        <br><br>
                        <select name="subject_id" id="subject_id" required class="w-100">
                            <option value="">Select subject</option>
                            @if(count($subjects)>0)
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                @endforeach
                            @endif
                        </select>
                        <br><br>
                        <input type="date" name="date" id="date" class="w-100" required>
                        <br><br>
                        <input type="time" name="time" id="time" class="w-100" required>
                        <br><br>
                        <input type="number" name="attempt" id="attempt" class="w-100" required>
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
    <div class="modal fade" id="deleteExam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteExamForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="deleteExamId">
                        <p>Are you sure delete this subject?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Exam</th>
            <th scope="col">Subject</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Attempt</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @if(count($exams)>0)
            @foreach($exams as $exam)
                <tr>
                    <th scope="row">{{ $exam->id }}</th>
                    <td> {{ $exam->exam_name }}</td>
                    <td> {{ $exam->subject[0]['subject'] }}</td>
                    <td> {{ \Carbon\Carbon::parse($exam->date)->format('d-m-Y') }} </td>
                    <td> {{ $exam->time }} </td>
                    <td> {{ $exam->attempt }} </td>
                    <td><button class="btn btn-info editButtonExam" data-bs-toggle="modal" data-bs-target="#editExam" data-id="{{$exam->id}}">Edit</button></td>
                    <td><button class="btn btn-danger deleteButtonExam" data-bs-toggle="modal" data-bs-target="#deleteExam" data-id="{{$exam->id}}">Delete</button></td>
                </tr>
            @endforeach
            @else
            <tr>  <td colspan="5">Exams not found! </td> </tr>
        @endif
        </tbody>
    </table>

@endsection
