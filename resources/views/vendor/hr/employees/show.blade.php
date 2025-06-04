@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Employee Details</h6>
                    <div>
                        <a href="{{ route('hr.employees.edit', $employee) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('hr.employees.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Employee Profile -->
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            @if($employee->profile_photo)
                                <img src="{{ asset($employee->profile_photo) }}" class="img-fluid rounded-circle mb-3" style="max-width: 200px;">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                    style="width: 200px; height: 200px; font-size: 4rem;">
                                    {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                </div>
                            @endif
                            <h4>{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                            <p class="text-muted">{{ $employee->position->name }}</p>
                            <span class="badge badge-{{ $employee->status_color }}">{{ ucfirst($employee->status) }}</span>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Personal Information</h5>
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Employee ID</th>
                                            <td>{{ $employee->employee_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $employee->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $employee->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td>{{ $employee->date_of_birth->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $employee->address }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold">Employment Information</h5>
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Department</th>
                                            <td>{{ $employee->department->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Position</th>
                                            <td>{{ $employee->position->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Joining</th>
                                            <td>{{ $employee->date_of_joining->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Employment Type</th>
                                            <td>{{ ucfirst($employee->employment_type) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge badge-{{ $employee->status_color }}">
                                                    {{ ucfirst($employee->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Emergency Contact</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Name:</strong> {{ $employee->emergency_contact['name'] }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Relationship:</strong> {{ $employee->emergency_contact['relationship'] }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Phone:</strong> {{ $employee->emergency_contact['phone'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Details -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Bank Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Bank Name:</strong> {{ $employee->bank_details['bank_name'] }}</p>
                                    <p><strong>Account Number:</strong> {{ $employee->bank_details['account_number'] }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Branch:</strong> {{ $employee->bank_details['branch'] }}</p>
                                    <p><strong>IFSC Code:</strong> {{ $employee->bank_details['ifsc_code'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Documents</h6>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadDocumentModal">
                                <i class="fas fa-upload"></i> Upload Document
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Document Type</th>
                                            <th>Description</th>
                                            <th>Upload Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($employee->documents as $document)
                                        <tr>
                                            <td>{{ $document->type }}</td>
                                            <td>{{ $document->description }}</td>
                                            <td>{{ $document->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <a href="{{ asset($document->file_path) }}" class="btn btn-info btn-sm" target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <form action="{{ route('hr.employees.documents.delete', [$employee, $document]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this document?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No documents uploaded yet.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @forelse($employee->activities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">{{ $activity->description }}</h6>
                                        <p class="timeline-date">{{ $activity->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                @empty
                                <p class="text-center">No recent activities found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Document Modal -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1" role="dialog" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('hr.employees.documents.upload', $employee) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadDocumentModalLabel">Upload Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="document_type">Document Type</label>
                        <select class="form-control" id="document_type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="resume">Resume</option>
                            <option value="id_proof">ID Proof</option>
                            <option value="address_proof">Address Proof</option>
                            <option value="qualification">Qualification</option>
                            <option value="experience">Experience</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="document_description">Description</label>
                        <textarea class="form-control" id="document_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="document_file">File</label>
                        <input type="file" class="form-control-file" id="document_file" name="document" required>
                        <small class="form-text text-muted">Maximum file size: 10MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }
    .timeline-item {
        position: relative;
        padding-left: 40px;
        margin-bottom: 20px;
    }
    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background: #4e73df;
        border: 3px solid #fff;
        box-shadow: 0 0 0 1px #4e73df;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: 7px;
        top: 15px;
        height: calc(100% + 5px);
        width: 1px;
        background: #e3e6f0;
    }
    .timeline-item:last-child:before {
        display: none;
    }
    .timeline-title {
        margin-bottom: 5px;
        font-weight: 600;
    }
    .timeline-date {
        color: #858796;
        font-size: 0.85rem;
    }
</style>
@endpush 