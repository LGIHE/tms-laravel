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
                                    <table class="table align-items-center mb-0" id="table">
                                        <thead>
                                            <tr>
                                                <th class="text-secondary text-xxl font-weight-bolder px-4">Name</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Description</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Facilitator</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Training Center</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">Project</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">From</th>
                                                <th class="text-secondary text-xxl font-weight-bolder">To</th>
                                                <th class="text-secondary"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($trainings as $training)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center px-2">
                                                        <h6 class="mb-0 text-m">{{ $training->name }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-m text-dark font-weight-bold mb-0">{{ $training->description }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">
                                                            @foreach ($facilitators as $facilitator)
                                                                @if($facilitator->id == $training->facilitator) {{ $facilitator->name }} @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">
                                                            @foreach ($centers as $center)
                                                                @if($center->id == $training->training_center) {{ $center->name }} @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">
                                                            @foreach ($projects as $project)
                                                                @if($project->id == $training->project) {{ $project->name }} @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $training->start_date }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <span class="text-dark text-m font-weight-bold">{{ $training->end_date }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle not-export-col">
                                                    <a rel="tooltip" class="" id="open-training" data-value="{{ $training->id }}" style="cursor:pointer;">
                                                        <i class="material-icons" style="font-size:25px;margin-right:20px;">visibility</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Confirm Training Delete modal -->
                                            <div class="modal fade" id="deleteModal-{{ $training->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="smallBody">
                                                            <div class="text-center">
                                                                <span class="">Are you sure you want to Delete this Training?</span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer align-items-center">
                                                            <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.training', $training->id) }}">Confirm</button>
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

    $(document).on('click','#open-training',function(){
        var training_id = $(this).data("value");
        var url = '{{route("training",":id")}}';
        url = url.replace(':id', training_id);
        window.location.assign(url);
    });

</script>

