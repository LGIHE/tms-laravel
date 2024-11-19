<div class="card">
    <div class="card-header pb-0">
        <h6>Participant Report</h6>
    </div>
    <div class="card-body">
        <p>Filter and generate participant-specific reports here.</p>
        <form method='POST' action="#" id="generateParticipantReport">
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
                    <select class="form-select p-2" id="trainingSelect" name="training">
                        <option value="" selected disabled>Choose a training</option>
                        @foreach($trainings as $training)
                            <option value="{{ $training->id }}">{{ $training->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="participantGender" class="form-label">Select Gender</label>
                    <select class="form-select p-2" id="participantGender" name="gender">
                        <option value="" selected disabled>Choose gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="participantAgeRange" class="form-label">Select Age Range</label>
                    <select class="form-select p-2" id="participantRange" name="age_range">
                        <option value="" selected disabled>Choose age range</option>
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
                        <option value="" selected disabled>Choose category</option>
                        <option value="Community Leader">Community Leader</option>
                        <option value="Public Worker">Public Worker</option>
                        <option value="School Leader">School Leader</option>
                        <option value="Student">Student</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Youth">Youth</option>
                        <option value="Graduates from other institutions">Graduates from other institutions</option>
                        <option value="Non-SKY-supported youth from the comunities">Non-SKY-supported youth from the comunities</option>
                    </select>
                </div>
                <div class="mb-3 col-md-2 pt-">
                    <button type="submit" class="btn btn-success" style="margin-top: 2rem;">Generate Report</button>
                </div>
            </div>
        </form>
    </div>
</div>
