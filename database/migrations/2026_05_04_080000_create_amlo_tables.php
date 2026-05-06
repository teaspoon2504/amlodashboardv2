<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regional_offices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('branch_offices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->foreignId('regional_office_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('officers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('branch_office_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('team_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('regional_office_id')->unique()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('task_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regional_office_id')->constrained()->cascadeOnDelete();
            $table->foreignId('task_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_lead_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('officer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('branch_office_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('progress', ['done', 'in_progress', 'not_started'])->default('not_started');
            $table->integer('target')->default(0);
            $table->integer('amount_done')->default(0);
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_categories');
        Schema::dropIfExists('team_leads');
        Schema::dropIfExists('officers');
        Schema::dropIfExists('branch_offices');
        Schema::dropIfExists('regional_offices');
    }
};