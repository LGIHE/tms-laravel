<style>
    .btn-close {
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    #newTraineeModalLabel {
        font-family: var(--bs-body-font-family) !important;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="newTraineeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="newTraineeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newTraineeModalLabel">Add New Trainee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method='POST' action='#' id="addTraineeForm">
                    @csrf
                    <input type="hidden" name="training" value="{{ $training->id }}">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="nameError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="emailError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender" aria-label="">
                                <option value="" selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="genderError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="ageError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category" aria-label="">
                                <option value="" selected>Select Category</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Youth">Youth</option>
                                <option value="School Leader">School Leader</option>
                                <option value="Community Leader">Community Leader</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="categoryError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nationality</label>
                            <select class="form-select" name="nationality" aria-label="">
                                <option value="" selected>Select Nationality</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->nationality }}">{{ $country->nationality }}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="nationalityError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="phoneError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control border border-2 p-2"></textarea>
                            <p class='text-danger font-weight-bold inputerror' id="addressError"></p>
                        </div>

                        <input type="text" id="multi-day" name="attendance" readonly>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-submit">Add Trainee <span
                        id="loader"></span></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {

        $('.btn-submit').on('click', function(e) {
            e.preventDefault();

            let formData = $('#addTraineeForm').serializeArray();
            $(".inputerror").text("");
            $("#addTraineeForm input").removeClass("is-invalid");

            $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(".btn-submit").attr("disabled", 'disabled');

            $.ajax({
                method: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: "{{ route('create.trainee') }}",
                data: formData,
                success: (response) => {
                    $(".fa-spinner").remove();
                    $(".btn-submit").prop("disabled", false);
                    let url = '{{ route('create.trainee.success', ':id') }}';
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
    })
</script>
