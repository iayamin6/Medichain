@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2>Telemedicine Session</h2>
            <form action="{{ route('doctor.telemedicine.end', $appointment->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">End Session</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div id="video-container" class="ratio ratio-16x9 bg-dark mb-3">
                        <!-- Video call integration will go here -->
                        <div class="d-flex align-items-center justify-content-center text-white">
                            <div class="text-center">
                                <i class="fas fa-video fa-3x mb-3"></i>
                                <h4>Video Session</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Patient Information</h5>
                    <p><strong>Name:</strong> {{ $appointment->user->first_name }} {{ $appointment->user->last_name }}</p>
                    <p><strong>Email:</strong> {{ $appointment->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $appointment->user->phone }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Session Notes</h5>
                    <textarea class="form-control mb-3" rows="5" placeholder="Type your notes here..."></textarea>
                    <button class="btn btn-primary">Save Notes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    #video-container {
        min-height: 400px;
        background: #1a1a1a;
        border-radius: 8px;
    }
</style>
@endpush
@endsection