<style>
    a.nav-link,
    a.nav-link:hover {
        color: black;
    }

    .btn-close {
        color: #000;
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    }

    #updateParticipantModalLabel {
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

    .select2-container--default .select2-selection--single {
        padding: 5px;
        border: 1px solid #d2d6da !important;
    }

    .select2-container .select2-selection--single {
        height: 42px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #7b809a !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
    }

    span.select2-container--default {
        width: 100% !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #007bff49!important;
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
                                    <p class="text-dark font-weight-bold">Facilitator(s):</p>&nbsp;
                                    <p class="text-dark">
                                        @php
                                            $facilitatorIds = json_decode($training->facilitators, true);
                                            $facilitatorNames = [];
                                        @endphp

                                        @foreach ($facilitators as $facilitator)
                                            @if(in_array((string) $facilitator->id, $facilitatorIds))
                                                @php
                                                    $facilitatorNames[] = $facilitator->name;
                                                @endphp
                                            @endif
                                        @endforeach

                                        @if (!empty($facilitatorNames))
                                            {{ implode(', ', $facilitatorNames) }}
                                        @else
                                            <em>No facilitators found</em>
                                        @endif
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
                                    <p class="text-dark font-weight-bold">Training Venue:</p>&nbsp;
                                    <p class="text-dark">
                                        @php
                                            $trainingVenueIds = json_decode($training->training_venue, true);
                                            $trainingVenueNames = [];
                                        @endphp

                                        @foreach ($venues as $venue)
                                            @if(in_array((string) $venue->id, $trainingVenueIds))
                                                @php
                                                    $trainingVenueNames[] = $venue->name;
                                                @endphp
                                            @endif
                                        @endforeach

                                        @if (!empty($trainingVenueNames))
                                            {{ implode(', ', $trainingVenueNames) }}
                                        @else
                                            <em>No training venue found</em>
                                        @endif
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
                                    <p class="text-dark font-weight-bold">District/Country:</p>&nbsp;
                                    <p class="text-dark">
                                        @php
                                            $trainingVenueDistricts = [];
                                        @endphp

                                        @foreach ($venues as $venue)
                                            @if(in_array((string) $venue->id, $trainingVenueIds))
                                                @php
                                                    // Combine district and country into one string
                                                    $districtEntry = $venue->district . ',' . $venue->country;
                                                    // Only add unique entries
                                                    if (!in_array($districtEntry, $trainingVenueDistricts)) {
                                                        $trainingVenueDistricts[] = $districtEntry;
                                                    }
                                                @endphp
                                            @endif
                                        @endforeach

                                        @if (!empty($trainingVenueDistricts))
                                            {{ implode(' - ', $trainingVenueDistricts) }}
                                        @else
                                            <em>No training venue address found</em>
                                        @endif
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="me-3 my-3 text-end">
                                <a class="btn bg-gradient-success mb-0 end" data-bs-toggle="modal" data-bs-target="#newParticipantModal">
                                    <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Participant
                                </a>
                                <a class="btn bg-gradient-primary mb-0 end" id="upload-btn" data-value="{{ route('get.upload.participants', $training->id) }}">
                                    <i class="material-icons text-sm">upload</i>&nbsp;&nbsp;Upload Participants
                                </a>
                            </div>
                        </div>

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#steps-tab">Participants</a>
                            </li>
                        </ul>

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
                                                    <th class="text-secondary text-xxl font-weight-bolder">Days Attended</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                    @else
                                    <div class="container text-center m-2 p-5">
                                        <span class="display-6 font-weight-bold">No Participant Added Yet.</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

@php
    // Convert the start and end dates to DateTime objects
    $startDate = new \DateTime($training->start_date);
    $endDate = new \DateTime($training->end_date);

    // Create an array to hold all dates between start and end date
    $trainingDates = [];

    // Loop through each day between start and end date
    while ($startDate <= $endDate) {
        $trainingDates[] = $startDate->format('Y-m-d');
        $startDate->modify('+1 day');
    }
@endphp

<script>
    $(document).ready(function() {
        $('#participantsTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('training.participants.data', $training->id) }}",
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
                { "data": "days_attended" },
                { "data": "actions", "orderable": false, "searchable": false }
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
            }
        });
    });

    $(document).ready(function(){
        $('.subjects-select').each(function() {
            $(this).select2();
        });
    });

    $('#datepicker-update').multiDatesPicker({
        dateFormat: 'dd/mm/yy',
    });

    $(document).on('click', '#remove-btn', function(event) {
        event.preventDefault();
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(document).on('click', '#upload-btn', function(event) {
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
</script>

@include('participant.training.create', [
    'training' => $training
])
