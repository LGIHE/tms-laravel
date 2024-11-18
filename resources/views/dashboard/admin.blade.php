
<style>
    .dash-block {
        cursor: pointer;
    }
</style>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg mt-3">
        <!-- Navbar -->
        <x-navbars.topbar titlePage=""></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 dash-block">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-secondary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10" style="top:10%;font-size:48px;">school</i>
                            </div>
                            <div class="text-end pt-1">
                                <h5 class="mb-0">Participants</h5>
                                <h4 class="mb-0">{{ count($participants) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-2"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 dash-block"
                    onclick="window.location.href='{{ route('trainings') }}'">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-secondary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10" style="top:10%;font-size:48px;">piano</i>
                            </div>
                            <div class="text-end pt-1">
                                <h5 class="mb-0">Trainings</h5>
                                <h4 class="mb-0">{{ count($trainings) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-2"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 dash-block"
                    onclick="window.location.href='{{ route('users') }}'">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-secondary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10" style="top:10%;font-size:48px;">people</i>
                            </div>
                            <div class="text-end pt-1">
                                <h5 class="mb-0">Facilitators</h5>
                                <h4 class="mb-0">{{ count($facilitators) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-2"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 dash-block"
                    onclick="window.location.href='{{ route('training.venues') }}'">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-secondary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10" style="top:10%;font-size:48px;">groups</i>
                            </div>
                            <div class="text-end pt-1">
                                <h5 class="mb-0">Venuess</h5>
                                <h4 class="mb-0">{{ count($venues) }}</h4>
                            </div>
                        </div>
                        <div class="card-footer p-2"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4" style="margin-left:10px;">
            <div class="col-md-11 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Trainings</h6>
                                <p class="text-sm mb-0">
                                    {{-- <i class="fa fa-check text-info" aria-hidden="true"></i>
                                    <span class="font-weight-bold ms-1">30 done</span> this month --}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0" id="table">
                                <thead>
                                    <tr>
                                        <th class="text-secondary text-xxl font-weight-bolder px-4">Name</th>
                                        <th class="text-secondary text-xxl font-weight-bolder">Description</th>
                                        <th class="text-secondary text-xxl font-weight-bolder">Facilitator</th>
                                        <th class="text-secondary text-xxl font-weight-bolder">Training Venue</th>
                                        <th class="text-secondary text-xxl font-weight-bolder">Project</th>
                                        <th class="text-secondary text-xxl font-weight-bolder">From</th>
                                        <th class="text-secondary text-xxl font-weight-bolder">To</th>
                                        <th class="text-secondary text-xxl font-weight-bolder">Participants</th>
                                        <th class="text-uppercase text-secondary text-s font-weight-bolder">Attendence</th>
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
                                                <p class="text-m text-dark font-weight-bold mb-0">{{
                                                    $training->description }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <span class="text-dark text-m font-weight-bold">
                                                    @foreach ($facilitators as $facilitator)
                                                    @if($facilitator->id == $training->facilitator) {{
                                                    $facilitator->name }} @endif
                                                    @endforeach
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <span class="text-dark text-m font-weight-bold">
                                                    @foreach ($venues as $venue)
                                                    @if($venue->id == $training->training_venue) {{ $venue->name }}
                                                    @endif
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
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <span class="text-dark text-m font-weight-bold">
                                                    {{ App\Http\Controllers\DashboardController::traineesForTraining($training->id) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="progress-wrapper">
                                                <div class="progress-info">
                                                    <div class="progress-percentage">
                                                        <span class="text-xs font-weight-bold">{{ App\Http\Controllers\DashboardController::getAttendanceForTraining($training->id, $training->start_date, $training->end_date) }}%</span>
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-info w-{{ App\Http\Controllers\DashboardController::getValueRound(App\Http\Controllers\DashboardController::getAttendanceForTraining($training->id, $training->start_date, $training->end_date)) }}" role="progressbar"
                                                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle not-export-col">
                                            <a rel="tooltip" class="" id="view-training" data-value="{{ $training->id }}"
                                                style="cursor:pointer;">
                                                <i class="material-icons"
                                                    style="font-size:25px;margin-right:20px;">visibility</i>
                                                <div class="ripple-container"></div>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ["M", "T", "W", "T", "F", "S", "S"],
                    datasets: [{
                        label: "Sales",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "rgba(255, 255, 255, .8)",
                        data: [50, 20, 10, 22, 50, 10, 40],
                        maxBarThickness: 6
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 500,
                                beginAtZero: true,
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                                color: "#fff"
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });


            var ctx2 = document.getElementById("chart-line").getContext("2d");

            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Mobile apps",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [100, 20, 50, 50, 40, 300, 320, 500, 350, 200, 230, 500],
                        maxBarThickness: 6

                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });

            var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

            new Chart(ctx3, {
                type: "line",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Mobile apps",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255, 255, 255, .8)",
                        pointBorderColor: "transparent",
                        borderColor: "rgba(255, 255, 255, .8)",
                        borderWidth: 4,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [100, 20, 50, 50, 40, 300, 220, 500, 250, 400, 230, 500],
                        maxBarThickness: 6

                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                                color: 'rgba(255, 255, 255, .2)'
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: '#f8f9fa',
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: '#f8f9fa',
                                padding: 10,
                                font: {
                                    size: 14,
                                    weight: 300,
                                    family: "Roboto",
                                    style: 'normal',
                                    lineHeight: 2
                                },
                            }
                        },
                    },
                },
            });
    </script>
    @endpush
</x-layout>

<script>
    $(document).on('click','#view-training',function(){
        var training_id = $(this).data("value");
        var url = '{{route("training",":id")}}';
        url = url.replace(':id', training_id);
        window.location.assign(url);
    });
</script>
