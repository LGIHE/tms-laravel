<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="reports"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Reports"></x-navbars.topbar>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header pb-0">
                            <h6>Select Report Type</h6>
                        </div>
                        <div class="card-body">
                            <!-- Report Type Selection Dropdown -->
                            <div class="mb-4 col-md-3">
                                <label for="reportType" class="form-label">Choose a report type</label>
                                <select class="form-select p-2" id="reportType">
                                    <option value="" selected disabled>Select Report Type</option>
                                    <option value="project">Project Report</option>
                                    <option value="training">Training Report</option>
                                    <option value="participant">Participant Report</option>
                                </select>
                            </div>

                            <!-- Project Report Template -->
                            <div id="projectReport" class="report-template d-none">
                                @include('reports.partials.project')
                            </div>

                            <!-- Training Report Template -->
                            <div id="trainingReport" class="report-template d-none">
                                @include('reports.partials.training')
                            </div>

                            <!-- Participant Report Template -->
                            <div id="participantReport" class="report-template d-none">
                                @include('reports.partials.participant')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reportTypeSelect = document.getElementById('reportType');
        const projectReport = document.getElementById('projectReport');
        const trainingReport = document.getElementById('trainingReport');
        const participantReport = document.getElementById('participantReport');

        // Listen for changes in the report type dropdown
        reportTypeSelect.addEventListener('change', function () {
            // Hide all report templates
            projectReport.classList.add('d-none');
            trainingReport.classList.add('d-none');
            participantReport.classList.add('d-none');

            // Show the relevant report template based on the selection
            const selectedType = reportTypeSelect.value;
            if (selectedType === 'project') {
                projectReport.classList.remove('d-none');
            } else if (selectedType === 'training') {
                trainingReport.classList.remove('d-none');
            } else if (selectedType === 'participant') {
                participantReport.classList.remove('d-none');
            }
        });
    });
</script>
