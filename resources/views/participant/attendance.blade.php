<div class="modal fade" id="updateAttendanceModal" tabindex="-1" aria-labelledby="updateTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAttendanceModalLabel">Update Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="#" id="updateAttendanceForm">
                    @csrf
                    <input type="hidden" id="participantId" name="participant_id">
                    <input type="hidden" id="trainingId" name="training_id">
                    <div class="mb-3 col-md-9">
                        <label class="form-label">Days Attended</label>
                        <input type="text" id="datepicker" name="attended_dates" class="form-control border border-2 p-2" readonly>
                        <p class='text-danger font-weight-bold inputerror' id="attended_datesError"></p>
                    </div>
                    <button type="submit" class="btn btn-primary btn-submit-attendance">Save changes <span id="loader"></span></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    $('#datepicker').multiDatesPicker({
        dateFormat: 'dd/mm/yy',
    });

    // Handle the status-link click
    $('.status-link').on('click', function(event) {
        event.preventDefault();
        var participantId = $(this).data('participant-id');
        var trainingId = $(this).data('training-id');
        $('#participantId').val(participantId);
        $('#trainingId').val(trainingId);
        $('#updateAttendanceModal').modal('show');
    });

    // Handle form submission
    $('#updateAttendanceForm').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serializeArray();
        $(".inputerror").text("");
        $("input").removeClass("is-invalid");

        $("#loader").prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit-attendance").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: "{{ route('update.participant.attendance') }}",
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit-attendance").prop("disabled", false);
                let url = '{{ route('participants') }}';
                window.location.assign(url);
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit-attendance").prop("disabled", false);

                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function(key) {
                        $("[name='" + key + "']").addClass("is-invalid");
                        $("#" + key + "Error").text(errors[key][0]);
                    });
                } else {
                    alert("An unexpected error occurred. Please try again.");
                }
            }
        });
    });
});
</script>
