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
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="bio-form">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-3">Update Training Information</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="#" id="addTraining">
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" value="{{ $training->name }}" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="nameError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Facilitator</label>
                                            <select class="form-select" name="facilitator" aria-label="">
                                                <option value="" selected>Select Type</option>
                                                @foreach($facilitators as $facilitator)
                                                <option value="{!! $facilitator->id !!}" {{ $facilitator->id == $training->facilitator ? "selected" : '' }}>{!! $facilitator->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="facilitatorError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Training Center</label>
                                            <select class="form-select" name="training_center" aria-label="">
                                                <option value="" selected>Select Type</option>
                                                @foreach($centers as $center)
                                                <option value="{!! $center->id !!}" {{ $center->id == $training->training_center ? "selected" : '' }}>{!! $center->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="training_centerError"></p>
                                        </div>

                                        <div class="mb-3 col-md-2">
                                            <label class="form-label">Project</label>
                                            <select class="form-select" name="project" aria-label="">
                                                <option value="" selected>Select Type</option>
                                                @foreach($projects as $project)
                                                <option value="{!! $project->id !!}" {{ $project->id == $training->project ? "selected" : '' }}>{!! $project->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="projectError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" name="start_date" value="{{ $training->start_date }}" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="start_dateError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Start Time</label>
                                            <input type="time" name="start_time" value="{{ $training->start_time }}" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="start_timeError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" name="end_date" value="{{ $training->end_date }}" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="end_dateError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">End Time</label>
                                            <input type="time" name="end_time" value="{{ $training->end_time }}" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="end_timeError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" value="{{ $training->description }}" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="contact_personError"></p>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn bg-gradient-dark btn-submit">Update Training <span id="loader"></span></button>
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

$(function () {

    $('.btn-submit').on('click', function (e) {
        e.preventDefault();

        let formData = $('#addTraining').serializeArray();
        $(".inputerror").text("");
        $("#addTraining input").removeClass("is-invalid");
        $("#addTraining select").removeClass("is-invalid");
        $("#addTraining textarea").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('create.training') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit").prop("disabled", false);
                window.location.assign('{{route("create.training.success")}}');
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit").prop("disabled", false);

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
})
</script>
