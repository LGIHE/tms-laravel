<div class="card">
    <div class="card-header pb-0">
        <h6>Participant Report</h6>
    </div>
    <div class="card-body">
        <p>Filter and generate participant-specific reports here.</p>
        <form method='POST' action="#" id="getParticipantsForm">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-2">
                    <label for="projectSelect" class="form-label">Select Project</label>
                    <select class="form-select p-2" id="projectSelect" name="project">
                        <option value="" selected>Choose a project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="trainingSelect" class="form-label">Select Training</label>
                    <select class="form-select p-2" id="trainingSelect" name="training">
                        <option value="" selected>Choose a training</option>
                        @foreach($trainings as $training)
                            <option value="{{ $training->id }}">{{ $training->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="participantGender" class="form-label">Select Gender</label>
                    <select class="form-select p-2" id="participantGender" name="gender">
                        <option value="" selected>Choose gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="participantAgeRange" class="form-label">Select Age Range</label>
                    <select class="form-select p-2" id="participantRange" name="age_range">
                        <option value="" selected>Choose age range</option>
                        <option value="20">15 - 20</option>
                        <option value="25">21 - 25</option>
                        <option value="30">26 - 30</option>
                        <option value="35">31 - 35</option>
                        <option value="40">35 - 40</option>
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="participantCategory" class="form-label">Select Category</label>
                    <select class="form-select p-2" id="participantCategory" name="category">
                        <option value="" selected>Choose category</option>
                        <option value="Community Leader">Community Leader</option>
                        <option value="Public Worker">Public Worker</option>
                        <option value="School Leader">School Leader</option>
                        <option value="Student">Student</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Youth">Youth</option>
                        <option value="Graduates from other institutions">Graduates from other institutions</option>
                        <option value="Non-SKY-supported youth from the communities">Non-SKY-supported youth from the communities</option>
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <button type="submit" class="btn btn-success btn-submit" style="margin-top: 2rem;">Generate Report <span id="loader"></span></button>
                </div>
            </div>
        </form>

        <!-- Placeholder for the participants table -->
        {{-- <div id="participantsTable"></div> --}}
        <div class="tab-content mt-2">
            <div class="tab-pane fade show active" id="steps-tab" role="tabpanel" aria-labelledby="steps-tab">
                <div class="card-body px-0 pb-2">
                    @if (!$participants->isEmpty())
                    <div class="table-responsive p-0">
                        <table id="participantsTable" class="table table-sm hover mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary text-xxl font-weight-bolder px-4">ID No.</th>
                                    <th class="text-secondary text-xxl font-weight-bolder px-4">Name</th>
                                    <th class="text-secondary text-xxl font-weight-bolder">Gender</th>
                                    <th class="text-secondary text-xxl font-weight-bolder">Age</th>
                                    <th class="text-secondary text-xxl font-weight-bolder">Category</th>
                                    <th class="text-secondary text-xxl font-weight-bolder">Institution</th>
                                    <th class="text-secondary text-xxl font-weight-bolder">Phone</th>
                                    <th class="text-secondary text-xxl font-weight-bolder">District</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    @else
                    <div class="container text-center m-2 p-5">
                        <span class="display-6 font-weight-bold">No Participants Available</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // Handle form submission to reload DataTable with filters
        $('.btn-submit').click(function(e) {
                e.preventDefault();

                $('#participantsTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "method": "POST",
                        "url": "{{ route('participants.data') }}",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        "data": function (d) {
                            // Add form filters to the AJAX request data
                            d.project = $('#projectSelect').val();
                            d.training = $('#trainingSelect').val();
                            d.gender = $('#participantGender').val();
                            d.age_range = $('#participantRange').val();
                            d.category = $('#participantCategory').val();
                        }
                    },
                    "pageLength": 10,
                    "lengthMenu": [10, 25, 50, 100],
                    "paging": true,
                    "dom": 'lBfrtip',
                    "buttons": [
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
                        'print'
                    ],
                    "columns": [
                        { "data": "id_no" },
                        { "data": "name" },
                        { "data": "gender" },
                        { "data": "age" },
                        { "data": "category" },
                        { "data": "institution" },
                        { "data": "phone" },
                        { "data": "district" },
                    ],
                    "language": {
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        },
                        "lengthMenu": "Show _MENU_ entries",
                        "loadingRecords": "Loading participants...",
                        "zeroRecords": "No participants found",
                        "emptyTable": "No participants available"
                    },
                    "createdRow": function(row, data, dataIndex) {
                        // Add the text-dark class to all <td> elements in the row
                        $('td', row).addClass('text-dark');
                    }
                });
        });
    });
</script>
