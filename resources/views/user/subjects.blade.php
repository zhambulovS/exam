@extends('layouts/user/user-temp')
@section('content')
    <h1> Subjects </h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th >Subject</th>
        </tr>
        </thead>
        <tbody>
        @php $cnt = 1 @endphp
        @foreach($subjects as $subject)
            <tr>
                <th scope="row">{{ $cnt ++ }}</th>
                <td> {{ $subject->subject}} </td>
            </tr>
        @endforeach
        </tbody>

@endsection
