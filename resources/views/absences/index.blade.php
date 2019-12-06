@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('absences.create') }}" class="btn btn-success">Create New Request</a>
</div>

<div class="card card-default">
    <div class="card-header">Absences</div>

    <div class="card-body">
    <table class="table">
        <thead>
            <th>Name</th>
            <th>Reason</th>
            <th>Start At</th>
            <th>End At</th>
            <th>Created At</th>
            <th>Status</th>
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
                    {{ $absence->start_at }}
                </td>
                <td>
                    {{ $absence->end_at }}
                </td>
                <td>
                    {{ $absence->created_at }}
                </td>
                <td>
                    {{ $absence->status }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection