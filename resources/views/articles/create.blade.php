@php($page = 'newarticle')
@extends('layouts.master')
@section('title', 'New Article')
@section('body')
    <h1 class="text-center mt-3">Create a new article</h1>
    <div class="container">
        <div class="row justify-content-center">
            <form id="create-article-form" class="my-2 p-5" method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group row col-md-6 mb-3">
                    <label for="inputHeadline" class="col-sm-2 col-form-label fw-bold ">Headline</label>
                    <input name="headline" type="text" class="up form-control col-sm-4 border border-secondary"
                        id="inputHeadline" placeholder="Enter Headline...." maxlength="255" value="{{ old('headline') }}" autocomplete="off">
                </div>
                <div class="form-group row col-md-6 mb-3">
                    <label for="subject" class="col-sm-2 col-form-label fw-bold">Subject</label>
                    {{-- <label class="col-sm-2 col-form-label fw-bold " for="subject">Choose a subject:</label> --}}
                    <select class="form-select mb-3 border border-secondary" id="subject" name="subject">
                        <option selected disabled>Select a Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject }}" {{ old('subject') == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row col-md-6 mb-3">
                    <label for="text" class="col-sm-2 col-form-label fw-bold" autocomplete="off">Text</label>
                    <textarea class="form-control border border-secondary text-left" name="text" rows="20" id="text">
            {{ old('text') }}</textarea>
                </div>

                <div class="form-group row mt-4">
                    <label for="inputImage" class="col-sm-2 col-form-label fw-bold">Image: </label>
                    <input name="image" type="file" class="up form-control-file col-sm-10" id="inputImage">
                </div>

                <div class="d-grid gap-2 col-3 d-md-block mt-4">
                    <button id="save-article" type="submit" class="btn btn-dark mr-2 ">Save</button>
                    <button type="reset" class="btn btn-secondary mr-2 ">Clear</button>
                </div>
            </form>
        </div>
    </diV>
    <script>
        document.getElementById('create-article-form').addEventListener('submit', function () {
            const saveButton = document.getElementById('save-article');

            saveButton.disabled = true;
            saveButton.textContent = 'Saving...';
        });
    </script>
@endsection
