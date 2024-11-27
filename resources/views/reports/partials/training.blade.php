<style>

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
</style>
<div class="card">
    <div class="card-header pb-0">
        <h6>Training Report</h6>
    </div>
    <div class="card-body">
        <p>Filter and generate training-specific reports here.</p>
        <form action="#" method="post">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-2">
                    <label for="projectSelect" class="form-label ">Select Project</label>
                    <select class="form-select p-2" id="projectSelect" name="project">
                        <option value="" selected disabled>Choose a project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="trainingSelect" class="form-label">Select Training</label>
                    <select class="form-select p-2" id="trainingSelect">
                        <option value="" selected disabled>Choose a training</option>
                        @foreach($trainings as $training)
                            <option value="{{ $training->id }}">{{ $training->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#projectSelect').select2();
        $('#trainingSelect').select2();
    });
</script>
