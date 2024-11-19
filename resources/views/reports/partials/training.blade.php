<div class="card">
    <div class="card-header pb-0">
        <h6>Training Report</h6>
    </div>
    <div class="card-body">
        <p>Filter and generate training-specific reports here.</p>
        <!-- Add your training-specific filters and report generation UI here -->
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
</div>
