@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Department</h6>
                    <div>
                        <a href="{{ route('hr.departments.show', $department->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <a href="{{ route('hr.departments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('hr.departments.update', $department->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Department Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name', $department->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Department Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                        id="code" name="code" value="{{ old('code', $department->code) }}" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                        id="description" name="description" rows="3">{{ old('description', $department->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="head_id">Department Head</label>
                                    <select class="form-control @error('head_id') is-invalid @enderror" 
                                        id="head_id" name="head_id">
                                        <option value="">Select Department Head</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" 
                                                {{ old('head_id', $department->head_id) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->position->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('head_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                        <option value="active" {{ old('status', $department->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $department->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_id">Parent Department</label>
                                    <select class="form-control @error('parent_id') is-invalid @enderror" 
                                        id="parent_id" name="parent_id">
                                        <option value="">None</option>
                                        @foreach($departments as $dept)
                                            @if($dept->id != $department->id && !$department->isDescendantOf($dept))
                                                <option value="{{ $dept->id }}" 
                                                    {{ old('parent_id', $department->parent_id) == $dept->id ? 'selected' : '' }}>
                                                    {{ $dept->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Department
                            </button>
                            <a href="{{ route('hr.departments.show', $department->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Prevent circular department hierarchy
        $('#parent_id').on('change', function() {
            var selectedParentId = $(this).val();
            if (selectedParentId) {
                // Check if the selected parent is a descendant of the current department
                var isDescendant = false;
                @foreach($department->children as $child)
                    if (selectedParentId == '{{ $child->id }}') {
                        isDescendant = true;
                    }
                @endforeach

                if (isDescendant) {
                    alert('Cannot set a sub-department as parent department.');
                    $(this).val('');
                }
            }
        });
    });
</script>
@endpush 