<style>
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6 !important;
    }
</style>

<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="participants"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Participants"></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4>
            <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="me-3 my-3 text-end">
                        <a class="btn bg-success mb-0 end text-white" data-bs-toggle="modal"
                            data-bs-target="#newParticipantModal">
                            <i class="material-icons text-sm">person</i>
                            <i class="material-icons text-sm">add</i>&nbsp;&nbsp;
                            Add New Participant
                        </a>
                        <a class="btn bg-primary mb-0 end text-white" id="upload-btn"
                            data-value="{{ route('get.upload.participants') }}">
                            <i class="material-icons text-sm">upload</i>&nbsp;&nbsp;
                            Upload Participants
                        </a>
                    </div>
                    @if (session('status'))
                        <div class="row">
                            <div class="col-md-9">
                                <div class="alert alert-success alert-dismissible text-white fade show" role="alert"
                                    style="margin-left:20px;width:90%;">
                                    <span class="text-sm">{{ Session::get('status') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @elseif (session('error'))
                        <div class="row">
                            <div class="col-md-9">
                                <div class="alert alert-danger alert-dismissible text-white fade show" role="alert"
                                    style="margin-left:20px;width:90%;">
                                    <span class="text-sm">{{ Session::get('error') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card-body px-3 pb-2">
                        @if (count($participants) > 0)
                            <div class="table-responsive px-0">
                                <table class="table table-sm table-bordered hover mb-0" id="table">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-dark text-xxl font-weight-bolder"
                                                scope="col">ID No.</th>
                                            <th rowspan="2" class="text-dark text-xxl font-weight-bolder px-4"
                                                scope="col">Name</th>
                                            <th rowspan="2" class="text-dark text-xxl font-weight-bolder"
                                                scope="col">Gender</th>
                                            <th rowspan="2" class="text-dark text-xxl font-weight-bolder"
                                                scope="col">Age</th>
                                            <th rowspan="2" class="text-dark text-xxl font-weight-bolder"
                                                scope="col">Category</th>
                                            <th rowspan="2" class="text-dark text-xxl font-weight-bolder"
                                                scope="col">Phone</th>
                                            <th rowspan="2" class="text-dark text-xxl font-weight-bolder"
                                                scope="col">Address</th>
                                            @if (count($projects) > 0)
                                                @foreach ($projects as $project)
                                                    @php
                                                        $countTrainings = 0;
                                                        foreach ($trainings as $training) {
                                                            if ($training->project == $project->id) {
                                                                $countTrainings++;
                                                            }
                                                        }
                                                    @endphp
                                                    @if ($countTrainings > 0)
                                                        <th colspan="{{ $countTrainings }}"
                                                            class="text-dark text-xxl font-weight-bolder"
                                                            scope="col">{{ $project->name }}</th>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <th rowspan="2" class="text-dark text-xxl font-weight-bolder"
                                                scope="col">Action</th>
                                        </tr>
                                        <tr>
                                            @if (count($projects) > 0)
                                                @foreach ($projects as $project)
                                                    @foreach ($trainings as $training)
                                                        @if ($training->project == $project->id)
                                                            <th class="text-dark text-xxl font-weight-bolder"
                                                                scope="col">{{ $training->name }}</th>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($participants as $participant)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-2">
                                                        <p class="text-m text-secondary font-weight-bold mb-0">
                                                            {{ $participant->id_no }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-2">
                                                        <p class="text-m text-secondary font-weight-bold mb-0">
                                                            {{ $participant->name }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-secondary font-weight-bold mb-0">
                                                            {{ $participant->gender }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span
                                                            class="text-secondary text-m font-weight-bold">{{ $participant->age }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span
                                                            class="text-secondary text-m font-weight-bold">{{ $participant->category }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span
                                                            class="text-secondary text-m font-weight-bold">{{ $participant->phone }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span
                                                            class="text-secondary text-m font-weight-bold">{{ $participant->address }}</span>
                                                    </div>
                                                </td>

                                                @foreach ($projects as $project)
                                                    @foreach ($trainings as $training)
                                                        @if ($training->project == $project->id)
                                                            <td>
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    @php
                                                                        $trainings_data = json_decode(
                                                                            $participant->trainings,
                                                                            true,
                                                                        );
                                                                        $status = 'Not Attended';
                                                                        $attendedFrom = '';
                                                                        $attendedTo = '';
                                                                        if ($trainings_data) {
                                                                            foreach (
                                                                                $trainings_data
                                                                                as $training_data
                                                                            ) {
                                                                                if (
                                                                                    $training_data['training_id'] ==
                                                                                    $training->id
                                                                                ) {
                                                                                    $status = 'Attended';
                                                                                    $attendedFrom =
                                                                                        $training_data[
                                                                                            'attended_from'
                                                                                        ] ?? '';
                                                                                    $attendedTo =
                                                                                        $training_data['attended_to'] ??
                                                                                        '';
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    <a href="#"
                                                                        class="status-link {{ $status == 'Attended' ? 'text-success' : 'text-danger' }}"
                                                                        data-participant-id="{{ $participant->id }}"
                                                                        data-training-id="{{ $training->id }}"
                                                                        data-status="{{ $status }}"
                                                                        data-attended-from="{{ $attendedFrom }}"
                                                                        data-attended-to="{{ $attendedTo }}">
                                                                        {{ $status }}
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                <td class="not-export-col">
                                                    <a rel="tooltip" class="btn btn-link p-0 m-0" role="btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateParticipantModal-{{ $participant->id }}">
                                                        <i class="material-icons" style="font-size:1.4rem;">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </a>

                                                    @if ($participant->role != 'Administrator')
                                                        <button type="button" class="btn btn-link p-0 m-0"
                                                            role="btn" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-{{ $participant->id }}"
                                                            title="Delete User">
                                                            <i class="material-icons"
                                                                style="font-size:1.4rem;">delete</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>

                                            <div class="modal fade"
                                                id="updateParticipantModal-{{ $participant->id }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="updateParticipantModal" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="updateParticipantModalLabel">Update Participant
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form method='POST' action='#'
                                                                id="updateParticipantForm">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">ID No.</label>
                                                                        <input type="text" name="id_no"
                                                                            class="form-control border border-2 p-2"
                                                                            value="{{ $participant->id_no }}">
                                                                        <p class='text-danger font-weight-bold inputerror'
                                                                            id="id_noError"></p>
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Name</label>
                                                                        <input type="text" name="name"
                                                                            class="form-control border border-2 p-2"
                                                                            value="{{ $participant->name }}">
                                                                        <p class='text-danger font-weight-bold inputerror'
                                                                            id="nameError"></p>
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Gender</label>
                                                                        <input type="text" name="gender"
                                                                            class="form-control border border-2 p-2"
                                                                            value="{{ $participant->gender }}">
                                                                        <p class='text-danger font-weight-bold inputerror'
                                                                            id="genderError"></p>
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Age</label>
                                                                        <input type="text" name="age"
                                                                            class="form-control border border-2 p-2"
                                                                            value="{{ $participant->age }}">
                                                                        <p class='text-danger font-weight-bold inputerror'
                                                                            id="ageError"></p>
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Category</label>
                                                                        <input type="text" name="category"
                                                                            class="form-control border border-2 p-2"
                                                                            value="{{ $participant->category }}">
                                                                        <p class='text-danger font-weight-bold inputerror'
                                                                            id="categoryError"></p>
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Phone</label>
                                                                        <input type="text" name="phone"
                                                                            class="form-control border border-2 p-2"
                                                                            value="{{ $participant->phone }}">
                                                                        <p class='text-danger font-weight-bold inputerror'
                                                                            id="phoneError"></p>
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Address</label>
                                                                        <input type="text" name="address"
                                                                            class="form-control border border-2 p-2"
                                                                            value="{{ $participant->address }}">
                                                                        <p class='text-danger font-weight-bold inputerror'
                                                                            id="addressError"></p>
                                                                    </div>
                                                                    @foreach ($projects as $project)
                                                                        <div class="col-12">
                                                                            <h6 class="mb-3 text-center">
                                                                                {{ $project->name }}</h6>
                                                                        </div>
                                                                        @foreach ($trainings as $training)
                                                                            @if ($training->project == $project->id)
                                                                                <div class="mb-3 col-md-6">
                                                                                    <div class="form-check">
                                                                                        <input type="checkbox"
                                                                                            class="form-check-input"
                                                                                            name="trainings[]"
                                                                                            value="{{ $training->id }}"
                                                                                            @php
$trainings_data = json_decode($participant->trainings, true);
                                                                                                    if ($trainings_data) {
                                                                                                        foreach ($trainings_data as $training_data) {
                                                                                                            if ($training_data['training_id'] == $training->id) {
                                                                                                                echo 'checked';
                                                                                                            }
                                                                                                        }
                                                                                                    } @endphp>
                                                                                        <label
                                                                                            class="form-check-label">{{ $training->name }}</label>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn bg-gradient-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit"
                                                                        class="btn bg-gradient-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="deleteModal-{{ $participant->id }}"
                                                tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="deleteModalLabel">Confirm
                                                                Delete</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this participant?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn bg-gradient-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <form
                                                                action="{{ route('delete.participant', ['id' => $participant->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn bg-gradient-primary">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="card-header">
                                <h6 class="text-sm text-center">No participants added yet!</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</x-layout>

<script>
    $(document).on('click', '#del-btn', function(event) {
        event.preventDefault();
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(document).on('click', '#open-update', function() {
        var user_id = $(this).data("value");
        var url = '{{ route('get.participant', ':id') }}';
        url = url.replace(':id', user_id);
        window.location.assign(url);
    });

    $(document).on('click', '#upload-btn', function(event) {
        event.preventDefault();
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(document).on('click', '.btn-submit-update', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        let route = '{{ route('update.participant', ':id') }}';
        route = route.replace(':id', id);

        let formData = $('#updateParticipantForm').serializeArray();
        $(".inputerror").text("");
        $("#updateParticipantForm input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: route,
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit").prop("disabled", false);
                let url = '{{ route('update.participant.success', ':id') }}';
                url = url.replace(':id', response.id);
                window.location.assign(url);
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit").prop("disabled", false);

                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        $("[name='" + key + "']").addClass("is-invalid");
                        $("#" + key + "Error").text(errors[key][0]);
                    });
                } else {
                    // window.location.reload();
                }
            }
        })
    });
</script>

@include('participant.create')
@include('participant.attendance')
