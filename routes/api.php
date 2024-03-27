<?php

use App\Http\Controllers\Auditing\AuditorController;
use App\Http\Controllers\Scheduling\AvailableJobsController;
use App\Http\Controllers\Scheduling\CompletedJobsController;
use App\Http\Controllers\Scheduling\JobAssignmentController;
use App\Http\Controllers\Scheduling\JobCompletionController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description"
 * )
 *
 */
Route::prefix('/auditors')->group(function () {
    Route::get('/', [AuditorController::class, 'index'])->name('auditors.index');
    Route::get('/free_jobs', [AvailableJobsController::class, 'index'])->name('auditors.jobs.free');
    Route::post('/{jobId}/assign', [JobAssignmentController::class, 'store'])->name('auditors.jobs.store');
    Route::get('/jobs_to_complete', [JobCompletionController::class, 'index'])->name('auditors.jobs.index');
    Route::post('/{jobId}/complete', [JobCompletionController::class, 'update'])->name('auditors.jobs.update');

    Route::get('/completed_schedule', [CompletedJobsController::class, 'index'])->name('auditors.jobs.completed');
});
