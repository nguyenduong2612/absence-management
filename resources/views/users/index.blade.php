@extends('layouts.app')

@section('content')<div class="card card-default">
<div class="card card-default">
    <div class="card-header"><h2 class="mt-2">Tất cả nhân viên</h2></div>

    <div class="card-body">
        @if($users->count() > 0)
        <table class="table">
            <thead>
                <th>Chức vụ</th>
                <th>Họ tên</th>
                <th>Địa chỉ Email</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            @if($user->role == 'admin')
                                Quản trị viên
                            @else
                                Nhân viên
                            @endif
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td>
                            {{ $user->email }}
                        </td>
                        <td>
                        @auth
                            @if(auth()->user()->isAdmin())
                                @if(!$user->isAdmin())
                                <form action="{{ route('users.make-admin', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Thêm quản trị viên</button>
                                </form>
                                @else
                                <form action="{{ route('users.remove-admin', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Gỡ quản trị viên</button>
                                </form>
                                @endif
                            @endif
                        @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @else
        <h3 class="text-center">No Users Yet</h3>
        @endif
    </div>
</div>
@endsection