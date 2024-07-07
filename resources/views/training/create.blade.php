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
                                            <select class="form-select border border-2 p-2" name="facilitator" aria-label="">
                                                <option value="" selected>Select Facilitator</option>
                                                @foreach($facilitators as $facilitator)
                                                <option value="{!! $facilitator->id !!}">{!! $facilitator->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="facilitatorError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Training Center</label>
                                            <select class="form-select border border-2 p-2" name="training_center" aria-label="">
                                                <option value="" selected>Select Training Center</option>
                                                @foreach($centers as $center)
                                                <option value="{!! $center->id !!}">{!! $center->name !!}</option>
                                                @endforeach
                                            </select>
                                            <p class='text-danger font-weight-bold inputerror' id="training_centerError"></p>
                                        </div>

                                        <div class="mb-3 col-md-2">
                                            <label class="form-label">Project</label>
                                            <select class="form-select border border-2 p-2" name="project" aria-label="">
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
                                            <label class="form-label">Start Time</label>
                                            <input type="time" name="start_time" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="start_timeError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" name="end_date" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="end_dateError"></p>
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">End Time</label>
                                            <input type="time" name="end_time" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="end_timeError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Number of Days (Actual)</label>
                                            <input type="number" name="number_of_days" class="form-control border border-2 p-2">
                                            <p class='text-danger font-weight-bold inputerror' id="number_of_daysError"></p>
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control border border-2 p-2"></textarea>
                                            <p class='text-danger font-weight-bold inputerror' id="contact_personError"></p>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn bg-gradient-dark btn-submit">Create Training <span id="loader"></span></button>
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
