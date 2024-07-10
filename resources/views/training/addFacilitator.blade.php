<style>
    .btn-close{
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    #newFacilitatorModalLabel {
        font-family: var(--bs-body-font-family)!important;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="addFacilitatorModal" tabindex="-1" aria-labelledby="addFacilitatorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="newFacilitatorModalLabel">Add Facilitator</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method='POST' action='#' id="addFacilitatorForm">
                    @csrf
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
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="phoneError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="locationError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Role</label>
                            <select class="form-select border border-2 p-2" name="role" aria-label="">
                                <option value="Facilitator" selected>Facilitator</option>
                            </select>
                            <p class='text-danger font-weight-bold inputerror' id="roleError"></p>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control border border-2 p-2">
                            <p class='text-danger font-weight-bold inputerror' id="passwordError"></p>
                        </div>


                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" id="submit-facilitator-btn" class="btn btn-success btn-submit">Add Facilitator <span id="loader"></span></button>
            </div>
        </div>
    </div>
</div>

<script>

// Add Facilitator Form Submission
$('#submit-facilitator-btn').on('click', function(e) {
        e.preventDefault();

        let formData = $('#addFacilitatorForm').serializeArray();
        $(".inputerror").text("");
        $("#addFacilitatorForm input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $("#submit-facilitator-btn").attr("disabled", 'disabled');
        // let formData = $(this).serialize();

        $.ajax({
            method: "POST",
            headers: { Accept: "application/json" },
            url: "{{ route('add.facilitator') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $("#submit-facilitator-btn").prop("disabled", false);
                $('#addFacilitatorModal').modal('hide');
                $('#facilitator-records').append(new Option(response.name, response.id, true, true)).trigger('change');
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $("#submit-facilitator-btn").prop("disabled", false);

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
        });
    });

</script>
