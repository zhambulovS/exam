<title>{{$exam[0]['exam_name']}}</title>
@extends('layouts/app')
@section('content')
    @php $time = explode(':', $exam[0]['time']) @endphp
    <div class="container">
        <p style="color: black;">Welcome, {{Auth::user()->name}}</p>
        <h1 class="text-center">{{$exam[0]['exam_name']}}</h1>
        @php $qcount = 1; @endphp

        @if($success == true)
            @if(count($qna) > 0)
                <h4 class="text-right time"> {{$exam[0]['time']}} </h4>
                <form action="{{route('examSubmit')}}" id="exam_form" method="POST" class="mb-5" onsubmit="return isValid();">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{$exam[0]['id']}}">

                    @foreach($qna as $data)
                        <br>
                        <div>
                            <h5>Q{{$qcount++}}. {{$data['question'][0]['question']}}</h5>
                            <input type="hidden" name="q[]" value="{{$data['question'][0]['id']}}">
                            <input type="hidden" name="ans_{{$qcount-1}}" id="ans_{{$qcount-1}}">

                            @php $acount = 1; @endphp
                            @foreach($data['question'][0]['answers'] as $answer)
                                <p>
                                    <input type="radio" class="select_ans" data-id="{{$qcount-1}}"
                                           name="radio_{{$qcount-1}}" value="{{$answer['id']}}">
                                    <b>{{$acount++}}).</b> {{$answer['answers']}}
                                </p>
                            @endforeach

                        </div>
                    @endforeach

                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            @else
                <h3 style="color: red;" class="text-center"> Question & Answers not available </h3>
            @endif
        @else
            <h3 style="color: red;" class="text-center">{{ $msg }}</h3>
        @endif
    </div>
    <script>
        var isTimeOver = false;
        $(document).ready(function (){
            var time = @json($time);
            var second = 0;
            var hours = parseInt(time[0]);
            var minutes = parseInt(time[1]);

            $('.time').text(time[0]+':'+time[1]+':00 Left time');

            $('.select_ans').click(function (){
                var no = $(this).attr('data-id');
                $('#ans_'+no).val($(this).val());
            });

            var timer = setInterval(()=>{
                if(hours==0 && minutes==0 && second==0){
                    clearInterval(timer);
                    isTimeOver = true;
                    $('#exam_form').submit();
                }

                if(second <= 0){
                    minutes--;
                    second = 59;
                }
                if(minutes <= 0 && hours != 0){
                    hours--;
                    minutes = 59;
                }

                let tempHours = hours.toString().length > 1 ? hours : '0'+hours;
                let tempMinutes = minutes.toString().length > 1 ? minutes : '0'+minutes;
                let tempSeconds = second.toString().length > 1 ? second : '0'+second;

                $('.time').text(tempHours + ':' + tempMinutes + ':' + tempSeconds + ' Left time');

                second--;
            }, 1000);
        });

        function isValid(){
            var result = true;
            if(isTimeOver) return result;

            var qlength = parseInt("{{$qcount}}")-1;
            $('.error_msg').remove();

            for(let i=1;i<=qlength;i++){
                if($('#ans_'+i).val() == ""){
                    result = false;
                    $('#ans_'+i).parent().append('<span style="color:red;" class="error_msg">Please select answer</span>');
                    setTimeout(()=>{
                        $('.error_msg').remove();
                    }, 5000);
                }
            }
            return result;
        }
    </script>
@endsection
