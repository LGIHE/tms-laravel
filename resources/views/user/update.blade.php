<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="users"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 pb-5">
        <!-- Navbar -->
        <x-navbars.topbar titlePage='Update User'></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4 mt-5">
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
                                            <h6 class="mb-3">User Information</h6>
                                        </div>
                                    </div>
                                </div>
                                <form method='POST' action="{{ route('update.user', $user->id) }}">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control border border-2 p-2" value='{{ $user->name }}'>
                                            @error('name')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">email</label>
                                            <input type="email" name="email" class="form-control border border-2 p-2" value='{{ $user->email }}'>
                                            @error('email')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control border border-2 p-2" value='{{ $user->phone }}'>
                                            @error('phone')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Location</label>
                                            <input type="text" name="location" class="form-control border border-2 p-2" value='{{ $user->location }}'>
                                            @error('location')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Role</label>
                                            <select class="form-select border border-2 p-2" name="role" aria-label="">
                                                <option vlaue="Select Level" {{ $user->role == "" ? "selected" : '' }}>Select Level</option>
                                                <option value="Administrator" {{ $user->role == "Administrator" ? "selected" : '' }}>Administrator</option>
                                                <option value="Facilitator" {{ $user->role == "Facilitator" ? "selected" : '' }}>Facilitator</option>
                                                <option value="Teacher" {{ $user->role == "Teacher" ? "selected" : '' }}>Teacher</option>
                                            </select>
                                            @error('role')
                                                <p class='text-danger inputerror font-weight-bold'>{{ $message }} </p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Password</label><br>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#updatePasswordModal-{{ $user->id }}" class="btn bg-gradient-info">Change Password</button>

                                        </div>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-dark">Update User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<div class="modal fade" id="updatePasswordModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="smallBody">
                <form method='POST' action="#" id="updatePasswordForm">
                    @csrf
                    <div class="mb-3 col-md-12">
                        <label class="form-label">New Password</label>
                        <input type="text" name="password" class="form-control border border-2 p-2">
                        <p class='text-danger font-weight-bold inputerror' id="passwordError"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer align-items-center">
                <button type="button" class="btn btn-success btn-submit" id="update-pass-btn" data-value="{{ $user->id }}">Confirm <span id="loader"></span></button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(function () {

        $('.btn-submit').on('click', function (e) {
            e.preventDefault();

            let formData = $('#updatePasswordForm').serializeArray();

            let user_id = $(this).data("value");
            let url = '{{route("update.user.password",":id")}}';
            url = url.replace(':id', user_id);

            $(".inputerror").text("");
            $("#updatePasswordForm input").removeClass("is-invalid");
            $("#updatePasswordForm select").removeClass("is-invalid");
            $("#updatePasswordForm textarea").removeClass("is-invalid");

            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(".btn-submit").attr("disabled", 'disabled');

            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: url,
                data: formData,
                success: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-submit").prop("disabled", false);
                    let url = '{{route("update.user.password.success",":id")}}';
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
    })
</script>
