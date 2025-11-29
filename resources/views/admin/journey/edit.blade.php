@extends('admin.layouts.app')

@section('title', 'Edit Journey')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Edit Journey Item</h4>
                    <a href="{{ route('admin.journey.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Back to List
                    </a>
                </div>

                <form class="forms-sample" action="{{ route('admin.journey.update', $journey->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted">Period / Year</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-info border-secondary">
                                            <i class="mdi mdi-calendar-clock"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control text-white" name="tahun" value="{{ $journey->tahun }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted">Role / Title</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-warning border-secondary">
                                            <i class="mdi mdi-briefcase"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control text-white" name="judul" value="{{ $journey->judul }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-muted">Description</label>
                        <textarea class="form-control text-white" name="deskripsi" rows="6" style="line-height: 1.6" required>{{ $journey->deskripsi }}</textarea>
                    </div>

                    <div class="border-top border-secondary pt-3 text-end">
                        <button type="submit" class="btn btn-primary btn-icon-text">
                            <i class="mdi mdi-content-save btn-icon-prepend"></i> Update Journey
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
