@extends('layouts/admin/admin-temp')
@section('content')

    <h1 class="mb-4">Exams Reviews</h1>

    <table class="table">
        <thead>
        <th>#</th>
        <th>Name</th>
        <th>Exam </th>
        <th>Status</th>
        <th>Review</th>
        </thead>
        <tbody>
        @if(count($attempts)>0)
            @php $x=1; @endphp
            @foreach($attempts as $attempt)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$attempt->user->name}}</td>
                    <td>{{$attempt->exam->exam_name}}</td>
                    <td>
                        @if($attempt->status == 0)
                            <span style="color: red">Pending</span>
                        @else
                            <span style="color: green">Approved</span>
                        @endif
                    </td>
                    <td>
                        @if($attempt->status == 0)
                            <a href="" class="reviewExam" data-bs-toggle="modal" data-id="{{$attempt->id}}" data-bs-target="#reviewExamModal">Review & Approved</a>
                        @else
                           Completed!
                        @endif

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">Student not attempt exam!</td>
            </tr>
        @endif
        </tbody>
    </table>
{{--MODAL--}}
    <div class="modal fade" id="reviewExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="reviewExamForm">
                @csrf
                <input type="hidden" name="attempt_id" id="attempt_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Review Exam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body review">
                        <label>Loading... </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Approved</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function (){
            $('.reviewExam').click(function (){
                var id = $(this).attr('data-id');
                $('#attempt_id').val(id);

                $.ajax({
                    url:"{{route('reviewQna')}}",
                    type:"GET",
                    data:{attempt_id:id},
                    success:function (data){
                        var html = '';
                        if(data.success){
                            var data = data.data;
                            if (data.length>0){
                                for (let i=0;i<data.length;i++){
                                    let isCorrect = '<span style="color:red"; class="fa fa-close"></span>'
                                    if(data[i]['answer']['is_correct'] == 1){
                                        isCorrect = '<span style="color:green"; class="fa fa-check"></span>'
                                    }
                                    let answer = data[i]['answer']['answers'];
                                    html += `
                                <div class="row">
                                    <div class="col-sm-12">
                                            <h6> Q(` +(i+1)+ `).`+data[i]['question']['question']+`</h6>
                                            <p>Ans:-`+answer+` `+isCorrect+`</p>
                                    </div></div>`;

                                }
                            }else{
                                html+=`<h6>Student did not attempt any Questions!</h6>
                                    <p>If you approve this Exam, the Student will fail.</p>`;
                            }
                        }else{
                            html+=`<p>Having some server issues!</p>`;
                        }
                        $('.review').html(html);
                    }
                });
            });

            $('#reviewExamForm').submit(function (event){
                event.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('approveQna')}}",
                    type:"POST",
                    data:formData,
                    success:function (data){
                        if(data.success){
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });

        });
    </script>


@endsection
