@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Telemedicine Sessions</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($onlineAppointments as $appointment)
                        <tr>
                            <td>
                                <div>{{ $appointment->first_name }} {{ $appointment->last_name }}</div>
                                <small class="text-muted">{{ $appointment->email }}</small>
                            </td>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, Y') }}</div>
                                <div class="text-muted">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $appointment->status === 'scheduled' ? 'primary' : 'success' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                @if($appointment->status === 'scheduled')
                                    <a href="{{ route('doctor.telemedicine.show', $appointment->id) }}" 
                                       class="btn btn-sm btn-success">
                                        Start Session
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Completed</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No online appointments scheduled</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                {{ $onlineAppointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection