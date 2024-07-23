@php($page='contact')
@extends('layouts.master')
@section('title', 'Contact Us')
@section('body')
    <div>
        <form class="col-7 my-2 border p-4" method="POST"
        action="{{route('contact.mail')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-4 col-form-label fw-bold">E-mail</label>
            <input name="email" type="email" class="up form-control"
            id="inputEmail" placeholder="Your Email..." maxlength="255" required="required"
            value="{{old('email')}}">
        </div>
        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label fw-bold">Name</label>
            <input name="name" type="text" class="up form-control"
            id="inputName" placeholder="Your Name..." maxlength="255" required="required"
            value="{{old('name')}}">
        </div>
        <div class="form-group row">
            <label for="inputSubject" class="col-sm-2 col-form-label fw-bold">Subject</label>
            <input name="subject" type="text" class="up form-control"
            id="inputSubject" placeholder="Subject..." maxlength="255" required="required"
            value="{{old('subject')}}">
        </div>
        <div class="form-group row">
            <label for="inputMessage" class="col-sm-2 col-form-label fw-bold">Message</label>
            <textarea name="msg" id="inputMessage" maxlength="2048"
            class="up form-control" required="required">{{old('message')}}</textarea>
        </div><!--Input File-->
{{--         <div class="form-group row my-4">
            <label for="inputFile" class="form-label">Pdf File: </label>
            <input name="contactFile" type="file" class="form-control-file"
            accept="application/pdf" id="inputFile"> --}}
        </div><!--Buttons-->
        <div class="form-group row">
            <button type="submit" class="btn btn-dark m-2 mt-5 w-30">Send</button>
            <button type="reset" class="btn btn-secondary m-2 mt-5 w-30">Clear</button>
        </div>
    </form>
    </div>
    @endsection
