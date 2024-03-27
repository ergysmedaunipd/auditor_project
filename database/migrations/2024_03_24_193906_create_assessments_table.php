<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auditor_id');
            $table->unsignedBigInteger('auditing_job_id');
            $table->date('assessment_date');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('auditor_id')->references('id')->on('auditors')->onDelete('cascade');
            $table->foreign('auditing_job_id')->references('id')->on('auditing_jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
