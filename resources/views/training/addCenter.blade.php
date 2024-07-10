<style>
    .btn-close{
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    #newTraineeModalLabel {
        font-family: var(--bs-body-font-family)!important;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="addTrainingCenterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newTrainingCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addTrainingCenterLabel">Add New Training Center</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method='POST' action='#' id="addTrainingCenterForm">
                    @csrf
                    <div class="row">

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="nameError"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Type</label>
                            <select class="form-select border border-2 p-2" name="type" aria-label="">
                                <option value="" selected>Select Type</option>
                                <option value="School">School</option>
                                <option value="Institute">Institute</option>
                                <option value="Farm">Farm</option>
                                <option value="Conference Hall">Conference Hall</option>
                                <option value="Other">Other</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="typeError"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Capacity</label>
                            <input type="text" name="capacity" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="capacityError"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="emailError"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Contact Person</label>
                            <input type="text" name="contact_person" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="contact_personError"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Contact Person Phone</label>
                            <input type="text" name="contact_phone" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="contact_phoneError"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">Country</label>
                            <select class="form-select border border-2 p-2" name="country" aria-label="">
                                <option value="" selected>Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->code }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="countryError"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">District</label>
                            <input type="text" name="district" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="districtError"></p>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="cityError"></p>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" id="submit-center-btn" class="btn btn-success btn-submit">Add Training Center <span id="loader"></span></button>
            </div>
        </div>
    </div>
</div>

<script>

$(function () {

    $('#submit-center-btn').on('click', function (e) {
        e.preventDefault();

        let formData = $('#addTrainingCenterForm').serializeArray();
        $(".inputerror").text("");
        $("#addTrainingCenterForm input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $("#submit-center-btn").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('add.training.center') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $("#submit-center-btn").prop("disabled", false);
                $('#addTrainingCenterModal').modal('hide');
                $('#center-records').append(new Option(response.name, response.id, true, true)).trigger('change');
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $("#submit-center-btn").prop("disabled", false);

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
