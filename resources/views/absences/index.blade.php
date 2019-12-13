@extends('layouts.app')

@section('content')
@auth
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
                @if(auth()->user()->isAdmin())
                    @foreach($absences as $absence)
                    <tr>
                        <td>
                            {{ \App\User::where(['id' => $absence->user_id])->first()->name }}
                        </td>
                        <td>
                            {{ $absence->reason }}
                        </td>
                        <td>
                            Từ {{ Carbon\Carbon::parse($absence->start_at)->format('d/m/Y') }} <br> Đến {{ Carbon\Carbon::parse($absence->end_at)->format('d/m/Y') }}
                        </td>
                        <td>
                            {{ Carbon\Carbon::parse($absence->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y') }}
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
                    </tr>
                    @endforeach
                @else
                    @foreach($absences as $absence)
                        @if(Auth::user()->id == $absence->user_id)
                        <tr>
                            <td>
                                {{ \App\User::where(['id' => $absence->user_id])->first()->name }}
                            </td>
                            <td>
                                {{ $absence->reason }}
                            </td>
                            <td>
                                Từ {{ Carbon\Carbon::parse($absence->start_at)->format('d/m/Y') }} <br> Đến {{ Carbon\Carbon::parse($absence->end_at)->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($absence->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y') }}
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
                        </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
        {{ $absences->links() }}
    </div>
</div>
@endauth
@endsection