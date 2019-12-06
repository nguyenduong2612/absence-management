@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    @if(!auth()->user()->isAdmin())
        <a href="{{ route('absences.create') }}" class="btn btn-success">Create New Request</a>
    @endif
</div>

<div class="card card-default">
    <div class="card-header">Absences</div>

    <div class="card-body">
    <table class="table">
        <thead>
            <th style="min-width: 150px">Name</th>
            <th>Reason</th>
            <th>Date and Time</th>
            <th>Created At</th>
            <th>Status</th>
            @if(auth()->user()->isAdmin())
            <th></th>
            <th></th>
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
                    {{ $absence->start_at }} - {{ $absence->end_at }}
                </td>
                <td>
                    {{ $absence->created_at }}
                </td>
                <td>
                    {{ $absence->status }}
                </td>
                @if(auth()->user()->isAdmin())
                    @if( $absence->status == 'pending') 
                    <td>
                        <form action="{{ route('absences.accept', $absence->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('absences.reject', $absence->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                    @else
                    <td></td>
                    <td></td>
                    @endif
                @endif  
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection