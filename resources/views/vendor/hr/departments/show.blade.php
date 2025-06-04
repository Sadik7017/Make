@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Department Details</h6>
                    <div>
                        <a href="{{ route('hr.departments.edit', $department->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit Department
                        </a>
                        <a href="{{ route('hr.departments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;">Department Name</th>
                                            <td>{{ $department->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department Code</th>
                                            <td>{{ $department->code }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge badge-{{ $department->status == 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($department->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Parent Department</th>
                                            <td>
                                                @if($department->parent)
                                                    <a href="{{ route('hr.departments.show', $department->parent->id) }}">
                                                        {{ $department->parent->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">None</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td>{{ $department->description ?: 'No description available' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Department Head</h6>
                                </div>
                                <div class="card-body">
                                    @if($department->head)
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3">
                                                @if($department->head->profile_photo)
                                                    <img src="{{ asset('storage/' . $department->head->profile_photo) }}" 
                                                        alt="{{ $department->head->first_name }}" 
                                                        class="img-profile rounded-circle" 
                                                        style="width: 64px; height: 64px;">
                                                @else
                                                    <div class="img-profile rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                        style="width: 64px; height: 64px; font-size: 24px;">
                                                        {{ substr($department->head->first_name, 0, 1) }}{{ substr($department->head->last_name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-1">
                                                    <a href="{{ route('hr.employees.show', $department->head->id) }}">
                                                        {{ $department->head->first_name }} {{ $department->head->last_name }}
                                                    </a>
                                                </h6>
                                                <p class="mb-0 text-muted">{{ $department->head->position->name }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">No department head assigned</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Department Employees</h6>
                                    <span class="badge badge-primary">{{ $department->employees->count() }} Employees</span>
                                </div>
                                <div class="card-body">
                                    @if($department->employees->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Employee ID</th>
                                                        <th>Name</th>
                                                        <th>Position</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($department->employees as $employee)
                                                        <tr>
                                                            <td>{{ $employee->employee_id }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    @if($employee->profile_photo)
                                                                        <img src="{{ asset('storage/' . $employee->profile_photo) }}" 
                                                                            alt="{{ $employee->first_name }}" 
                                                                            class="img-profile rounded-circle mr-2" 
                                                                            style="width: 32px; height: 32px;">
                                                                    @else
                                                                        <div class="img-profile rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-2"
                                                                            style="width: 32px; height: 32px; font-size: 12px;">
                                                                            {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                                                        </div>
                                                                    @endif
                                                                    <a href="{{ route('hr.employees.show', $employee->id) }}">
                                                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td>{{ $employee->position->name }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $employee->status == 'active' ? 'success' : 'danger' }}">
                                                                    {{ ucfirst($employee->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('hr.employees.show', $employee->id) }}" 
                                                                    class="btn btn-info btn-sm">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">No employees in this department</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($department->children->count() > 0)
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 font-weight-bold text-primary">Sub-departments</h6>
                                        <span class="badge badge-primary">{{ $department->children->count() }} Sub-departments</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Code</th>
                                                        <th>Head</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($department->children as $child)
                                                        <tr>
                                                            <td>{{ $child->name }}</td>
                                                            <td>{{ $child->code }}</td>
                                                            <td>
                                                                @if($child->head)
                                                                    {{ $child->head->first_name }} {{ $child->head->last_name }}
                                                                @else
                                                                    <span class="text-muted">Not assigned</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-{{ $child->status == 'active' ? 'success' : 'danger' }}">
                                                                    {{ ucfirst($child->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('hr.departments.show', $child->id) }}" 
                                                                    class="btn btn-info btn-sm">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 