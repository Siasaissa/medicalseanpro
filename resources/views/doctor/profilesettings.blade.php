<!DOCTYPE html>
<html lang="en">
@include ('layouts.head')

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('layouts.doctorHeader')
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center inner-banner">
                    <div class="col-md-12 col-12 text-center">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="isax isax-home-15"></i></a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Doctor</li>
                                <li class="breadcrumb-item active">Doctor Profile</li>
                            </ol>
                            <h2 class="breadcrumb-title">Doctor Profile Settings</h2>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="breadcrumb-bg">
                <img src="{{ asset('images/breadcrumb-bg-01.png') }}" alt="img" class="breadcrumb-bg-01">
                <img src="{{ asset('images/breadcrumb-bg-02.png') }}" alt="img" class="breadcrumb-bg-02">
                <img src="{{ asset('images/breadcrumb-icon.webp') }}" alt="img" class="breadcrumb-bg-03">
                <img src="{{ asset('images/breadcrumb-icon.webp') }}" alt="img" class="breadcrumb-bg-04">
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content doctor-content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-xl-3 theiaStickySidebar">

                        <!-- Profile Sidebar -->
                        @include('layouts.doctorSidebar')
                        <!-- /Profile Sidebar -->

                    </div>
                     
                    <div class="col-lg-8 col-xl-9">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Profile Settings Tabs -->
                        <div class="dashboard-header">
                            <h3>Profile Settings</h3>
                        </div>

                        <!-- Settings List -->
                        <div class="setting-tab">
                            <div class="appointment-tabs">
                                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">Basic Details</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="speciality-tab" data-bs-toggle="tab" data-bs-target="#speciality" type="button" role="tab">Speciality & Services</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="availability-tab" data-bs-toggle="tab" data-bs-target="#availability" type="button" role="tab">Availability</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="consultation-tab" data-bs-toggle="tab" data-bs-target="#consultation" type="button" role="tab">Consultation Modes</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment" type="button" role="tab">Payment & Fees</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /Settings List -->

                        <!-- Tab Content -->
                        <div class="tab-content" id="profileTabsContent">
                            
                            <!-- Basic Details Tab -->
                            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                <div class="setting-title">
                                    <h5>Profile</h5>
                                </div>

                                <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="setting-card">
                                        <div class="change-avatar img-upload">
                                            <div class="profile-img">
                                                @if($doctor->dp)
                                                    <img src="{{ asset('storage/' . $doctor->dp) }}" alt="Profile" id="profilePreview">
                                                @else
                                                    <i class="fa-solid fa-user-doctor"></i>
                                                @endif
                                            </div>
                                            <div class="upload-img">
                                                <h5>Profile Image</h5>
                                                <div class="imgs-load d-flex align-items-center">
                                                    <div class="change-photo btn btn-outline-primary">
                                                        Upload New
                                                        <input type="file" name="dp" class="upload" id="profileImage" accept=".jpg,.jpeg,.png,.svg">
                                                    </div>
                                                    <button type="button" class="btn btn-link text-danger upload-remove" id="removeProfile">Remove</button>
                                                </div>
                                                <p class="form-text">
                                                    Your image should be below 4 MB. Accepted formats: JPG, PNG, SVG.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Personal Information</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Sex <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="sex">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male" {{ old('sex', $doctor->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ old('sex', $doctor->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                                                        <option value="Other" {{ old('sex', $doctor->sex) == 'Other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                                    <input type="date" name="dob" class="form-control" value="{{ old('dob', $doctor->dob) }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Blood Group</label>
                                                    <select class="form-select" name="blood_group">
                                                        <option value="">Select Blood Group</option>
                                                        <option value="A+" {{ old('blood_group', $doctor->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                                        <option value="A-" {{ old('blood_group', $doctor->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                                        <option value="B+" {{ old('blood_group', $doctor->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                                        <option value="B-" {{ old('blood_group', $doctor->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                                        <option value="O+" {{ old('blood_group', $doctor->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                                        <option value="O-" {{ old('blood_group', $doctor->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                                                        <option value="AB+" {{ old('blood_group', $doctor->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                                        <option value="AB-" {{ old('blood_group', $doctor->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Marital Status</label>
                                                    <select class="form-select" name="marital_status">
                                                        <option value="">Select Status</option>
                                                        <option value="Single" {{ old('marital_status', $doctor->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                                        <option value="Married" {{ old('marital_status', $doctor->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                                        <option value="Divorced" {{ old('marital_status', $doctor->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                                        <option value="Widowed" {{ old('marital_status', $doctor->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                                    <input type="text" name="address" class="form-control" value="{{ old('address', $doctor->address) }}" placeholder="Enter your residential address">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Primary Phone <span class="text-danger">*</span></label>
                                                    <input type="tel" name="phone_primary" class="form-control" value="{{ old('phone_primary', $doctor->phone_primary) }}" placeholder="e.g., +255 700 123 456">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Secondary Phone</label>
                                                    <input type="tel" name="phone_secondary" class="form-control" value="{{ old('phone_secondary', $doctor->phone_secondary) }}" placeholder="Optional">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-wrap">
                                                    <label class="form-label">Known Languages <span class="text-danger">*</span></label>
                                                    <div class="input-block input-block-new mb-0">
                                                        <input class="input-tags form-control" type="text" name="known_languages" data-role="tagsinput" value="{{ old('known_languages', $doctor->known_languages) }}" placeholder="e.g., English, Swahili, French">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Professional Experience</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="experience-container">
                                            @foreach($doctor->experiences ?? [['title' => '', 'hospital' => '', 'year_of_experience' => '', 'location' => '', 'job_description' => '', 'start_date' => '', 'end_date' => '', 'about_membership' => '']] as $index => $exp)
                                            <div class="experience-entry mb-4 p-3 border rounded">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                                            <input type="text" name="experiences[{{ $index }}][title]" class="form-control" value="{{ $exp['title'] }}" placeholder="e.g., Senior Surgeon">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Hospital <span class="text-danger">*</span></label>
                                                            <input type="text" name="experiences[{{ $index }}][hospital]" class="form-control" value="{{ $exp['hospital'] }}" placeholder="e.g., Aga Khan Hospital">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Years of Experience</label>
                                                            <input type="number" name="experiences[{{ $index }}][year_of_experience]" class="form-control" value="{{ $exp['year_of_experience'] }}" placeholder="e.g., 10">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Location</label>
                                                            <input type="text" name="experiences[{{ $index }}][location]" class="form-control" value="{{ $exp['location'] }}" placeholder="e.g., Dar es Salaam">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Job Description</label>
                                                            <textarea name="experiences[{{ $index }}][job_description]" class="form-control" rows="2" placeholder="Briefly describe your role and duties">{{ $exp['job_description'] }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Start Date</label>
                                                            <input type="date" name="experiences[{{ $index }}][start_date]" class="form-control" value="{{ $exp['start_date'] }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">End Date</label>
                                                            <input type="date" name="experiences[{{ $index }}][end_date]" class="form-control" value="{{ $exp['end_date'] }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-12">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Membership/Awards</label>
                                                            <input type="text" name="experiences[{{ $index }}][about_membership]" class="form-control" value="{{ $exp['about_membership'] }}" placeholder="e.g., Member of Medical Association">
                                                        </div>
                                                    </div>

                                                    @if($index > 0)
                                                    <div class="col-12 text-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-experience">Remove Experience</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="text-end mt-3">
                                            <button type="button" class="btn btn-outline-primary" id="addExperience">Add New Experience</button>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Biography</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="form-wrap">
                                            <label class="form-label">Professional Bio <span class="text-danger">*</span></label>
                                            <textarea name="bio" class="form-control" rows="5" placeholder="Tell patients about your professional background, expertise, and approach to care">{{ old('bio', $doctor->bio) }}</textarea>
                                            <p class="form-text">This will be displayed on your public profile. Minimum 200 characters.</p>
                                        </div>
                                    </div>

                                    <div class="modal-btn text-end mt-4">
                                        <button type="reset" class="btn btn-gray">Reset</button>
                                        <button type="submit" class="btn btn-primary prime-btn">Save Basic Details</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Speciality & Services Tab -->
                            <div class="tab-pane fade" id="speciality" role="tabpanel">
                                <form action="{{ route('doctor.speciality.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="setting-title">
                                        <h5>Medical Specialities</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Primary Speciality <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="primary_speciality" id="primarySpeciality">
                                                        <option value="">Select Primary Speciality</option>
                                                        @foreach($specialities as $speciality)
                                                            <option value="{{ $speciality->id }}" {{ $doctor->primary_speciality_id == $speciality->id ? 'selected' : '' }}>{{ $speciality->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Secondary Specialities</label>
                                                    <select class="form-select" name="secondary_specialities[]" id="secondarySpecialities" multiple>
                                                        @foreach($specialities as $speciality)
                                                            <option value="{{ $speciality->id }}" {{ in_array($speciality->id, $doctor->secondary_specialities ?? []) ? 'selected' : '' }}>{{ $speciality->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <p class="form-text">Hold Ctrl/Cmd to select multiple</p>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-wrap">
                                                    <label class="form-label">Areas of Expertise</label>
                                                    <div class="input-block input-block-new mb-0">
                                                        <input class="input-tags form-control" type="text" name="expertise_areas" data-role="tagsinput" value="{{ old('expertise_areas', $doctor->expertise_areas) }}" placeholder="e.g., Diabetes Management, Cardiac Care, Pediatric Surgery">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Medical Services</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-wrap">
                                                    <label class="form-label">Services Offered <span class="text-danger">*</span></label>
                                                    <div class="services-checkbox">
                                                        @foreach($services as $service)
                                                        <div class="form-check form-check-inline mb-3">
                                                            <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="service{{ $service->id }}" {{ in_array($service->id, $doctor->services ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="service{{ $service->id }}">
                                                                {{ $service->name }}
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-wrap">
                                                    <label class="form-label">Treatment & Procedures</label>
                                                    <textarea name="treatments" class="form-control" rows="4" placeholder="List specific treatments and procedures you specialize in">{{ old('treatments', $doctor->treatments) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Qualifications & Certifications</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="qualifications-container">
                                            @foreach($doctor->qualifications ?? [['degree' => '', 'university' => '', 'year' => '', 'certificate' => '']] as $index => $qual)
                                            <div class qualification-entry mb-3 p-3 border rounded">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Degree/Certificate <span class="text-danger">*</span></label>
                                                            <input type="text" name="qualifications[{{ $index }}][degree]" class="form-control" value="{{ $qual['degree'] }}" placeholder="e.g., MBBS, MD, PhD">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">University/Institution</label>
                                                            <input type="text" name="qualifications[{{ $index }}][university]" class="form-control" value="{{ $qual['university'] }}" placeholder="e.g., University of Dar es Salaam">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Year</label>
                                                            <input type="number" name="qualifications[{{ $index }}][year]" class="form-control" value="{{ $qual['year'] }}" placeholder="YYYY" min="1900" max="{{ date('Y') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Upload Certificate</label>
                                                            <input type="file" name="qualifications[{{ $index }}][certificate]" class="form-control">
                                                        </div>
                                                    </div>

                                                    @if($index > 0)
                                                    <div class="col-12 text-end mt-2">
                                                        <button type="button" class="btn btn-sm btn-danger remove-qualification">Remove</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="text-end mt-3">
                                            <button type="button" class="btn btn-outline-primary" id="addQualification">Add Qualification</button>
                                        </div>
                                    </div>

                                    <div class="modal-btn text-end mt-4">
                                        <button type="submit" class="btn btn-primary prime-btn">Save Speciality Settings</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Availability Tab -->
                            <div class="tab-pane fade" id="availability" role="tabpanel">
                                <form action="{{ route('doctor.availability.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="setting-title">
                                        <h5>Weekly Schedule</h5>
                                        <p class="text-muted">Set your regular working hours for each day of the week</p>
                                    </div>

                                    <div class="setting-card">
                                        <div class="weekly-schedule">
                                            @php
                                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                $availability = json_decode($doctor->availability ?? '{}', true);
                                            @endphp

                                            @foreach($days as $day)
                                            <div class="day-schedule mb-3 p-3 border rounded">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-2 col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input day-checkbox" type="checkbox" name="available_days[]" value="{{ strtolower($day) }}" id="day{{ $day }}" {{ isset($availability[strtolower($day)]) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold" for="day{{ $day }}">{{ $day }}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-10 col-md-9">
                                                        <div class="row time-slots">
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="form-wrap">
                                                                    <label class="form-label">Start Time</label>
                                                                    <input type="time" name="schedule[{{ strtolower($day) }}][start]" class="form-control time-input" value="{{ $availability[strtolower($day)]['start'] ?? '09:00' }}" {{ isset($availability[strtolower($day)]) ? '' : 'disabled' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="form-wrap">
                                                                    <label class="form-label">End Time</label>
                                                                    <input type="time" name="schedule[{{ strtolower($day) }}][end]" class="form-control time-input" value="{{ $availability[strtolower($day)]['end'] ?? '17:00' }}" {{ isset($availability[strtolower($day)]) ? '' : 'disabled' }}>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="form-wrap">
                                                                    <label class="form-label">Session Duration</label>
                                                                    <select class="form-select" name="schedule[{{ strtolower($day) }}][duration]" {{ isset($availability[strtolower($day)]) ? '' : 'disabled' }}>
                                                                        <option value="15" {{ ($availability[strtolower($day)]['duration'] ?? 30) == 15 ? 'selected' : '' }}>15 minutes</option>
                                                                        <option value="30" {{ ($availability[strtolower($day)]['duration'] ?? 30) == 30 ? 'selected' : '' }}>30 minutes</option>
                                                                        <option value="45" {{ ($availability[strtolower($day)]['duration'] ?? 30) == 45 ? 'selected' : '' }}>45 minutes</option>
                                                                        <option value="60" {{ ($availability[strtolower($day)]['duration'] ?? 30) == 60 ? 'selected' : '' }}>60 minutes</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="form-wrap">
                                                                    <label class="form-label">Max Patients</label>
                                                                    <input type="number" name="schedule[{{ strtolower($day) }}][max_patients]" class="form-control" value="{{ $availability[strtolower($day)]['max_patients'] ?? 10 }}" min="1" {{ isset($availability[strtolower($day)]) ? '' : 'disabled' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Break Time & Lunch Hours</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Lunch Start Time</label>
                                                    <input type="time" name="lunch_start" class="form-control" value="{{ $doctor->lunch_start ?? '13:00' }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Lunch End Time</label>
                                                    <input type="time" name="lunch_end" class="form-control" value="{{ $doctor->lunch_end ?? '14:00' }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-wrap">
                                                    <label class="form-label">Break Times (Optional)</label>
                                                    <textarea name="break_times" class="form-control" rows="3" placeholder="Format: Day - Start Time - End Time (e.g., Monday - 11:00 - 11:15)">{{ old('break_times', $doctor->break_times) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Time Off & Holidays</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="time-off-container">
                                            @foreach($doctor->time_offs ?? [] as $index => $timeOff)
                                            <div class="time-off-entry mb-3 p-3 border rounded">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Start Date</label>
                                                            <input type="date" name="time_offs[{{ $index }}][start_date]" class="form-control" value="{{ $timeOff['start_date'] }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-6">
                                                        <div class="form-wrap">
                                                            <label class="form-label">End Date</label>
                                                            <input type="date" name="time_offs[{{ $index }}][end_date]" class="form-control" value="{{ $timeOff['end_date'] }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-8">
                                                        <div class="form-wrap">
                                                            <label class="form-label">Reason</label>
                                                            <input type="text" name="time_offs[{{ $index }}][reason]" class="form-control" value="{{ $timeOff['reason'] }}" placeholder="e.g., Vacation, Conference">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-4">
                                                        <div class="form-wrap">
                                                            <label class="col-form-label d-block">&nbsp;</label>
                                                            <button type="button" class="btn btn-sm btn-danger remove-time-off">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="text-end mt-3">
                                            <button type="button" class="btn btn-outline-primary" id="addTimeOff">Add Time Off</button>
                                        </div>
                                    </div>

                                    <div class="modal-btn text-end mt-4">
                                        <button type="submit" class="btn btn-primary prime-btn">Save Availability Settings</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Consultation Modes Tab -->
                            <div class="tab-pane fade" id="consultation" role="tabpanel">
                                <form action="{{ route('doctor.consultation.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="setting-title">
                                        <h5>Consultation Methods</h5>
                                        <p class="text-muted">Enable/disable different consultation modes and set preferences</p>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="consultation-mode">
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" name="consultation_modes[]" value="video_call" id="videoCall" {{ in_array('video_call', $doctor->consultation_modes ?? []) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="videoCall">
                                                            <i class="fas fa-video me-2"></i> Video Consultation
                                                        </label>
                                                        <p class="form-text ps-4">Enable live video consultations with patients</p>
                                                    </div>

                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" name="consultation_modes[]" value="voice_call" id="voiceCall" {{ in_array('voice_call', $doctor->consultation_modes ?? []) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="voiceCall">
                                                            <i class="fas fa-phone-alt me-2"></i> Voice Call Consultation
                                                        </label>
                                                        <p class="form-text ps-4">Enable voice-only consultations</p>
                                                    </div>

                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" name="consultation_modes[]" value="chat" id="chat" {{ in_array('chat', $doctor->consultation_modes ?? []) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="chat">
                                                            <i class="fas fa-comments me-2"></i> Chat Consultation
                                                        </label>
                                                        <p class="form-text ps-4">Enable text-based consultations</p>
                                                    </div>

                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" name="consultation_modes[]" value="home_visit" id="homeVisit" {{ in_array('home_visit', $doctor->consultation_modes ?? []) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="homeVisit">
                                                            <i class="fas fa-home me-2"></i> Home Visit
                                                        </label>
                                                        <p class="form-text ps-4">Enable home visit consultations</p>
                                                    </div>

                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" name="consultation_modes[]" value="in_clinic" id="inClinic" {{ in_array('in_clinic', $doctor->consultation_modes ?? []) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="inClinic">
                                                            <i class="fas fa-hospital me-2"></i> In-Clinic Visit
                                                        </label>
                                                        <p class="form-text ps-4">Enable physical clinic appointments</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Preferred Platform for Video Calls</label>
                                                    <select class="form-select" name="video_platform">
                                                        <option value="">Built-in Platform</option>
                                                        <option value="zoom" {{ $doctor->video_platform == 'zoom' ? 'selected' : '' }}>Zoom</option>
                                                        <option value="google_meet" {{ $doctor->video_platform == 'google_meet' ? 'selected' : '' }}>Google Meet</option>
                                                        <option value="whatsapp" {{ $doctor->video_platform == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                                        <option value="custom" {{ $doctor->video_platform == 'custom' ? 'selected' : '' }}>Custom Link</option>
                                                    </select>
                                                </div>

                                                <div class="form-wrap mt-3">
                                                    <label class="form-label">Custom Video Link (if any)</label>
                                                    <input type="url" name="custom_video_link" class="form-control" value="{{ $doctor->custom_video_link }}" placeholder="https://meet.google.com/your-link">
                                                </div>

                                                <div class="form-wrap mt-3">
                                                    <label class="form-label">Home Visit Coverage Area (km)</label>
                                                    <input type="number" name="home_visit_radius" class="form-control" value="{{ $doctor->home_visit_radius ?? 10 }}" min="1" max="100">
                                                    <p class="form-text">Maximum distance for home visits from your location</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Consultation Preferences</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Minimum Booking Notice (hours)</label>
                                                    <input type="number" name="min_booking_notice" class="form-control" value="{{ $doctor->min_booking_notice ?? 2 }}" min="1">
                                                    <p class="form-text">Minimum hours required before booking</p>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Maximum Advance Booking (days)</label>
                                                    <input type="number" name="max_advance_booking" class="form-control" value="{{ $doctor->max_advance_booking ?? 30 }}" min="1" max="90">
                                                    <p class="form-text">How far in advance patients can book</p>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Buffer Time Between Appointments (minutes)</label>
                                                    <input type="number" name="buffer_time" class="form-control" value="{{ $doctor->buffer_time ?? 10 }}" min="0" max="60">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Cancellation Notice Period (hours)</label>
                                                    <input type="number" name="cancellation_notice" class="form-control" value="{{ $doctor->cancellation_notice ?? 24 }}" min="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-btn text-end mt-4">
                                        <button type="submit" class="btn btn-primary prime-btn">Save Consultation Settings</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Payment & Fees Tab -->
                            <div class="tab-pane fade" id="payment" role="tabpanel">
                                <form action="{{ route('doctor.payment.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="setting-title">
                                        <h5>Consultation Fees</h5>
                                        <p class="text-muted">Set different fees for each consultation mode</p>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Video Consultation Fee (TZS)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">TZS</span>
                                                        <input type="number" name="fees[video]" class="form-control" value="{{ $doctor->fees['video'] ?? 15000 }}" min="0" step="1000">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Voice Call Fee (TZS)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">TZS</span>
                                                        <input type="number" name="fees[voice]" class="form-control" value="{{ $doctor->fees['voice'] ?? 10000 }}" min="0" step="1000">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Chat Consultation Fee (TZS)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">TZS</span>
                                                        <input type="number" name="fees[chat]" class="form-control" value="{{ $doctor->fees['chat'] ?? 5000 }}" min="0" step="1000">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Home Visit Fee (TZS)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">TZS</span>
                                                        <input type="number" name="fees[home_visit]" class="form-control" value="{{ $doctor->fees['home_visit'] ?? 30000 }}" min="0" step="1000">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">In-Clinic Visit Fee (TZS)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">TZS</span>
                                                        <input type="number" name="fees[in_clinic]" class="form-control" value="{{ $doctor->fees['in_clinic'] ?? 20000 }}" min="0" step="1000">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Follow-up Discount (%)</label>
                                                    <div class="input-group">
                                                        <input type="number" name="followup_discount" class="form-control" value="{{ $doctor->followup_discount ?? 20 }}" min="0" max="100">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    <p class="form-text">Discount for follow-up consultations</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Payment Methods</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-wrap">
                                                    <label class="form-label">Accepted Payment Methods</label>
                                                    <div class="payment-methods">
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input" type="checkbox" name="payment_methods[]" value="mpesa" id="mpesa" {{ in_array('mpesa', $doctor->payment_methods ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="mpesa">
                                                                <i class="fas fa-mobile-alt me-1"></i> M-Pesa
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input" type="checkbox" name="payment_methods[]" value="tigopesa" id="tigopesa" {{ in_array('tigopesa', $doctor->payment_methods ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="tigopesa">
                                                                <i class="fas fa-wallet me-1"></i> Tigo Pesa
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input" type="checkbox" name="payment_methods[]" value="airtel_money" id="airtelMoney" {{ in_array('airtel_money', $doctor->payment_methods ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="airtelMoney">
                                                                <i class="fas fa-sim-card me-1"></i> Airtel Money
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input" type="checkbox" name="payment_methods[]" value="credit_card" id="creditCard" {{ in_array('credit_card', $doctor->payment_methods ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="creditCard">
                                                                <i class="fas fa-credit-card me-1"></i> Credit Card
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input" type="checkbox" name="payment_methods[]" value="bank_transfer" id="bankTransfer" {{ in_array('bank_transfer', $doctor->payment_methods ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="bankTransfer">
                                                                <i class="fas fa-university me-1"></i> Bank Transfer
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-2">
                                                            <input class="form-check-input" type="checkbox" name="payment_methods[]" value="cash" id="cash" {{ in_array('cash', $doctor->payment_methods ?? []) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="cash">
                                                                <i class="fas fa-money-bill-wave me-1"></i> Cash
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">M-Pesa Number</label>
                                                    <input type="tel" name="mpesa_number" class="form-control" value="{{ $doctor->mpesa_number }}" placeholder="e.g., 0757 123 456">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Bank Account Details</label>
                                                    <textarea name="bank_details" class="form-control" rows="2" placeholder="Bank Name, Account Number, Account Name">{{ $doctor->bank_details }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-title">
                                        <h5>Commission & Payout</h5>
                                    </div>

                                    <div class="setting-card">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Platform Commission (%)</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control bg-light" value="15" readonly>
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    <p class="form-text">Standard platform fee</p>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-wrap">
                                                    <label class="form-label">Payout Frequency</label>
                                                    <select class="form-select" name="payout_frequency">
                                                        <option value="weekly" {{ $doctor->payout_frequency == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                        <option value="bi_weekly" {{ $doctor->payout_frequency == 'bi_weekly' ? 'selected' : '' }}>Bi-Weekly</option>
                                                        <option value="monthly" {{ $doctor->payout_frequency == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-btn text-end mt-4">
                                        <button type="submit" class="btn btn-primary prime-btn">Save Payment Settings</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /Tab Content -->

                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Footer Section -->
        @include('layouts.footer')
        <!-- /Footer Section -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <!-- Sticky Sidebar JS -->
    <script src="{{asset('js/ResizeSensor.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>

    <!-- Select2 JS -->
    <script src="{{asset('js/select2.min.js')}}"></script>

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{asset('js/bootstrap-tagsinput.js')}}"></script>

    <!-- Profile Settings JS -->
    <script src="{{asset('js/profile-settings.js')}}"></script>

    <!-- Custom JS -->
    <script src="{{asset('js/script.js')}}"></script>

    <!-- Doctor Profile Custom JS -->
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#primarySpeciality, #secondarySpecialities').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Profile image preview
            $('#profileImage').change(function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profilePreview').attr('src', e.target.result);
                        $('.profile-img i').hide();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Remove profile image
            $('#removeProfile').click(function() {
                $('#profileImage').val('');
                $('#profilePreview').attr('src', '');
                $('.profile-img i').show();
            });

            // Add new experience entry
            $('#addExperience').click(function() {
                var index = $('.experience-entry').length;
                var html = `
                    <div class="experience-entry mb-4 p-3 border rounded">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="experiences[${index}][title]" class="form-control" placeholder="e.g., Senior Surgeon">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Hospital <span class="text-danger">*</span></label>
                                    <input type="text" name="experiences[${index}][hospital]" class="form-control" placeholder="e.g., Aga Khan Hospital">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Years of Experience</label>
                                    <input type="number" name="experiences[${index}][year_of_experience]" class="form-control" placeholder="e.g., 10">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Location</label>
                                    <input type="text" name="experiences[${index}][location]" class="form-control" placeholder="e.g., Dar es Salaam">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-wrap">
                                    <label class="form-label">Job Description</label>
                                    <textarea name="experiences[${index}][job_description]" class="form-control" rows="2" placeholder="Briefly describe your role and duties"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="experiences[${index}][start_date]" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="experiences[${index}][end_date]" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-wrap">
                                    <label class="form-label">Membership/Awards</label>
                                    <input type="text" name="experiences[${index}][about_membership]" class="form-control" placeholder="e.g., Member of Medical Association">
                                </div>
                            </div>
                            <div class="col-12 text-end mt-2">
                                <button type="button" class="btn btn-sm btn-danger remove-experience">Remove Experience</button>
                            </div>
                        </div>
                    </div>
                `;
                $('.experience-container').append(html);
            });

            // Remove experience entry
            $(document).on('click', '.remove-experience', function() {
                $(this).closest('.experience-entry').remove();
            });

            // Add new qualification
            $('#addQualification').click(function() {
                var index = $('.qualification-entry').length;
                var html = `
                    <div class="qualification-entry mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Degree/Certificate <span class="text-danger">*</span></label>
                                    <input type="text" name="qualifications[${index}][degree]" class="form-control" placeholder="e.g., MBBS, MD, PhD">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">University/Institution</label>
                                    <input type="text" name="qualifications[${index}][university]" class="form-control" placeholder="e.g., University of Dar es Salaam">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Year</label>
                                    <input type="number" name="qualifications[${index}][year]" class="form-control" placeholder="YYYY" min="1900" max="${new Date().getFullYear()}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Upload Certificate</label>
                                    <input type="file" name="qualifications[${index}][certificate]" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 text-end mt-2">
                                <button type="button" class="btn btn-sm btn-danger remove-qualification">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
                $('.qualifications-container').append(html);
            });

            // Remove qualification
            $(document).on('click', '.remove-qualification', function() {
                $(this).closest('.qualification-entry').remove();
            });

            // Day availability toggle
            $(document).on('change', '.day-checkbox', function() {
                var timeInputs = $(this).closest('.day-schedule').find('.time-input, select, [type="number"]');
                if ($(this).is(':checked')) {
                    timeInputs.prop('disabled', false);
                } else {
                    timeInputs.prop('disabled', true);
                }
            });

            // Initialize day availability
            $('.day-checkbox').each(function() {
                var timeInputs = $(this).closest('.day-schedule').find('.time-input, select, [type="number"]');
                if (!$(this).is(':checked')) {
                    timeInputs.prop('disabled', true);
                }
            });

            // Add time off
            $('#addTimeOff').click(function() {
                var index = $('.time-off-entry').length;
                var html = `
                    <div class="time-off-entry mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="time_offs[${index}][start_date]" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-wrap">
                                    <label class="form-label">End Date</label>
                                    <input type="date" name="time_offs[${index}][end_date]" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-8">
                                <div class="form-wrap">
                                    <label class="form-label">Reason</label>
                                    <input type="text" name="time_offs[${index}][reason]" class="form-control" placeholder="e.g., Vacation, Conference">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="form-wrap">
                                    <label class="col-form-label d-block">&nbsp;</label>
                                    <button type="button" class="btn btn-sm btn-danger remove-time-off">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('.time-off-container').append(html);
            });

            // Remove time off
            $(document).on('click', '.remove-time-off', function() {
                $(this).closest('.time-off-entry').remove();
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);

            // Form validation for required fields
            $('form').submit(function(e) {
                var currentTab = $('#profileTabs .nav-link.active').attr('id');
                var isValid = true;
                var firstError = null;

                // Validate required fields in current tab
                $('#' + currentTab.replace('-tab', '') + ' [required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                        if (!firstError) {
                            firstError = $(this);
                        }
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (!isValid && firstError) {
                    e.preventDefault();
                    firstError.focus();
                    alert('Please fill in all required fields marked with *');
                }
            });
        });
    </script>

</body>
</html>