@extends('layouts.app')

@section('content')
    <h1>{{ $exam->exam_name }}</h1>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($exam->date)->format('d-m-Y') }}</p>
    <p><strong>Time:</strong> {{ $exam->time }}</p>

    <h2>Questions</h2>
    <ul>
        @foreach($exam->getQnaExam as $question)
            <li>{{ $question->question_text }}</li>
        @endforeach
    </ul>
@endsection
