<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TKS Auditor Scheduler</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Top Menu -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">TKS Auditor Scheduler</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Content -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Auditors</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                </tr>
                </thead>
                <tbody id="auditorList"> </tbody>
            </table>
        </div>
    </div>
    <br>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Available Jobs</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="jobList"> </tbody>
            </table>
        </div>
    </div>
    <br>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Complete Jobs</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Auditor</th>
                    <th>Job Description</th>
                    <th>Scheduled Date</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="jobToCompleteList"> </tbody>
            </table>
        </div>
    </div>
    <br>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Completed Schedule</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>Auditor</th>
                    <th>Job Description</th>
                    <th>Date Created</th>
                    <th>Scheduled Date</th>
                    <th>Completed Date</th>
                    <th>Assessments</th>
                </tr>
                </thead>
                <tbody id="completedScheduleList"> </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="assignJobModal" tabindex="-1" aria-labelledby="assignJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignJobModalLabel">Assign Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="auditorId">Auditor</label>
                        <select class="form-control" id="auditorId" name="auditor_id" required> </select>
                    </div>
                    <div class="form-group">
                        <label for="scheduledDate">Scheduled Date</label>
                        <input type="date" class="form-control" id="scheduledDate" name="scheduled_date" required>
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="note" name="note" required></textarea>
                    </div>
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for completing jobs -->
<div class="modal fade" id="completeJobModal" tabindex="-1" aria-labelledby="completeJobModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeJobModalLabel">Complete Job</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="completeJobForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="completeNote">Note</label>
                        <textarea class="form-control" id="completeNote" name="note" required></textarea>
                    </div>
                    <div id="completeErrorMessage" class="alert alert-danger" style="display: none;"></div> <!-- Error message area -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Complete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Fetch auditors and available jobs when the page loads
        fetchAuditors();
        fetchAvailableJobs();
        fetchJobsToComplete();
        fetchCompletedSchedule();
    });

    async function fetchAuditors() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/auditors');
            const auditors = await response.json();
            displayAuditors(auditors.original);
            populateAuditorSelect(auditors.original);
        } catch (error) {
            console.error('Error fetching auditors:', error);
        }
    }

    function populateAuditorSelect(auditors) {
        const auditorSelect = document.getElementById('auditorId');
        auditors.forEach(auditor => {
            const option = document.createElement('option');
            option.value = auditor.id;
            option.textContent = `${auditor.name} (${auditor.id})`;
            auditorSelect.appendChild(option);
        });
    }

    async function assignJob(jobId) {
        try {
            // Clear previous error message
            document.getElementById('errorMessage').style.display = 'none';

            // Get the modal element
            const modal = document.getElementById('assignJobModal');
            // Show the modal
            $(modal).modal('show');
            // Handle form submission
            const form = modal.querySelector('form');
            form.addEventListener('submit', async function (event) {
                event.preventDefault();
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });
                // Send the request to assign the job
                const response = await fetch(`http://127.0.0.1:8000/api/auditors/${jobId}/assign`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Error assigning job:', errorData);

                    // Clear previous error messages
                    document.getElementById('errorMessage').textContent = '';

                    // Iterate over each error and append to errorMessage
                    for (let error in errorData.errors) {
                        document.getElementById('errorMessage').textContent += errorData.errors[error].join(', ') + '\n';
                    }

                    document.getElementById('errorMessage').style.display = 'block';
                } else {
                    const result = await response.json();
                    fetchAuditors();
                    fetchAvailableJobs();
                    fetchJobsToComplete();
                    fetchCompletedSchedule();
                    $(modal).modal('hide');
                }

            });
        } catch (error) {
            console.error('Error assigning job:', error);
        }
    }

    async function fetchAvailableJobs() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/auditors/free_jobs');
            const jobs = await response.json();
            displayJobs(jobs);
        } catch (error) {
            console.error('Error fetching jobs:', error);
        }
    }
    async function  fetchJobsToComplete() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/auditors/jobs_to_complete');
            const jobs = await response.json();
            displayJobsToComplete(jobs);
        } catch (error) {
            console.error('Error fetching jobs:', error);
        }
    }

    async function fetchCompletedSchedule() {
        try {
            const response = await fetch('http://127.0.0.1:8000/api/auditors/completed_schedule');
            const jobs = await response.json();
            displayCompletedSchedule(jobs);
        } catch (error) {
            console.error('Error fetching jobs:', error);
        }
    }

    function displayCompletedSchedule(jobs) {
        const jobListContainer = document.getElementById('completedScheduleList');
        jobListContainer.innerHTML = ''; // Clear previous job list
        jobs.forEach(job => {
            const row = document.createElement('tr');
            const createdDate = new Date(job.created_at);
            const formattedCreatedDate = createdDate.toISOString().split('T')[0]; // Extract yyyy-mm-dd
            const scheduledDate = job.scheduled_date ? job.scheduled_date : 'N/A';
            const completedDate = job.completed_date ? job.completed_date : 'N/A';
            row.innerHTML = `
            <td>${job.auditor.name}</td>
            <td>${job.auditing_job.description}</td>
            <td>${formattedCreatedDate}</td>
            <td>${scheduledDate}</td>
            <td>${completedDate}</td>
            <td>${job.assessment}</td>
        `;
            jobListContainer.appendChild(row);
        });
    }

    function displayAuditors(auditors) {
        const auditorListContainer = document.getElementById('auditorList');
        auditorListContainer.innerHTML = ''; // Clear previous auditor list
        auditors.forEach(auditor => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${auditor.id}</td>
<td>${auditor.name}</td>
<td>${auditor.location}</td>
`;
            auditorListContainer.appendChild(row);
        });
    }

    function displayJobs(jobs) {
        const jobListContainer = document.getElementById('jobList');
        jobs.forEach(job => {
            const row = document.createElement('tr');
            row.innerHTML = `
<td>Job nr ${job.id}</td>
<td>${job.description}</td>
<td><button class="btn btn-primary" onclick="assignJob(${job.id})">Assign</button></td>
`;
            jobListContainer.appendChild(row);
        });
    }
    function displayJobsToComplete(jobs) {
        const jobListContainer = document.getElementById('jobToCompleteList');
        jobListContainer.innerHTML = ''; // Clear previous job list
        jobs.forEach(job => {
            const row = document.createElement('tr');
            const createdDate = new Date(job.created_at);
            const formattedCreatedDate = createdDate.toISOString().split('T')[0]; // Extract yyyy-mm-dd
            row.innerHTML = `
            <td>${job.auditor.name}</td>
            <td>${job.auditing_job.description}</td>
            <td>${job.scheduled_date ? job.scheduled_date : 'N/A'}</td>
            <td>${formattedCreatedDate}</td>
            <td>
                <button class="btn btn-primary" onclick="openCompleteJobModal(${job.auditing_job_id}, ${job.auditor_id})">Complete</button>
            </td>
        `;
            jobListContainer.appendChild(row);
        });
    }


    function openCompleteJobModal(jobId, auditorId) {
        document.getElementById('completeJobForm').setAttribute('data-job-id', jobId);
        document.getElementById('completeJobForm').setAttribute('data-auditor-id', auditorId);

        document.getElementById('completeErrorMessage').style.display = 'none';
        // Show the modal
        $('#completeJobModal').modal('show');
    }

    document.getElementById('completeJobForm').addEventListener('submit', async function (event) {
        event.preventDefault(); // Prevent default form submission
        const jobId = this.getAttribute('data-job-id');
        const auditorId = this.getAttribute('data-auditor-id');
        const note = document.getElementById('completeNote').value;
        await completeJob(jobId, auditorId, note);
    });

    async function completeJob(jobId, auditorId, note) {
        try {
            // Prepare data for the request
            const data = {
                auditor_id: auditorId,
                note: note
            };

            // Send the request to complete the job
            const response = await fetch(`http://127.0.0.1:8000/api/auditors/${jobId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                // Handle error response
                const errorData = await response.json();
                console.error('Error completing job:', errorData);
                document.getElementById('completeErrorMessage').textContent = 'Error completing job';
                document.getElementById('completeErrorMessage').style.display = 'block';
            } else {
                // Job completed successfully
                const result = await response.json();
                console.log('Job completed:', result);
                $('#completeJobModal').modal('hide');
                await fetchAuditors();
                await fetchAvailableJobs();
                await fetchJobsToComplete();
                await fetchCompletedSchedule();
            }
        } catch (error) {
            console.error('Error completing job:', error);
            document.getElementById('completeErrorMessage').textContent = 'Error completing job';
            document.getElementById('completeErrorMessage').style.display = 'block';
        }
    }

</script>
</body>
</html>


