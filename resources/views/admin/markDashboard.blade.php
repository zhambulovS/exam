@extends('layouts/admin/admin-temp')
@section('content')
    <h1 class="mb-4">Marks</h1>

    <table class="table">
        <thead>
            <th>#</th>
            <th>Exam Name</th>
            <th>Marks/Q</th>
            <th>Total marks</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
            @if(count($exams)>0)
                @php $x=1; @endphp
                @foreach($exams as $exam)
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$exam->exam_name}}</td>
                        <td>{{$exam->marks}}</td>
                        <td> {{count($exam->getQnaExam)*$exam->marks}} </td>
                        <td><button class="btn btn-primary editMarks" data-toggle="modal" data-target="#editMarksModal" data-id="{{$exam->id}}" data-marks="{{$exam->marks}}" data-totalq="{{count($exam->getQnaExam)*$exam->marks}}"> Edit </button></td>
                        <td><button class="btn btn-danger deleteMarks"> Delete </button></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">Exams not added!</td>
                </tr>
            @endif
        </tbody>
    </table>
{{--UPDATE MODAL--}}
    <div class="modal fade" id="editMarksModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update marks</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updMarksForm" method="POST">
                    @csrf
                    <div class="modal-body updModalMarks">
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Marks/Q</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="hidden" name="exam_id" id="exam_id">
                                <input type="text"
                                       onkeypress="return event.charCode>=48 && event.charCode<=57 || event.charCode == 46"
                                       name="marks" id="marks" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label>Total marks</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="tmarks" disabled placeholder="Total marks">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color: red;"></span>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

    $(document).ready(function (){
        var totalQna = 0;
        $('.editMarks').click(function (){
            var exam_id = $(this).attr('data-id');
            var marks = $(this).attr('data-marks');
            var totalq = $(this).attr('data-totalq');
            $('#exam_id').val(exam_id);
            $('#marks').val(marks);
            $('#totalq').val(marks*totalq);

            totalQna = totalq;
        });
        $('#marks').keyup(function (){
            $('#tmarks').val($(this).val()*totalQna);

        });
        $('#updMarksForm').submit(function (event){
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{route('updateMarks')}}",
                type:"POST",
                data:formData,
                success:function (data){
                    if(data.success==true){
                        location.reload();
                    }
                    else {
                        alert(data.msg)
                    }
                }
            });
        });

    });

    </script>

@endsection
