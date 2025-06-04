@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Departments</h6>
                    <a href="{{ route('hr.departments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add New Department
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search and Filter -->
                    <form action="{{ route('hr.departments.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search departments..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('hr.departments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Departments Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Head</th>
                                    <th>Employees</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departments as $department)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px;">
                                                {{ substr($department->name, 0, 1) }}
                                            </div>
                                            <div>
                                                {{ $department->name }}
                                                <div class="small text-muted">{{ $department->description }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $department->code }}</td>
                                    <td>
                                        @if($department->head)
                                            <div class="d-flex align-items-center">
                                                @if($department->head->profile_photo)
                                                    <img src="{{ asset($department->head->profile_photo) }}" class="rounded-circle mr-2" width="24" height="24">
                                                @else
                                                    <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center mr-2" style="width: 24px; height: 24px;">
                                                        {{ substr($department->head->first_name, 0, 1) }}{{ substr($department->head->last_name, 0, 1) }}
                                                    </div>
                                                @endif
                                                {{ $department->head->first_name }} {{ $department->head->last_name }}
                                            </div>
                                        @else
                                            <span class="text-muted">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $department->employees_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $department->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($department->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('hr.departments.show', $department) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('hr.departments.edit', $department) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('hr.departments.destroy', $department) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this department?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No departments found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $departments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        padding: 0.5em 0.75em;
    }
</style>
@endpush 