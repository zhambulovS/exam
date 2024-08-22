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
                <div class="modal-body">
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
                    $(".modal-body").append(html);
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
            $(document).on('click', '.remove-answer', function () {
                $(this).closest('.answers').remove();
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

        });
    </script>

@endsection
