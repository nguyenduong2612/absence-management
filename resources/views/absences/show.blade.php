@extends('layouts.app')

@section('content')
<div class="card card-default">
    <div class="card-header">
        <h3 class="mt-2">Chi tiết đơn xin nghỉ phép</h3>
    </div>

    <div class="card-body">

        <div class="form-group">
            <h5>Họ tên:&nbsp;&nbsp; {{ $absence->user->name }}</h5>
        </div>

        <div class="form-group">
            <h5>Lý do xin nghỉ phép:&nbsp;&nbsp; {{ $absence->reason }}</h5>
        </div>

        <div class="form-group">
            <h5>Thời gian:&nbsp;&nbsp; Từ {{ Carbon\Carbon::parse($absence->start_at)->format('d/m/Y') }} Đến {{ Carbon\Carbon::parse($absence->end_at)->format('d/m/Y') }}</h5>
        </div>
        
        <div class="form-group">
            <h5>Ghi chú:&nbsp;&nbsp; {{ $absence->note }}</h5>
        </div>

        <div class="form-group">
            @if( $absence->status == 'pending' ) 
                <div class="pending px-3 py-1" style="width: 250px">Đang chờ</div>
            @elseif( $absence->status == 'accepted' ) 
                <div class="accepted px-3 py-1" style="width: 250px">Đã duyệt</div>
            @else
                <div class="rejected px-3 py-1" style="width: 250px">Từ chối</div>
            @endif
        </div>

        <div class="form-group">
            @if( $absence->status == 'pending' ) 
                <button onclick="showAcceptModal({{$absence->id}})" class="btn btn-success ">Đồng ý</button>

                <button onclick="showRejectModal({{$absence->id}})" class="btn btn-danger ">Từ chối</button>
            @else
                <form action="{{ route('absences.undo', $absence->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Hoàn tác</button>
                </form>
            @endif

        </div>
    </div>
</div>

<!-- Modal -->
<div class="row">
    <div class="modal fade" id="accept{{$absence->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('absences.accept', $absence->id) }}" method="POST" >
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Chấp nhận đơn xin nghỉ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="description">Nội dung</label>
                            <input type="text" id="description" class="form-control" name="description" >
                            <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{ $absence->user_id }}">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Quay lại</button>
                        <button type="submit" class="btn btn-success">Đồng ý</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="modal fade" id="reject{{$absence->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('absences.reject', $absence->id) }}" method="POST" >
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Từ chối đơn xin nghỉ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="description">Nội dung</label>
                            <input type="text" id="description" class="form-control" name="description" >
                            <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{ $absence->user_id }}">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Quay lại</button>
                        <button type="submit" class="btn btn-danger">Từ chối</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->
@endsection

@section('scripts')
<script type="text/javascript">
    function showAcceptModal(id) {
        var id = '#accept' + id.toString();
        $(id).modal('show')
    }
    function showRejectModal(id) {
        var id = '#reject' + id.toString();
        $(id).modal('show')
    }
</script>
@endsection