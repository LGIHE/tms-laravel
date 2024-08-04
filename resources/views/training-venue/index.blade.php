
<style>

    table.dataTable tbody th, table.dataTable tbody td {
        padding: 8px 0px!important;
    }

    #table td:first-child {
        word-wrap: break-word;
        max-width: 150px;
        padding-left: 10px!important;
    }
</style>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="training-venues"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Training Venues"></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0 end" data-bs-toggle="modal" data-bs-target="#newTrainingVenueModal">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New Training Venue
                            </a>
                        </div>
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
                            @if (count($venues) > 0)
                            <div class="table-responsive p-0">
                                <table class="table table-sm hover mb-0" id="table">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xxl font-weight-bolder px-4">Name</th>
                                            <th class="text-secondary text-xxl font-weight-bolder px-0">Type</th>
                                            <th class="text-secondary text-xxl font-weight-bolder px-0">Capacity</th>
                                            <th class="text-secondary text-xxl font-weight-bolder px-0">Contact Person</th>
                                            <th class="text-secondary text-xxl font-weight-bolder px-0">Contact Phone</th>
                                            <th class="text-secondary text-xxl font-weight-bolder px-0">Email</th>
                                            <th class="text-secondary text-xxl font-weight-bolder px-0">Country</th>
                                            <th class="text-secondary text-xxl font-weight-bolder px-0">Address</th>
                                            <th class="text-secondary"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $venues as $venues )

                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-2">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $venues->name }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-0">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $venues->type }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-dark text-m font-weight-bold">{{ $venues->capacity }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-dark text-m font-weight-bold">{{ $venues->contact_person }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <span class="text-dark text-m font-weight-bold">{{ $venues->contact_phone }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $venues->email }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">
                                                        @foreach ($countries as $country)
                                                            @if ($country->code == $venues->country)
                                                                {{ $country->name }}
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $venues->district }}, {{ $venues->city }}</p>
                                                </div>
                                            </td>
                                            <td class="not-export-col">
                                                <a rel="tooltip" class="btn btn-link p-0 m-0" role="btn" data-bs-toggle="modal" data-bs-target="#updateTrainingVenueFormModal-{{$venues->id}}">
                                                    <i class="material-icons" style="font-size:1.4rem;">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>

                                                @if ($venues->role != 'Administrator')
                                                    <button type="button" class="btn btn-link p-0 m-0" role="btn" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$venues->id}}" title="Delete User">
                                                        <i class="material-icons" style="font-size:1.4rem;">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="updateTrainingVenueFormModal-{{ $venues->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateTraineeModal" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="updateTrainingVenueFormModalLabel">Update Training Venue</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form method='POST' action='#' id="updateTrainingVenueForm">
                                                            @csrf
                                                            <div class="row">

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Name</label>
                                                                    <input type="text" name="name" value="{{ $venues->name }}" class="form-control border border-2 p-2">
                                                                    <p class='text-danger font-weight-bold inputerror' id="nameError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Type</label>
                                                                    <select class="form-select" name="type" aria-label="">
                                                                        <option value="" selected>Select Type</option>
                                                                        <option value="School" {{ $venues->type == "School" ? "selected" : '' }}>School</option>
                                                                        <option value="Institute" {{ $venues->type == "Institute" ? "selected" : '' }}>Institute</option>
                                                                        <option value="Farm" {{ $venues->type == "Farm" ? "selected" : '' }}>Farm</option>
                                                                        <option value="Conference Hall" {{ $venues->type == "Conference Hall" ? "selected" : '' }}>Conference Hall</option>
                                                                    </select>
                                                                    <p class='text-danger font-weight-bold inputerror' id="typeError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Capacity</label>
                                                                    <input type="text" name="capacity" value="{{ $venues->capacity }}" class="form-control border border-2 p-2">
                                                                    <p class='text-danger font-weight-bold inputerror' id="capacityError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Email address</label>
                                                                    <input type="email" name="email" value="{{ $venues->email }}" class="form-control border border-2 p-2">
                                                                    <p class='text-danger font-weight-bold inputerror' id="emailError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Contact Person</label>
                                                                    <input type="text" name="contact_person" value="{{ $venues->contact_person }}" class="form-control border border-2 p-2">
                                                                    <p class='text-danger font-weight-bold inputerror' id="contact_personError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Contact Person Phone</label>
                                                                    <input type="text" name="contact_phone" value="{{ $venues->contact_phone }}" class="form-control border border-2 p-2">
                                                                    <p class='text-danger font-weight-bold inputerror' id="contact_phoneError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Country</label>
                                                                    <select class="form-select" name="country" aria-label="">
                                                                        <option value="" selected>Select Country</option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->code }}" @if ($venues->country == $country->code) {{ 'selected' }} @endif>{{ $country->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <p class='text-danger font-weight-bold inputerror' id="countryError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">District</label>
                                                                    <input type="text" name="district" value="{{ $venues->district }}" class="form-control border border-2 p-2">
                                                                    <p class='text-danger font-weight-bold inputerror' id="districtError"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">City</label>
                                                                    <input type="text" name="city" value="{{ $venues->city }}" class="form-control border border-2 p-2">
                                                                    <p class='text-danger font-weight-bold inputerror' id="cityError"></p>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success btn-submit-update" data-id="{{ $venues->id }}">Update Training Venue <span id="loader"></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirm School Delete modal -->
                                        <div class="modal fade" id="deleteModal-{{ $venues->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="smallBody">
                                                        <div class="text-center">
                                                            <span class="">Are you sure you want to Delete this Training Venue?</span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer align-items-center">
                                                        <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.training.venue', $venues->id) }}">Confirm</button>
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
                                <span class="display-6 font-weight-bold">No Training Venue Added Yet.</span>
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
        let route = '{{route("update.training.venue",":id")}}';
        route = route.replace(':id', id);

        let formData = $('#updateTrainingVenueForm').serializeArray();
        $(".inputerror").text("");
        $("#updateTrainingVenueForm input").removeClass("is-invalid");

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
                let url = '{{route("update.training.venue.success",":id")}}';
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

@include('training-venue.create')
