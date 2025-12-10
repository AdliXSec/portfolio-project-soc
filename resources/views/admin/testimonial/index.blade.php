@extends('admin.layouts.app')

@section('title', 'Manage Testimonials')

@section('content')
<div class="row">
    <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title mb-0">Testimonials</h4>
            <p class="text-muted mb-0">Manage what people say about you</p>
        </div>
        <a href="{{ route('admin.testimonial.create') }}" class="btn btn-success btn-icon-text">
            <i class="mdi mdi-plus btn-icon-prepend"></i> Add New Testimonial
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="row">
    @forelse($testimonials as $testimonial)
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="testimonial-card-admin card bg-dark text-white position-relative h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        @if($testimonial->avatar)
                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="img-sm rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="me-3 d-flex align-items-center justify-content-center bg-primary rounded-circle" style="width: 50px; height: 50px;">
                                <span class="font-weight-bold">{{ strtoupper(substr($testimonial->name, 0, 2)) }}</span>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h5 class="mb-0 text-white">{{ $testimonial->name }}</h5>
                            <p class="text-muted mb-0 text-small">{{ $testimonial->position }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        @for($i = 0; $i < 5; $i++)
                            <i class="mdi mdi-star {{ $i < $testimonial->rate ? 'text-warning' : 'text-secondary' }}"></i>
                        @endfor
                    </div>

                    <p class="text-small text-gray-400 flex-grow-1"><em>"{{ $testimonial->testimonial }}"</em></p>

                </div>
                <div class="card-actions position-absolute w-100 h-100 d-flex align-items-center justify-content-center" style="top:0; left:0; background: rgba(0,0,0,0.7); opacity: 0; border-radius: 0.25rem;">
                    <a href="{{ route('admin.testimonial.edit', $testimonial->id) }}" class="btn btn-warning btn-icon btn-rounded mx-2">
                        <i class="mdi mdi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.testimonial.destroy', $testimonial->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-icon btn-rounded mx-2">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="p-5 border border-dashed border-secondary rounded">
                <i class="mdi mdi-comment-question-outline text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No testimonials have been added yet.</h5>
                <p class="text-small text-muted">Click the "Add New Testimonial" button to get started.</p>
            </div>
        </div>
    @endforelse
</div>

<style>
    .testimonial-card-admin {
        transition: all 0.3s ease;
        border: 1px solid #2c2e33;
    }
    .testimonial-card-admin:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-color: #0090e7;
    }
    .card-actions {
        transition: opacity 0.3s ease;
    }
    .testimonial-card-admin:hover .card-actions {
        opacity: 1 !important;
    }
    .text-gray-400 {
        color: #adb5bd !important;
    }
</style>
@endsection
