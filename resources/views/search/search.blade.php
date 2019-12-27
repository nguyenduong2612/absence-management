@extends('layouts.app')

@section('content')
@auth
<div class="d-flex justify-content-end mb-2">
    @if(auth()->user()->isAdmin())
        <a href="{{ url('calender') }}" class="btn btn-success">Quản lý nghỉ phép</a>
    @endif
    <a href="{{ route('absences.create') }}" class="btn btn-success ml-3">Tạo đơn xin nghỉ phép</a>
</div>

<div class="card card-default">
    <div class="card-header"><h2 class="mt-2">Quản lý nghỉ phép</h2></div>
    
    @if(auth()->user()->isAdmin())
    <div class="row p-3 m-0">
        <div class="col-md-6">
            <h5>Tìm kiếm</h5>
            <input type="text" class="form-control" id="search" name="search">
        </div>
        
    </div>
    @endif
    
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
                @endif  
            </thead>
            <tbody>
                @if(auth()->user()->isAdmin())
                    @foreach($absences as $absence)
                    <tr>
                        <td>
                            {{ $absence->user->name }}
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
                        <td>
                            <a href="{{ route('absences.show', $absence->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    @foreach($absences as $absence)
                        @if(Auth::user()->id == $absence->user_id)
                        <tr>
                            <td>
                                {{ $absence->user->name }}
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

@section('scripts')
<script type="text/javascript">
    $('#search').on('keyup',function(){
        $value = $(this).val();

        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        $.ajax({
            type: 'get',
            url: '{{ URL::to('search') }}',
            data: {
                'search': $value
            },
            success:function(data){
                $('tbody').html(data);
            }
        });
    })
    
</script>
@endsection