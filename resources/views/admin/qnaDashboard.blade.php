@extends('layouts/admin/admin-temp')
@section('content')
<h1>Q&A</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQna">
    Add Q&A
</button>

<table class="table">
    <thead>
        <th>#</th>
        <th>Question</th>
        <th>Answers</th>
        <th>Edit</th>
        <th>Delete</th>
    </thead>
    <tbody>
    @if(count($questions)>0)
        @foreach($questions as $question)
            <tr>
            <td>{{$question->id}}</td>
            <td>{{$question->question}}</td>
                <td>
                    <a href="#" class="ansButton" data-id="{{$question->id}}" data-bs-toggle="modal" data-bs-target="#showAnsModal">See answers</a>
                </td>
                <td><button class="btn btn-primary editQnaButton" data-bs-toggle="modal" data-id="{{$question->id}}" data-bs-target="#editQnaBtn">Edit</button> </td>
                <td> <button class="btn btn-danger deleteQnaButton" data-bs-toggle="modal" data-id="{{$question->id}}" data-bs-target="#deleteQnaBtn">Delete</button></td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3">Questions & Answers not found!</td>
        </tr>
    @endif
    </tbody>
</table>

{{--ADD Q&A MODAL--}}
<div class="modal fade" id="addQna" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Q&A</h5>
                <button id="addAnswer" class="btn btn-primary ml-5">Add answer</button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addQnaForm" method="POST">
                @csrf
                <div class="modal-body addModalAns">
                    <div class="row">
                        <div class="col">
                            <input class="w-100" type="text" name="question" placeholder="Enter question" required>
                            <br><br>
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
{{--SHOW Q&A MODAL--}}
<div class="modal fade" id="showAnsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Show Answers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Answer</th>
                            <th>Is correct</th>
                        </thead>
                        <tbody class="showAnswers">

                        </tbody>
                    </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>
{{--Edit modal--}}
<div class="modal fade" id="editQnaBtn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Q&A</h5>
                <button id="addEditAnswer" class="btn btn-primary ml-5">Add answer</button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editQnaForm" method="POST">
                @csrf
                <div class="modal-body editAns">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="questions_id" id="questions_id">
                            <input class="w-100" id="question" type="text" name="question" placeholder="Enter question" required>
                            <br><br>
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
{{--DELETE QUESTION--}}
<div class="modal fade" id="deleteQnaBtn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteQnaForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure delete this question?</p>
                    <input type="hidden" name="id" id="delete_question_id">
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

            $("#addAnswer").click(function () {
                if($(".answers").length >= 6){
                    $(".error").text("You can add max 6 answers");
                    setTimeout(function () {
                        $(".error").text("");
                    }, 2000);
                }
                else {
                    var html = `
                    <div class="row mt-2 answers">
                        <div class="col-auto">
                            <input type="radio" name="is_correct" class="is_correct">
                        </div>
                        <div class="col">
                            <input class="w-100" type="text" name="answers[]" placeholder="Enter answer" required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger remove-answer">Remove</button>
                        </div>
                    </div>`;
                    $(".addModalAns").append(html);
                }
            });

            $('#addQnaForm').submit(function (e) {
                e.preventDefault();

                if ($(".answers").length < 2) {
                    $(".error").text("Please add a minimum of 2 answers");
                    setTimeout(function () {
                        $(".error").text("");
                    }, 2000);
                } else {
                    var checkIsCorrect = false;

                    $(".is_correct").each(function(index) {
                        if ($(this).prop('checked')) {
                            checkIsCorrect = true;
                            $(this).val($(this).closest('.answers').find('input[name="answers[]"]').val());
                        }
                    });

                    if (checkIsCorrect) {
                        var formData = $(this).serialize();
                        $.ajax({
                            url: "{{route('admin.addQna')}}",
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
                    } else {
                        $(".error").text("Please select anyone correct answer");
                        setTimeout(function () {
                            $(".error").text("");
                        }, 2000);
                    }
                }
            });

            $(".ansButton").click(function (){
                var questions = @json($questions);
                var qid = $(this).attr('data-id');
                var html = '';
                // console.log(questions);
                for(let i=0; i<questions.length; i++){
                    if(questions[i]['id']==qid){
                        var answersLength = questions[i]['answers'].length;
                        for(let j=0;j<answersLength;j++){
                            let is_correct = 'No';
                            if(questions[i]['answers'][j]['is_correct'] == 1){
                                is_correct = 'Yes';
                            }

                            html += `
                            <tr>
                            <td> `+(j+1)+` </td>
                            <td> `+questions[i]['answers'][j]['answers']+` </td>
                            <td>`+is_correct+`</td>
                            </tr>`;
                        }break
                    }
                }
                $(".showAnswers").html(html);
            });

            $("#addEditAnswer").click(function () {
                if($(".editAnswer").length >= 6){
                    $(".editError").text("You can add max 6 answers");
                    setTimeout(function () {
                        $(".error").text("");
                    }, 2000);
                }
                else {
                    var html = `
            <div class="row mt-2 editAnswer">
                <div class="col-auto">
                    <input type="radio" name="is_correct" class="edit_is_correct">
                </div>
                <div class="col">
                    <input class="w-100" type="text" name="answers[]" placeholder="Enter answer" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove_edit_answer">Remove</button>
                </div>
            </div>`;
                    $(".editAns").append(html);
                }
            });

            $(".editQnaButton").click(function (){
                var qid = $(this).attr('data-id');
                $.ajax({
                    url:"{{route('getQnaDetail')}}",
                    type: "GET",
                    data: {qid:qid},
                    success: function (data){
                        var qna = data.data[0];
                        $("#questions_id").val(qna['id']);
                        $("#question").val(qna['question']);
                        $(".editAnswer").remove();
                        var html = '';
                        for (let i=0;i<qna['answers'].length;i++){
                            var checked = '';
                            if(qna['answers'][i]['is_correct']==1){
                                checked = 'checked';
                            }
                            html += `
                        <div class="row mt-2 editAnswer">
                            <div class="col-auto">
                                <input type="radio" name="is_correct" class="edit_is_correct"`+checked+` >
                            </div>
                            <div class="col">
                                <input class="w-100" type="text" name="answers[`+qna['answers'][i]['id']+`]"
                        placeholder="Enter answer" value="`+qna['answers'][i]['answers']+`" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger remove_answer remove" data-id="`+qna['answers'][i]['id']+`" >Remove</button>
                            </div>
                        </div>
                            `;
                        }
                        $(".editAns").append(html);
                    }
                });
            });
            $("#editQnaForm").submit(function (e) {
                e.preventDefault();

                if($(".editAnswer").length < 2){
                    $(".editError").text("Please add minimum 2 answers");
                    setTimeout(function () {
                        $(".editError").text("");
                    }, 2000);
                }
                else {
                    var checkIsCorrect = false;

                    $(".edit_is_correct").each(function(index) {
                        if ($(this).prop('checked')) {
                            checkIsCorrect = true;
                            // Привязка значения радиокнопки к значению текстового поля
                            var correspondingAnswer = $(this).closest('.editAnswer').find('input[name^="answers"]');
                            $(this).val(correspondingAnswer.val());
                        }
                    });

                    if(checkIsCorrect){
                        var formData = $(this).serialize();
                        $.ajax({
                            url:"{{route('updateAns')}}",
                            type:"POST",
                            data:formData,
                            success:function (data){
                                if(data.success==true){
                                    location.reload();
                                }else{
                                    alert(data.msg);
                                }
                            }
                        });
                    }else {
                        $(".editError").text("Please select anyone correct answer");
                        setTimeout(function () {
                            $(".editError").text("");
                        }, 2000);
                    }
                }
            });

            $(document).on('click', '.remove',function (){
                $(this).closest('.answers').remove();
               var ansId = $(this).attr('data-id');
               $.ajax({
                   url:"{{route('deleteAns')}}",
                   type:"GET",
                   data:{id:ansId},
                   success:function (data){
                       if(data.success==true){
                           location.reload()
                       }else{
                           alert(data.msg);
                       }
                   }
               });
            });
            $(document).on('click', '.remove_edit_answer', function () {
                $(this).closest('.editAnswer').remove();
            });
            $(document).on('click', '.remove-answer', function () {
                $(this).closest('.answers').remove();
            });

            $('.deleteQnaButton').click(function (){
                var id = $(this).attr('data-id');
                $('#delete_question_id').val(id);
            });
            $('#deleteQnaForm').submit(function (e){
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('deleteQnaAns') }}",
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
