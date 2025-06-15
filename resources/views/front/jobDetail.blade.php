@extends('front.layouts.app')

@section('main')
<section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                @include('front.message')
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{ $job->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i> {{ $job->location }}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i> {{ $job->jobType->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now {{ ($count == 1) ? 'saved-job' : '' }}" aria-label="Save job">
                                    <a class="heart_mark " href="javascript:void(0);" onclick="saveJob({{ $job->id }})" aria-label="Save job"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Job description</h4>
                            {!! nl2br($job->description) !!}
                            
                            
                        </div>
                        @if (!empty($job->responsibility))
                        <div class="single_wrap">
                            <h4>Responsibility</h4>
                            {!! nl2br($job->responsibility) !!}
                        </div>
                        @endif
                        @if (!empty($job->qualifications))
                        <div class="single_wrap">
                            <h4>Qualifications</h4>
                            {!! nl2br($job->qualifications) !!}
                        </div>
                        @endif
                        @if (!empty($job->benefits))
                        <div class="single_wrap">
                            <h4>Benefits</h4>
                            {!! nl2br($job->benefits) !!}
                        </div>
                        @endif
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            
                            @if (Auth::check())
                                <a href="#" onclick="saveJob({{ $job->id }});" class="btn btn-secondary" aria-label="Save job">Save</a>  
                            @else
                                <a href="javascript:void(0);" class="btn btn-secondary disabled">Login to Save</a>
                            @endif

                            @if (Auth::check())
                                @if (Auth::user()->id != $job->user_id)
                                    <a href="#" onclick="applyJob({{ $job->id }})" class="btn btn-primary" aria-label="Apply for job">Apply</a>
                                @else
                                    <span class="btn btn-primary disabled" aria-label="Cannot apply for your own job">You cannot apply for your own job</span>
                                @endif
                            @else
                                <a href="javascript:void(0);" class="btn btn-primary disabled">Login to Apply</a>
                            @endif
                        </div>
                    </div>
                </div>

                @if (Auth::user())
                   @if (Auth::user()->id == $job->user_id)
                    <div class="card shadow border-0 mt-4">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">
                                    <div class="jobs_conetent">                                    
                                        <h4>Applicants</h4>                                    
                                    </div>
                                </div>
                                <div class="jobs_right"></div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            <table class="table table-striped">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Applied Date</th>
                                </tr>
                                @if ($applications->isNotEmpty())
                                    @foreach ($applications as $application)
                                    <tr>
                                        <td>{{ $application->user->name  }}</td>
                                        <td>{{ $application->user->email  }}</td>
                                        <td>{{ $application->user->mobile  }}</td>
                                        <td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}
                                    </td>
                                </tr> 
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3">Applicants not found</td>
                                </tr>
                            @endif
                            
                        </table>
                        
                    </div>
                </div>
                @endif 
                @endif
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summery</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span></li>
                                <li>Number of Vacancies: <span>{{ $job->vacancy }}</span></li>
                                

                                @if (!empty($job->remuneration))
                                <li>Remuneration: <span>{{ $job->remuneration }}</span></li>
                                @endif

                                <li>Location: <span>{{ $job->location }}</span></li>
                                <li>Experience: <span>{{ $job->experience }}</span></li>
                                <li>Job Nature: <span> {{ $job->jobType->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span>{{ $job->company_name }}</span></li>

                                @if (!empty($job->company_location))
                                <li>Locaion: <span>{{ $job->company_location }}</span></li>
                                @endif

                                @if (!empty($job->company_website))
                                <li>Webite: <span><a href="{{ $job->company_website }}">{{ $job->company_website }}</a></span></li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script type="text/javascript">
function applyJob(id){
    if (confirm("Are you sure you want to apply for this job?")) {
        $.ajax({
            url : '{{ route("applyJob") }}',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                // Display success or error message based on response
                if (response.success) {
                            $('#message').html('<div class="alert alert-success alert-dismissible fade show" role="alert">You have successfully applied.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            $('#message').show(); // Ensure the message is visible

                } else if (response.error) {
                            $('#message').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + response.error + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                } else {
                            $('#message').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">You have already applied for this job.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                }
                $('#message').show(); // Ensure the message is visible
                // Optionally, you can hide the message after a few seconds
                setTimeout(function() {
                    $('#message').fadeOut();
                }, 3000);
                // Optionally, you can hide the message after a few seconds
                setTimeout(function() {
                    $('#message').fadeOut();
                }, 3000);
            } 
        });
    }
}

function saveJob(id){
    $.ajax({
        url : '{{ route("saveJob") }}',
        type: 'post',
        data: {id:id},
        dataType: 'json',
        success: function(response) {
            window.location.href = "{{ url()->current() }}";
        } 
    });
}
</script>
@endsection