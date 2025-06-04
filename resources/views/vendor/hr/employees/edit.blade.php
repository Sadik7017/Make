@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Employee</h6>
                    <div>
                        <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <a href="{{ route('hr.employees.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('hr.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                                id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                                id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth->format('Y-m-d')) }}" required>
                                            @error('date_of_birth')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                id="address" name="address" rows="3" required>{{ old('address', $employee->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profile_photo">Profile Photo</label>
                                            <input type="file" class="form-control-file @error('profile_photo') is-invalid @enderror" 
                                                id="profile_photo" name="profile_photo">
                                            @error('profile_photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if($employee->profile_photo)
                                                <div class="mt-2">
                                                    <img src="{{ asset($employee->profile_photo) }}" class="img-thumbnail" style="max-width: 150px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Employment Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id">Department <span class="text-danger">*</span></label>
                                            <select class="form-control @error('department_id') is-invalid @enderror" 
                                                id="department_id" name="department_id" required>
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="position_id">Position <span class="text-danger">*</span></label>
                                            <select class="form-control @error('position_id') is-invalid @enderror" 
                                                id="position_id" name="position_id" required>
                                                <option value="">Select Position</option>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position->id }}" {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                                                        {{ $position->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('position_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date_of_joining">Date of Joining <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('date_of_joining') is-invalid @enderror" 
                                                id="date_of_joining" name="date_of_joining" value="{{ old('date_of_joining', $employee->date_of_joining->format('Y-m-d')) }}" required>
                                            @error('date_of_joining')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employment_type">Employment Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('employment_type') is-invalid @enderror" 
                                                id="employment_type" name="employment_type" required>
                                                <option value="">Select Type</option>
                                                <option value="full_time" {{ old('employment_type', $employee->employment_type) == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                                <option value="part_time" {{ old('employment_type', $employee->employment_type) == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                                <option value="contract" {{ old('employment_type', $employee->employment_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                                <option value="intern" {{ old('employment_type', $employee->employment_type) == 'intern' ? 'selected' : '' }}>Intern</option>
                                            </select>
                                            @error('employment_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                                <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="on_leave" {{ old('status', $employee->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                                        <div class="form-group">
                                            <label for="emergency_contact_name">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('emergency_contact.name') is-invalid @enderror" 
                                                id="emergency_contact_name" name="emergency_contact[name]" 
                                                value="{{ old('emergency_contact.name', $employee->emergency_contact['name']) }}" required>
                                            @error('emergency_contact.name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emergency_contact_relationship">Relationship <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('emergency_contact.relationship') is-invalid @enderror" 
                                                id="emergency_contact_relationship" name="emergency_contact[relationship]" 
                                                value="{{ old('emergency_contact.relationship', $employee->emergency_contact['relationship']) }}" required>
                                            @error('emergency_contact.relationship')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emergency_contact_phone">Phone <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control @error('emergency_contact.phone') is-invalid @enderror" 
                                                id="emergency_contact_phone" name="emergency_contact[phone]" 
                                                value="{{ old('emergency_contact.phone', $employee->emergency_contact['phone']) }}" required>
                                            @error('emergency_contact.phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('bank_details.bank_name') is-invalid @enderror" 
                                                id="bank_name" name="bank_details[bank_name]" 
                                                value="{{ old('bank_details.bank_name', $employee->bank_details['bank_name']) }}" required>
                                            @error('bank_details.bank_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account_number">Account Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('bank_details.account_number') is-invalid @enderror" 
                                                id="account_number" name="bank_details[account_number]" 
                                                value="{{ old('bank_details.account_number', $employee->bank_details['account_number']) }}" required>
                                            @error('bank_details.account_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="branch">Branch <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('bank_details.branch') is-invalid @enderror" 
                                                id="branch" name="bank_details[branch]" 
                                                value="{{ old('bank_details.branch', $employee->bank_details['branch']) }}" required>
                                            @error('bank_details.branch')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ifsc_code">IFSC Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('bank_details.ifsc_code') is-invalid @enderror" 
                                                id="ifsc_code" name="bank_details[ifsc_code]" 
                                                value="{{ old('bank_details.ifsc_code', $employee->bank_details['ifsc_code']) }}" required>
                                            @error('bank_details.ifsc_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Employee
                            </button>
                            <a href="{{ route('hr.employees.show', $employee) }}" class="btn btn-secondary">
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
        // Update positions based on selected department
        $('#department_id').change(function() {
            var departmentId = $(this).val();
            if (departmentId) {
                $.get('/hr/positions/by-department/' + departmentId, function(data) {
                    $('#position_id').empty();
                    $('#position_id').append('<option value="">Select Position</option>');
                    $.each(data, function(key, value) {
                        $('#position_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                });
            } else {
                $('#position_id').empty();
                $('#position_id').append('<option value="">Select Position</option>');
            }
        });
    });
</script>
@endpush 