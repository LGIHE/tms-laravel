<style>
    #trainingsTable_info {
        padding-left: 25px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #007bff49!important;
    }
</style>

<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="trainings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Trainings"></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{ route('get.create.training') }}" style="margin-right: 15px;">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add Training
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
                        @endif
                        <div class="card-body px-0 pb-2">
                            @if (count($trainings) > 0)
                            <div class="table-responsive p-0">
                                <table id="trainingsTable" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xxl font-weight-bolder px-4">Name</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Description</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Facilitator(s)</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Training Venue</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Project</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">From</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">To</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trainings as $training)
                                            <tr>
                                                <td class="ellipsis text-dark">
                                                    <div class="d-flex flex-column justify-content-center px-3">{{ $training->name }}</div>
                                                </td>
                                                <td class="ellipsis text-dark">{{ $training->description }}</td>
                                                <td class="ellipsis text-dark">
                                                    @php
                                                        $facilitatorIds = json_decode($training->facilitators, true);
                                                        $facilitatorNames = [];
                                                    @endphp
                                                    @foreach ($facilitators as $facilitator)
                                                        @if (in_array((string) $facilitator->id, $facilitatorIds))
                                                            @php $facilitatorNames[] = $facilitator->name; @endphp
                                                        @endif
                                                    @endforeach
                                                    {{ !empty($facilitatorNames) ? implode(', ', $facilitatorNames) : 'No facilitators found' }}
                                                </td>
                                                <td class="ellipsis text-dark">
                                                    @php
                                                        $venueIds = json_decode($training->training_venue, true);
                                                        $venueNames = [];
                                                    @endphp
                                                    @foreach ($venues as $venue)
                                                        @if (in_array((string) $venue->id, $venueIds))
                                                            @php $venueNames[] = $venue->name; @endphp
                                                        @endif
                                                    @endforeach
                                                    {{ !empty($venueNames) ? implode(', ', $venueNames) : 'No venues found' }}
                                                </td>
                                                <td class="text-dark">
                                                    @foreach ($projects as $project)
                                                        @if ($project->id == $training->project)
                                                            {{ $project->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="text-dark">{{ $training->start_date }}</td>
                                                <td class="text-dark">{{ $training->end_date }}</td>
                                                <td>
                                                    <a rel="tooltip" class="btn btn-link p-0 m-0" id="open-training" data-value="{{ $training->id }}" style="cursor:pointer;">
                                                        <i class="material-icons" style="font-size:25px;">visibility</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @else
                                <div class="container text-center m-2 p-5">
                                    <span class="display-6 font-weight-bold">No Trainings Added Yet.</span>
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
    $(document).ready(function() {
        $('#trainingsTable').DataTable({
            "processing": true,
            "pageLength": 10,  // Default number of rows per page
            "lengthMenu": [10, 25, 50, 100],  // Dropdown options for number of rows
            "lengthChange": true,  // Enable the length menu dropdown
            "paging": true,  // Enable pagination
            "dom": 'lBfrtip',  // Include length menu (l), buttons (B), filter (f), table (t), info (i), and pagination (p)
            "buttons": [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'print'
            ],
            "language": {
                "lengthMenu": "Show _MENU_ entries",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                "loadingRecords": "Loading trainings...",
                "zeroRecords": "No trainings found",
                "emptyTable": "No trainings available"
            }
        });
    });

    $(document).on('click','#open-training',function(){
        var training_id = $(this).data("value");
        var url = '{{route("training",":id")}}';
        url = url.replace(':id', training_id);
        window.location.assign(url);
    });

</script>

