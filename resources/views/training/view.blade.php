<style>
    a.nav-link,
    a.nav-link:hover {
        color: black;
    }

    .btn-close {
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    #updateTraineeModalLabel {
        font-family: var(--bs-body-font-family) !important;
    }

    #addBtn {
        position: fixed;
        bottom: 0px;
        right: 30px;
        z-index: 99;
        font-size: 20px;
        border: none;
        outline: none;
        background-color: red;
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 60px;
    }

    #addBtn:hover {
        background-color: #555;
    }

    #ui-datepicker-div {
        position: absolute!important;
    }
</style>

<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="trainings"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Training'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 mt-2">
            <div class="card card-body">

                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        @if (session('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @elseif (session('error'))
                        <div class="row">
                            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('error') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="card-header pb-0 p-2 pt-0">
                            <div class="row mb-5">
                                <div class="me-3 my-3 text-end">
                                    <a class="btn bg-gradient-success mb-0 end" id="open-update"
                                        data-value="{{ $training->id }}">
                                        <i class="material-icons text-sm">edit</i>&nbsp;&nbsp;Edit
                                    </a>
                                    <a class="btn bg-gradient-info mb-0 end">
                                        <i class="material-icons text-sm">download</i>&nbsp;&nbsp;Download
                                    </a>
                                </div>
                                <div class="col-md-8 d-flex align-items-center">
                                    <h5 class="mb-3">{{ $training->name }}</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Description:</p>&nbsp;
                                    <p class="text-dark">{{ $training->description }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Facilitator:</p>&nbsp;
                                    <p class="text-dark">
                                        @foreach ($facilitators as $facilitator)
                                            @if($facilitator->id == $training->facilitator ) {{ $facilitator->name }} @endif
                                        @endforeach
                                    </p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Project:</p>&nbsp;
                                    <p class="text-dark">
                                        @foreach ( $projects as $project )
                                            @if ($project->id == $training->project)
                                                {{ $project->name }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Training Center:</p>&nbsp;
                                    <p class="text-dark">
                                        @foreach ( $centers as $center )
                                            @if ($center->id == $training->training_center)
                                                {{ $center->name }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Start Date:</p>&nbsp;
                                    <p class="text-dark">{{ $training->start_date }}</p>
                                </div>
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">End Date:</p>&nbsp;
                                    <p class="text-dark">{{ $training->end_date }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <p class="text-dark font-weight-bold">Country:</p>&nbsp;
                                    <p class="text-dark">
                                        @foreach ($centers as $center)
                                            @if ($center->id == $training->training_center)
                                                @foreach ($countries as $country)
                                                    @if ($country->code == $center->country)
                                                        {{ $country->name }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="me-3 my-3 text-end">
                                <a class="btn bg-gradient-success mb-0 end" data-bs-toggle="modal" data-bs-target="#newTraineeModal">
                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Trainee
                                </a>
                            </div>
                        </div>

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#steps-tab">Trainees</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-2">
                            <div class="tab-pane fade show active" id="steps-tab" role="tabpanel" aria-labelledby="steps-tab">
                                <div class="card-body px-0 pb-2">
                                    @if (count($trainees) > 0)
                                    <div class="table-responsive p-0">
                                        <table class="table table-sm hover mb-0" id="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-secondary text-xxl font-weight-bolder px-4">Name
                                                    </th>
                                                    <th class="text-secondary text-xxl font-weight-bolder">Gender</th>
                                                    <th class="text-secondary text-xxl font-weight-bolder">Age</th>
                                                    <th class="text-secondary text-xxl font-weight-bolder">Contact</th>
                                                    <th class="text-secondary text-xxl font-weight-bolder">Address</th>
                                                    <th class="text-secondary text-xxl font-weight-bolder">Email</th>
                                                    <th class="text-secondary text-xxl font-weight-bolder">Days Attended</th>
                                                    <th class="text-secondary"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ( $trainees as $trainee )

                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center px-2">
                                                            <p class="text-m text-dark font-weight-bold mb-0">{{
                                                                $trainee->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-m text-dark font-weight-bold mb-0">{{
                                                                $trainee->gender }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <span class="text-dark text-m font-weight-bold">{{
                                                                $trainee->age }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <span class="text-dark text-m font-weight-bold">{{
                                                                $trainee->phone }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <span class="text-dark text-m font-weight-bold">{{
                                                                $trainee->address }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-m text-dark font-weight-bold mb-0">{{
                                                                $trainee->email }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="text-m text-dark font-weight-bold mb-0">
                                                                @if ($trainee->attendance != null)
                                                                    {{ count(explode(",", $trainee->attendance )) }}
                                                                @else 0 @endif
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td class="not-export-col">
                                                        <a rel="tooltip" class="btn btn-link p-0 m-0" role="btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateTraineeModal-{{$trainee->id}}">
                                                            <i class="material-icons" style="font-size:1.4rem;">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>

                                                        @if ($trainee->role != 'Administrator')
                                                        <button type="button" class="btn btn-link p-0 m-0" role="btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal-{{$trainee->id}}"
                                                            title="Delete User">
                                                            <i class="material-icons"
                                                                style="font-size:1.4rem;">delete</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <!-- Trainee Update modal -->
                                                <div class="modal fade" id="updateTraineeModal-{{ $trainee->id }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="updateTraineeModal" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5"
                                                                    id="updateTraineeModalLabel">Update Trainee</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method='POST' action='#' id="updateTraineeForm-{{ $trainee->id }}">
                                                                    @csrf
                                                                    <input type="hidden" name="training" value="{{ $training->id }}">
                                                                    <div class="row">

                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Name</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control border border-2 p-2"
                                                                                value="{{ $trainee->name }}">
                                                                            <p class='text-danger font-weight-bold inputerror'
                                                                                id="nameError"></p>
                                                                        </div>

                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Email
                                                                                address</label>
                                                                            <input type="email" name="email"
                                                                                class="form-control border border-2 p-2"
                                                                                value="{{ $trainee->email }}">
                                                                            <p class='text-danger font-weight-bold inputerror'
                                                                                id="emailError"></p>
                                                                        </div>

                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Gender</label>
                                                                            <select class="form-select" name="gender"
                                                                                aria-label="">
                                                                                <option value="" selected>Select Gender
                                                                                </option>
                                                                                <option value="Male" {{ $trainee->gender
                                                                                    == "Male" ? "selected" : '' }}>Male
                                                                                </option>
                                                                                <option value="Female" {{ $trainee->
                                                                                    gender == "Female" ? "selected" : ''
                                                                                    }}>Female</option>
                                                                            </select>
                                                                            <p class='text-danger font-weight-bold inputerror'
                                                                                id="genderError"></p>
                                                                        </div>

                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Age</label>
                                                                            <input type="number" name="age"
                                                                                class="form-control border border-2 p-2"
                                                                                value="{{ $trainee->age }}">
                                                                            <p class='text-danger font-weight-bold inputerror'
                                                                                id="ageError"></p>
                                                                        </div>

                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Category</label>
                                                                            <select class="form-select" name="category" aria-label="">
                                                                                <option value="" selected>Select Category</option>
                                                                                <option value="Teacher" {{ $trainee->category == "Teacher" ? "selected" : '' }}>Teacher</option>
                                                                                <option value="Youth" {{ $trainee->category == "Youth" ? "selected" : '' }}>Youth</option>
                                                                                <option value="School Leader" {{ $trainee->category == "School Leader" ? "selected" : '' }}>School Leader</option>
                                                                                <option value="Community Leader" {{ $trainee->category == "Community Leader" ? "selected" : '' }}>Community Leader</option>
                                                                            </select>
                                                                            <p class='text-danger font-weight-bold inputerror' id="categoryError"></p>
                                                                        </div>

                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Nationality</label>
                                                                            <select class="form-select" name="nationality" aria-label="">
                                                                                <option value="" selected>Select Nationality</option>
                                                                                @foreach ($countries as $country)
                                                                                    <option value="{{ $country->nationality }}" {{ $trainee->nationality == $country->nationality ? "selected" : '' }}>{{ $country->nationality }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <p class='text-danger font-weight-bold inputerror' id="nationalityError"></p>
                                                                        </div>

                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Phone</label>
                                                                            <input type="text" name="phone"
                                                                                class="form-control border border-2 p-2"
                                                                                value="{{ $trainee->phone }}">
                                                                            <p class='text-danger font-weight-bold inputerror'
                                                                                id="phoneError"></p>
                                                                        </div>

                                                                        <div class="mb-3 col-md-6">
                                                                            <label class="form-label">Address</label>
                                                                            <textarea name="address"
                                                                                class="form-control border border-2 p-2">{{ $trainee->address }}</textarea>
                                                                            <p class='text-danger font-weight-bold inputerror'
                                                                                id="addressError"></p>
                                                                        </div>

                                                                        <p class='text-danger font-weight-bold inputerror' id="attendanceError"></p>
                                                                        <input type="text" class="datepicker-update" name="attendance" value="{{ $trainee->attendance }}" readonly>

                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit"
                                                                    class="btn btn-success btn-update-trainee"
                                                                    data-id="{{ $trainee->id }}">Update Trainee <span
                                                                        id="loader"></span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Confirm Trainee Delete modal -->
                                                <div class="modal fade" id="deleteModal-{{ $trainee->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-sm" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirm</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body" id="smallBody">
                                                                <div class="text-center">
                                                                    <span class="">Are you sure you want to Delete this
                                                                        Trainee?</span>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer align-items-center">
                                                                <button type="button" class="btn btn-success"
                                                                    id="del-btn"
                                                                    data-value="{{ route('delete.trainee', $trainee->id) }}">Confirm</button>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="container text-center m-2 p-5">
                                        <span class="display-6 font-weight-bold">No Trainee Added Yet.</span>
                                    </div>
                                    @endif

                                    {{-- <a class="btn bg-gradient-info btn-floating" id="addBtn" data-bs-toggle="modal" data-bs-target="#newTraineeModal">
                                        <i class="fas fa-plus"></i>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>

    $('.datepicker-update').multiDatesPicker({
        dateFormat: 'dd/mm/yy',
    });


    $(document).on('click', '#del-btn', function(event) {
        event.preventDefault();
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(document).on('click','#open-update',function(){
        var training_id = $(this).data("value");
        var url = '{{route("get.update.training",":id")}}';
        url = url.replace(':id', training_id);
        window.location.assign(url);
    });

    $(document).on('click', '.btn-update-trainee', function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        });

        let id = $(this).data('id');
        let route = '{{route("update.trainee",":id")}}';
        route = route.replace(':id', id);

        const formId = '#updateTraineeForm-'+id;
        let formData = $(formId).serialize();

        console.log(formData);

        $(".inputerror").text("");
        $(formId+" input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-update-trainee").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: route,
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-update-trainee").prop("disabled", false);
                let url = '{{route("update.trainee.success",":id")}}';
                url = url.replace(':id', response.id);
                window.location.assign(url);
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $(".btn-update-trainee").prop("disabled", false);

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

@include('trainee.create', [
    'training' => $training
])
