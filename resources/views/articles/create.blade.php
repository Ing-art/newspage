@php($page='newarticle')
@extends('layouts.master')
@section('title', 'New Article')
@section('body')

<form class="my-2 border p-5" method="POST" action="{{route('articles.store')}}" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="form-group row col-md-6">
        <label for="inputHeadline" class="col-sm-2 col-form-label fw-bold ">Headline</label>
        <input name="headline" type="text" class="up form-control col-sm-4 border border-primary" id="inputHeadline" placeholder="Enter Headline...."
            maxlength="255" value="{{old('headline')}}">
    </div>
    <div class="form-group row col-md-6">
        <label for="inputModel" class="col-sm-2 col-form-label fw-bold">Subject</label>
        <input name="subject" type="text" class="up form-control col-sm-4 border border-primary" id="inputModel" placeholder="Enter Subject..."
            maxlength="50" value="{{old('subject')}}">
    </div>
    <div class="form-group row col-md-6">
        <textarea name="text" class="up form-control col-sm-4 border border-primary" rows="20" cols="12">
            {{old('text')}}</textarea>
    </div>

    <div class="form-group row mt-4">
        <label for="inputImage" class="col-sm-2 col-form-label fw-bold">Image: </label>
        <input name="image" type="file" class="up form-control-file col-sm-10" id="inputImage">
    </div>

    <div class="d-grid gap-2 col-3 d-md-block mt-4">
        <button type="submit" class="btn btn-dark mr-2 ">Save</button>
        <button type="reset" class="btn btn-secondary mr-2 ">Clear</button><!--FIXME user_id not saved in the DB-->
    </div>
</form>
@endsection