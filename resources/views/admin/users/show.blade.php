@extends('layouts.master')
@section('title', "{{$user->name}}")
@section('body')
<div class="col-10 row">
    <h2 class="text-center mt-3 mb-3 fw-bold">User Details</h2>
    <table class="col-4 table table-stripped table-bordered table-hover mt-3 mx-3">
        <tr>
            <td>Id</td>
            <td>{{$user->id}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$user->name}}</td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
        </tr>
        <tr>
            <td>Registered</td>
            <td>{{$user->created_at}}</td>
        </tr>
        <tr>
            <td>Verified</td>
            <td>{{$user->email_verified_at ?? 'Not Verified'}}</td>
        </tr>
        <tr>
            <td>Roles</td>
            <td>@foreach($user->roles as $role)
                {{$role->role}}<br>
                @endforeach
            </td>
        </tr>
    </table>
</div>
@endsection

