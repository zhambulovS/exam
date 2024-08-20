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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    </form>
                </div>
        </div>
    </div>



@endsection
