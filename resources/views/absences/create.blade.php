@extends('layouts.app')

@section('content')
<div class="card card-default">
    <div class="card-header">
        <h2 class="mt-2">Tạo đơn xin nghỉ phép</h2>
    </div>

    <div class="card-body">
        <form action="{{ route('absences.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="reason">Lý do xin nghỉ phép</label>
            <textarea name="reason" id="reason" cols="5" rows="5" class="form-control"></textarea>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="start_at">Thời gian bắt đầu</label>
                <input type="text" class="form-control" name="start_at" id='start_at'>
            </div>

            <div class="form-group col-md-6">
                <label for="end_at">Thời gian kết thúc</label>
                <input type="text" class="form-control" name="end_at" id='end_at'>
            </div>
        </div>

        <div class="form-group">
            <label for="note">Ghi chú</label>
            <input type="text" class="form-control" name="note" id='note'>
        </div>

        <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{ Auth::user()->id }}">

        <div class="form-group">
            <button type="submit" class="btn btn-success">
                Tạo đơn 
            </button>
        </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr('#start_at', {
            enableTime: false
        });
        flatpickr('#end_at', {
            enableTime: false
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection