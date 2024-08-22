@extends('layouts/admin/admin-temp')
@section('content')
<h1>Q&A</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQna">
    Add Q&A
</button>
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


@endsection
