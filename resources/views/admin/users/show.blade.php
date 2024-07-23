@extends('layouts.master')
@section('title', "{{ $user->name }}")
@section('body')
    <div class="col-10 row">
        <h2 class="text-center mt-3 mb-3 fw-bold">User Details</h2>
        <table class="col-4 table table-stripped table-bordered table-hover mt-3 mx-3">
            <tr>
                <td>Id</td>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            </tr>
            <tr>
                <td>Registered</td>
                <td>{{ $user->created_at }}</td>
            </tr>
            <tr>
                <td>Verified</td>
                <td>{{ $user->email_verified_at ?? 'Not Verified' }}</td>
            </tr>
            <tr>
                <td>Roles</td>
                <td>
                    @foreach ($user->roles as $role)
                        <span class="d-inline-block w-50">{{ $role->role }}</span>
                        <form class="d-inline-block p-1" method="POST" action="{{ route('admin.user.removerole') }}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                            <input type="submit" class="btn btn-danger" value="Remove">
                        </form>
                    </br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Add a Role</td>
                <td>
                    <form method="POST" action = "{{route('admin.user.setrole')}}">
                        @csrf
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <select class="form-control w-50 d-inline" name="role_id">
                            @foreach($user->remainingRoles() as $role)
                            <option value="{{$role->id}}">{{$role->role}}</option>
                            @endforeach
                        </select>
                        <input type="submit" class="btn btn-warning px-3 ml-1" value="Add">
                    </form>
                </td>
            </tr>
        </table>
    </div>
@endsection
