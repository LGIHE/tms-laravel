<div class="card">
    <div class="card-header pb-0">
        <h6>Project Report</h6>
    </div>
    <div class="card-body">
        <p>Filter and generate project-specific reports here.</p>
        <!-- Add your project-specific filters and report generation UI here -->
        <div class="mb-3 col-md-2">
            <label for="projectSelect" class="form-label ">Select Project</label>
            <select class="form-select p-2" id="projectSelect">
                <option value="" selected disabled>Choose a project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
