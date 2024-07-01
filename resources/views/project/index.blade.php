<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="projects"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.topbar titlePage="Projects"></x-navbars.topbar>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0 end" data-bs-toggle="modal" data-bs-target="#newProjectModal">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Add New Project
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
                        @elseif (session('error'))
                        <div class="row">
                            <div class="col-md-9">
                                <div class="alert alert-danger alert-dismissible text-white fade show" role="alert"style="margin-left:20px;width:90%;">
                                    <span class="text-sm">{{ Session::get('error') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="card-body px-0 pb-2">
                            @if (count($projects) > 0)
                            <div class="table-responsive p-0">
                                <table class="table table-sm hover mb-0" id="table">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xxl font-weight-bolder px-4">Name</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Code</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Short</th>
                                            <th class="text-secondary text-xxl font-weight-bolder">Description</th>
                                            <th class="text-secondary"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $projects as $project)

                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-2">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $project->name }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $project->code }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $project->short }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-m text-dark font-weight-bold mb-0">{{ $project->description }}</p>
                                                </div>
                                            </td>
                                            <td class="not-export-col">
                                                <a rel="tooltip" class="btn btn-link p-0 m-0" role="btn" data-bs-toggle="modal" data-bs-target="#updateProjectModal-{{$project->id}}">
                                                    <i class="material-icons" style="font-size:1.4rem;">edit</i>
                                                    <div class="ripple-container"></div>
                                                </a>

                                                @if (auth()->user()->isRoleSuperAdmin())
                                                    <button type="button" class="btn btn-link p-0 m-0" role="btn" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$project->id}}" title="Delete Project">
                                                        <i class="material-icons" style="font-size:1.4rem;">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="updateProjectModal-{{ $project->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProjectModal" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="updateProjectModalLabel">Update Project</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form method='POST' action='#' id="updateProjectForm-{{ $project->id }}">
                                                            @csrf
                                                            <div class="row">

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Name</label>
                                                                    <input type="text" name="name" class="form-control border border-2 p-2" value="{{ $project->name }}">
                                                                    <p class='text-danger font-weight-bold inputerror' id="nameError-{{ $project->id }}"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Code</label>
                                                                    <input type="text" name="code" class="form-control border border-2 p-2" value="{{ $project->code }}">
                                                                    <p class='text-danger font-weight-bold inputerror' id="codeError-{{ $project->id }}"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Short</label>
                                                                    <input type="text" name="short" class="form-control border border-2 p-2" value="{{ $project->short }}">
                                                                    <p class='text-danger font-weight-bold inputerror' id="shortError-{{ $project->id }}"></p>
                                                                </div>

                                                                <div class="mb-3 col-md-6">
                                                                    <label class="form-label">Description</label>
                                                                    <input type="text" name="description" class="form-control border border-2 p-2" value="{{ $project->description }}">
                                                                    <p class='text-danger font-weight-bold inputerror' id="descriptionError-{{ $project->id }}"></p>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success btn-submit-update" data-id="{{ $project->id }}">Update Project <span id="loader-{{ $project->id }}"></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirm School Delete modal -->
                                        <div class="modal fade" id="deleteModal-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="smallBody">
                                                        <div class="text-center">
                                                            <span class="">Are you sure you want to Delete this Project?</span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer align-items-center">
                                                        <button type="button" class="btn btn-success" id="del-btn" data-value="{{ route('delete.project', $project->id) }}">Confirm</button>
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
                                <span class="display-6 font-weight-bold">No Project Added Yet.</span>
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
    $(document).on('click', '#del-btn', function(event) {
        event.preventDefault();
        let href = $(this).data('value');
        window.location.assign(href);
    });

    $(document).on('click','#open-update',function(){
        var user_id = $(this).data("value");
        var url = '{{route("get.trainee",":id")}}';
        url = url.replace(':id', user_id);
        window.location.assign(url);
    });

    $(document).on('click', '.btn-submit-update', function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        });

        let id = $(this).data('id');
        let route = '{{route("update.project",":id")}}';
        route = route.replace(':id', id);

        let formData = $('#updateProjectForm-' + id).serializeArray();
        $(".inputerror").text("");
        $("#updateProjectForm-" + id + " input").removeClass("is-invalid");

        $("#loader-" + id).prepend('<i class="fa fa-spinner fa-spin"></i>');
        $(".btn-submit-update").attr("disabled", 'disabled');

        $.ajax({
            method: "POST",
            headers: {
                Accept: "application/json"
            },
            url: route,
            data: formData,
            success: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit-update").prop("disabled", false);
                window.location.assign('{{route("update.project.success")}}');
            },
            error: (response) => {
                $(".fa-spinner").remove();
                $(".btn-submit-update").prop("disabled", false);

                if(response.status === 422) {
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $("[name='" + key + "']").addClass("is-invalid");
                        $("#" + key + "Error-" + id).text(errors[key][0]);
                    });
                } else {
                    // window.location.reload();
                }
            }
        })
    });
</script>

@include('project.create')
