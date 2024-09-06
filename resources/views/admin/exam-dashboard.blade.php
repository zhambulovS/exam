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
    {{--    ADD QUESTION --}}
        <div class="modal fade" id="addAnswer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Q&A</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addQNA" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="exam_id" id="addExamId">
                            <input type="search" name="search" class="w-100" id="search" onkeyup="searchTable()" placeholder="Search here">
                            <table class="table" id="questionsTable" >
                                <thead>
                                    <th>Select</th>
                                    <th>Question</th>
                                </thead>
                                <tbody class="addBody">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--    SEE QUESTION --}}
        <div class="modal fade" id="seeAnswer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">See Q&A</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body">
                            <table class="table" id="questionsTable" >
                                <thead><th>#</th><th>Question</th><th>Delete</th></thead>
                                <tbody class="seeQuestionTable"></tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
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
                <th scope="col">Add question</th>
                <th scope="col">Show question</th>
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
                        <td> {{ $exam->attempt }}</td>
                        <td> <a href="#" class="addQuestion" data-id="{{$exam->id}}" data-bs-toggle="modal" data-bs-target="#addAnswer">Add answer</a> </td>
                        <td> <a href="#" class="seeQuestion" data-id="{{$exam->id}}" data-bs-toggle="modal" data-bs-target="#seeAnswer">Show answer</a> </td>
                        <td><button class="btn btn-info editButtonExam" data-bs-toggle="modal" data-bs-target="#editExam" data-id="{{$exam->id}}">Edit</button></td>
                        <td><button class="btn btn-danger deleteButtonExam" data-bs-toggle="modal" data-bs-target="#deleteExam" data-id="{{$exam->id}}">Delete</button></td>
                    </tr>
                @endforeach
                @else
                <tr>  <td colspan="5">Exams not found! </td> </tr>
            @endif
            </tbody>
        </table>

        <script>
            $(document).ready(function (){
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

                $('.addQuestion').click(function () {
                    var id = $(this).attr('data-id');
                    $('#addExamId').val(id);

                    $.ajax({
                        url: "{{route('getQuestions')}}",
                        type: "GET",
                        data: {exam_id: id},
                        success: function (data) {
                            if (data.success == true) {
                                var questions = data.data;
                                var html = '';
                                if (questions.length > 0) {
                                    for (let i = 0; i < questions.length; i++) {
                                        html += `<tr>
                                <td><input type="checkbox" value="`+questions[i]['id']+`" name="questions_ids[]"
                                    `+(questions[i]['selected'] ? 'checked' : '')+`></td>
                                <td>`+questions[i]['question']+`</td>
                            </tr>`;
                                    }
                                } else {
                                    html += `
                            <tr>
                                <td colspan="2">Questions not available</td>
                            </tr>
                        `;
                                }
                                $('.addBody').html(html);
                            } else {
                                alert(data.msg);
                            }
                        }
                    });
                });
                $('#addQNA').submit(function (e){
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url: "{{route('addQuestions')}}",
                        type: "GET",
                        data: formData,
                        success: function (data){
                            if(data.success==true){
                                location.reload();
                            }else{
                                alert(data.msg);
                            }
                        }
                    });
                });
                $('.seeQuestion').click(function (){
                    var id = $(this).attr('data-id');
                    $.ajax({
                        url:"{{route('getExamQuestions')}}",
                        type:"GET",
                        data:{exam_id: id},
                        success:function (data){
                            var html = "";
                            var questions = data.data;
                            if (questions.length > 0) {
                                for (let i = 0; i < questions.length; i++) {
                                    html += ` <tr>
                                        <td>`+(i+1)+`</td>
                                        <td>`+questions[i]['question'][0]['question']+`</td>
                                        <td><button class="btn btn-danger deleteQuestion" data-id="`+questions[i]['id']+`"> Delete
                                            </button></td>
                                    </tr>`
                                }
                            } else {
                                html += `
                            <tr>
                                <td colspan="2">Questions not available</td>
                            </tr>
                        `;
                            }
                            $('.seeQuestionTable').html(html);
                        }
                    });
                });

                $(document).on('click', '.deleteQuestion', function (){
                    var id = $(this).attr('data-id');
                    var obj = $(this);
                    $.ajax({
                        url:"{{route('deleteExamQuestions')}}",
                        type:"GET",
                        data:{id:id},
                        success:function (data){
                            if(data.success==true){
                                obj.parent().parent().remove();
                            }else{
                                alert(data.msg);
                            }
                        }
                    });

                });
            });
        </script>

        <script>
            function searchTable(){
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById('search');
                filter = input.value.toUpperCase();
                table = document.getElementById('questionsTable');
                tr = table.getElementsByTagName('tr');
                for(i=0;i<tr.length;i++){
                    td = tr[i].getElementsByTagName('td')[1];
                        if(td){
                            txtValue = td.textContent||td.innerText;
                            if(txtValue.toUpperCase().indexOf(filter)>-1){
                                tr[i].style.display="";
                            }else{
                                tr[i].style.display = "none";
                            }
                        }
                }
            }
        </script>
    @endsection
