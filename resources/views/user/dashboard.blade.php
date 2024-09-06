@extends('layouts/user/user-temp')
@section('content')
    <h1> Exams </h1>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Exam</th>
            <th scope="col">Subject</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Total attempt</th>
            <th scope="col">Available attempt</th>
            <th scope="col">Copy link</th>
        </tr>
        </thead>
        <tbody>
        @if(count($exams)>0)
            @php $cnt = 1;@endphp
            @foreach($exams as $exam)
                <tr>
                    <th scope="row">{{ $cnt ++ }}</th>
                    <td> {{ $exam->exam_name }}</td>
                    <td> {{ $exam->subject[0]['subject'] }}</td>
                    <td> {{ \Carbon\Carbon::parse($exam->date)->format('d-m-Y') }} </td>
                    <td> {{ $exam->time }} </td>
                    <td> {{ $exam->attempt }}</td>
                    <td> </td>
                    <td> <a href="#" data-code="{{$exam->enterance_id}}" class="copy" ><i class="fa fa-copy"></i></a> </td>
                </tr>
            @endforeach
        @else
            <tr>  <td colspan="5">Exams not found! </td> </tr>
        @endif
        </tbody>
    </table>

    <script>
        $(document).ready(function (){
            $('.copy').click(function (e){
                e.preventDefault();

                $('.copied_text').remove();

                $(this).after('<span class="copied_text" style="margin-left: 5px;">Copied</span>');

                var code = $(this).attr('data-code');
                var url = "{{ URL::to('/') }}/exam/" + code;
                var $temp = $("<input>");

                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();

                setTimeout(function(){
                    $('.copied_text').fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 1000);
            });
        });
    </script>


@endsection
