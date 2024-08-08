<style>
    .select2-container--default .select2-selection--single {
        padding: 5px;
        border: 1px solid #d2d6da !important;
    }

    .select2-container .select2-selection--single {
        height: 42px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #7b809a !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
    }

    span.select2-container--default {
        width: 100% !important;
    }
</style>

@foreach ($participants as $participant)
<!-- Participant Update modal -->
<div class="modal fade" id="updateParticipantModal-{{ $participant->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateParticipantModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateParticipantModalLabel">Update Participant</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method='POST' action='#' id="updateParticipantForm-{{ $participant->id }}">
                    @csrf
                    <input type="hidden" name="training_id" value="{{ $training->id }}">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">ID No.</label>
                            <input type="text" name="id_no" class="form-control border border-2 p-2" value="{{ $participant->id_no }}">
                            <p class='text-danger font-weight-bold inputerror' id="id_noError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control border border-2 p-2" value="{{ $participant->name }}">
                            <p class='text-danger font-weight-bold inputerror' id="nameError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email Address</label>
                            <input type="text" name="email" class="form-control border border-2 p-2" value="{{ $participant->email }}">
                            <p class='text-danger font-weight-bold inputerror' id="emailError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select border border-2 p-2" name="gender" aria-label="">
                                <option value="" selected>Select Gender</option>
                                <option value="Male" {{ $participant->gender == "Male" ? "selected" : '' }}>Male</option>
                                <option value="Female" {{ $participant->gender == "Female" ? "selected" : '' }}>Female</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="genderError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control border border-2 p-2" value="{{ $participant->age }}">
                            <p class='text-danger font-weight-bold inputerror' id="ageError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select border border-2 p-2" name="category" aria-label="">
                                <option value="" selected>Select Category</option>
                                <option value="Teacher" {{ $participant->category == "Teacher" ? "selected" : '' }}>Teacher</option>
                                <option value="Student" {{ $participant->category == "Student" ? "selected" : '' }}>Student</option>
                                <option value="Youth" {{ $participant->category == "Youth" ? "selected" : '' }}>Youth</option>
                                <option value="School Leader" {{ $participant->category == "School Leader" ? "selected" : '' }}>School Leader</option>
                                <option value="Community Leader" {{ $participant->category == "Community Leader" ? "selected" : '' }}>Community Leader</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="categoryError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Education Level</label>
                            <input type="text" name="education_level" class="form-control border border-2 p-2" value="{{ $participant->education_level }}">
                            <p class='text-danger font-weight-bold inputerror' id="education_levelError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nationality</label>
                            <select class="form-select border border-2 p-2" name="nationality" aria-label="">
                                <option value="" selected>Select Nationality</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->nationality }}" {{ $participant->nationality == $country->nationality ? "selected" : '' }}>{{ $country->nationality }}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="nationalityError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="number" name="phone" class="form-control border border-2 p-2" value="{{ $participant->phone }}">
                            <p class='text-danger font-weight-bold inputerror' id="phoneError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">District</label>
                            <input type="text" name="district" class="form-control border border-2 p-2" value="{{ $participant->district }}">
                            <p class='text-danger font-weight-bold inputerror' id="districtError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Institution/Organization</label>
                            <input type="text" name="institution" class="form-control border border-2 p-2" value="{{ $participant->institution }}">
                            <p class='text-danger font-weight-bold inputerror' id="institutionError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Institution/Organization Ownership</label>
                            <select class="form-select border border-2 p-2" name="institution_ownership" aria-label="">
                                <option value="" selected>Select Ownership</option>
                                <option value="Public" {{ $participant->institution_ownership == "Public" ? "selected" : '' }}>Public</option>
                                <option value="Private" {{ $participant->institution_ownership == "Private" ? "selected" : '' }}>Private</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="institution_ownershipError"></p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Subjects</label>
                            <select class="form-select p-2 subjects-select" name="subjects[]" multiple aria-label="">
                                @foreach($subjects as $subject)
                                @if ($participant->subjects)
                                @php
                                $participantSubjects = json_decode($participant->subjects, true);
                                @endphp
                                <option value="{{ $subject->name }}" {{ is_array($participantSubjects) && in_array($subject->name, $participantSubjects) ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @else
                                <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                                @endif
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="subjectsError"></p>
                        </div>

                        @php
                            $attended_dates = [];
                            foreach(json_decode($participant->trainings, true) as $training_attended) {
                                if($training_attended['training_id'] == $training->id) {
                                    $attended_dates = array_merge($attended_dates, $training_attended['dates']);
                                }
                            }
                            $attended_dates_str = implode(', ', $attended_dates);
                        @endphp

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Days Attended</label>
                            <input type="text" class="datepicker-update form-control border border-2 p-2" name="attended_dates" value="{{ $attended_dates_str }}" readonly>
                            <p class='text-danger font-weight-bold inputerror' id="attended_datesError"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn bg-gradient-primary btn-submit-update" data-id="{{ $participant->id }}">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    $(document).ready(function(){
        // Initialize Select2 for all elements with class 'subjects-select'
        $('.subjects-select').select2();

        // Initialize datepicker for all elements with class 'datepicker-update'
        $('.datepicker-update').multiDatesPicker({
            dateFormat: 'dd/mm/yy',
        });
    });

    $(document).on('shown.bs.modal', '.modal', function () {
        // Reinitialize Select2 and datepicker for dynamically shown modals
        $('.subjects-select').select2();
        $('.datepicker-update').multiDatesPicker({
            dateFormat: 'dd/mm/yy',
        });
    });

    $(document).on('click', '.btn-submit-update', function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        });

        let id = $(this).data('id');
        let route = '{{route("update.participant",":id")}}';
        route = route.replace(':id', id);

        const formId = '#updateParticipantForm-'+id;
        let formData = $(formId).serialize();

        console.log(formData);

        $(".inputerror").text("");
        $(formId+" input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit-update").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: route,
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit-update").prop("disabled", false);
                let url = '{{route("training",":id")}}';
                url = url.replace(':id', response.id);
                window.location.assign(url);
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit-update").prop("disabled", false);

                if(response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $("[name='" + key + "']").addClass("is-invalid");
                        $("#" + key + "Error").text(errors[key][0]);
                    });
                } else {
                    window.location.reload();
                }
            }
        })
    });
</script>

