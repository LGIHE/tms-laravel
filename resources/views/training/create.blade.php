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

    .circular-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: none;
        color: blue;
    }
    .circular-btn i {
        font-size: 1.25rem;
    }
</style>

<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="trainings"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Trainings'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-2">
            <div class="card card-body mx-3 mx-md-4 ">

                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        @if (session('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="bio-form">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">Training Information</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="#" id="addTraining">
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="nameError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Facilitator</label>
                                            <div class="d-flex">
                                                <select id="facilitator-records" class="form-select p-2" name="facilitators[]" multiple aria-label="">
                                                    {{-- <option value="" selected>Select Facilitator</option> --}}
                                                    @foreach($facilitators as $facilitator)
                                                    <option value="{!! $facilitator->id !!}">{!! $facilitator->name !!}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="ms-2 circular-btn" data-bs-toggle="modal" data-bs-target="#addFacilitatorModal">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <p class='text-danger font-weight-bold inputerror' id="facilitatorsError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Training Venue</label>
                                            <div class="d-flex">
                                                <select id="center-records" class="form-select border-2 p-2" name="training_venue" aria-label="">
                                                    <option value="" selected>Select Training Venue</option>
                                                    @foreach($venues as $venue)
                                                    <option value="{!! $venue->id !!}">{!! $venue->name !!}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="ms-2 circular-btn" data-bs-toggle="modal" data-bs-target="#addTrainingVenueModal">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <p class='text-danger font-weight-bold inputerror' id="training_centerError"></p>
                                        </div>

                                        <div class="mb-3 col-md-2">
                                            <label class="form-label">Project</label>
                                            <select id="project-records"  class="form-select border-2 p-2" name="project" aria-label="">
                                                <option value="" selected>Select Project</option>
                                                @foreach($projects as $project)
                                                <option value="{!! $project->id !!}">{!! $project->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="projectError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" name="start_date" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="start_dateError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" name="end_date" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="end_dateError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="descriptionError"></p>
                                        </div>

                                    </div>

                                    <button type="submit" id="submit-training-btn" class="btn bg-gradient-dark btn-submit">Create Training <span id="loader"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>

<script>
$(document).ready(function() {
    $('#facilitator-records').select2();
    $('#center-records').select2();
    $('#project-records').select2();

    $('#submit-training-btn').on('click', function (e) {
        e.preventDefault();

        let formData = $('#addTraining').serializeArray();
        $(".inputerror").text("");
        $("#addTraining input").removeClass("is-invalid");
        $("#addTraining select").removeClass("is-invalid");
        $("#addTraining textarea").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $("#submit-training-btn").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('create.training') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $("#submit-training-btn").prop("disabled", false);
                window.location.assign('{{route("create.training.success")}}');
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $("#submit-training-btn").prop("disabled", false);

                if(response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $("[name='" + key + "']").addClass("is-invalid");
                        $("#" + key + "Error").text(errors[key][0]);
                    });
                } else {
                    // window.location.reload();
                }
            }
        })
    });
});
</script>

@include('training.addFacilitator')
@include('training.addVenue')
