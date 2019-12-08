@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    @if(!auth()->user()->isAdmin())
        <a href="{{ route('absences.create') }}" class="btn btn-success">Tạo đơn xin nghỉ phép</a>
    @endif
</div>

<div class="card card-default">
    <div class="card-header"><h2 class="mt-2">Quản lý nghỉ phép</h2></div>

    <div class="card-body">
        <table class="table">
            <thead>
                <th style="min-width: 150px">Họ tên</th>
                <th>Lý do</th>
                <th>Thời gian</th>
                <th style="width: 150px">Ngày tạo</th>
                <th style="min-width: 122px; text-align: center">Trạng thái</th>
                @if(auth()->user()->isAdmin())
                <th style="width: 80px"></th>
                <th style="width: 80px"></th>
                @endif  
            </thead>
            <tbody>
                @foreach($absences as $absence)
                <tr>
                    <td>
                        {{ \App\User::where(['id' => $absence->user_id])->first()->name }}
                    </td>
                    <td>
                        {{ $absence->reason }}
                    </td>
                    <td>
                        {{ $absence->start_at }} <br> {{ $absence->end_at }}
                    </td>
                    <td>
                        {{ $absence->created_at }}
                    </td>
                    <td>
                        @if( $absence->status == 'pending' ) 
                            <div class="pending px-3 py-1">Đang chờ</div>
                        @elseif( $absence->status == 'accepted' ) 
                            <div class="accepted px-3 py-1">Đã duyệt</div>
                        @else
                            <div class="rejected px-3 py-1">Từ chối</div>
                        @endif
                    </td>
                    @if(auth()->user()->isAdmin())
                        @if( $absence->status == 'pending') 
                        <td>
                            <form action="{{ route('absences.accept', $absence->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Đồng ý</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('absences.reject', $absence->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Từ chối</button>
                            </form>
                        </td>
                        @else
                        <td>
                            <form action="{{ route('absences.undo', $absence->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Hoàn tác</button>
                            </form>
                        </td>
                        <td></td>
                        @endif
                    @endif  
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $absences->links() }}
    </div>
</div>
@endsection