<?php

use App\Enums\AuditingJobs\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auditing_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('status', Status::getStatuses())->default(Status::SCHEDULED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditing_jobs');
    }
};
