<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="trainees"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Trainees"></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        {{-- <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0 end" data-bs-toggle="modal" data-bs-target="#newTraineeModal">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New Trainee
                            </a>
                        </div> --}}
                        @if (session('status'))
                        <div class="row">
                            <div class="col-md-9">
                                <div class="alert alert-success alert-dismissible text-white fade show" role="alert"style="margin-left:20px;width:90%;">
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
                                <div class="alert alert-danger alert-dismissible text-white fade show" role="alert"style="margin-left:20px;width:90%;">
                                    <span class="text-sm">{{ Session::get('error') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="card-body px-0 pb-2">
                            @if (count($trainees) > 0)
                            <div class="table-responsive p-0">
                                <table class="table table-sm hover mb-0" id="table">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xxl font-weight-bolder px-4">Name</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Gender</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Age</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Contact</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Address</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Email</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Training</th>
                                            <th class="text-secondary"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $trainees as $trainee )

                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-2">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $trainee->name }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $trainee->gender }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-dark text-m font-weight-bold">{{ $trainee->age }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-dark text-m font-weight-bold">{{ $trainee->phone }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-dark text-m font-weight-bold">{{ $trainee->address }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $trainee->email }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">
                                                        @foreach ($trainings as $training)
                                                            @if ($training->id == $trainee->training)
                                                                {{ $training->name }}
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="not-export-col">
                                                <a rel="tooltip" class="btn btn-link p-0 m-0" role="btn" data-bs-toggle="modal" data-bs-target="#updateTraineeModal-{{$trainee->id}}">
                                                    <i class="material-icons" style="font-size:1.4rem;">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>

                                                @if ($trainee->role != 'Administrator')
                                                    <button type="button" class="btn btn-link p-0 m-0" role="btn" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$trainee->id}}" title="Delete User">
                                                        <i class="material-icons" style="font-size:1.4rem;">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="updateTraineeModal-{{ $trainee->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateTraineeModal" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="updateTraineeModalLabel">Add New Trainee</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form method='POST' action='#' id="updateTraineeForm">
                                                            @csrf
                                                            <div class="row">

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Name</label>
                                                                    <input type="text" name="name" class="form-control border border-2 p-2" value="{{ $trainee->name }}">
                                                                    <p class='text-danger font-weight-bold inputerror' id="nameError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Email address</label>
                                                                    <input type="email" name="email" class="form-control border border-2 p-2" value="{{ $trainee->email }}">
                                                                    <p class='text-danger font-weight-bold inputerror' id="emailError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Gender</label>
                                                                    <select class="form-select border border-2 p-2" name="gender" aria-label="">
                                                                        <option value="" selected>Select Gender</option>
                                                                        <option value="Male" {{ $trainee->gender == "Male" ? "selected" : '' }}>Male</option>
                                                                        <option value="Female" {{ $trainee->gender == "Female" ? "selected" : '' }}>Female</option>
                                                                    </select>
                                                                    <p class='text-danger font-weight-bold inputerror' id="genderError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Age</label>
                                                                    <input type="number" name="age" class="form-control border border-2 p-2" value="{{ $trainee->age }}">
                                                                    <p class='text-danger font-weight-bold inputerror' id="ageError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Phone</label>
                                                                    <input type="text" name="phone" class="form-control border border-2 p-2" value="{{ $trainee->phone }}">
                                                                    <p class='text-danger font-weight-bold inputerror' id="phoneError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Address</label>
                                                                    <textarea name="address" class="form-control border border-2 p-2">{{ $trainee->address }}</textarea>
                                                                    <p class='text-danger font-weight-bold inputerror' id="addressError"></p>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success btn-submit-update" data-id="{{ $trainee->id }}">Update Trainee <span id="loader"></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirm School Delete modal -->
                                        <div class="modal fade" id="deleteModal-{{ $trainee->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="smallBody">
                                                        <div class="text-center">
                                                            <span class="">Are you sure you want to Delete this Trainee?</span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer align-items-center">
                                                        <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.trainee', $trainee->id) }}">Confirm</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
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
        // console.log(href);
        window.location.assign(href);
    });

    $(document).on('click','#open-update',function(){
        var user_id = $(this).data("value");
        var url = '{{route("get.trainee",":id")}}';
        url = url.replace(':id', user_id);
        window.location.assign(url);
    });

    $(document).on('click', '.btn-submit-update', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let route = '{{route("update.trainee",":id")}}';
        route = route.replace(':id', id);

        let formData = $('#updateTraineeForm').serializeArray();
        $(".inputerror").text("");
        $("#updateTraineeForm input").removeClass("is-invalid");

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
                let url = '{{route("update.trainee.success",":id")}}';
                url = url.replace(':id', response.id);
                window.location.assign(url);
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
</script>

@include('trainee.create', [
    'training' => $trainee->training
])
