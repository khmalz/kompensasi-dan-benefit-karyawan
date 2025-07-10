<?php

use App\Enums\BenefitStatus;
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
        Schema::create('benefits', function (Blueprint $table) {
            $table->id();
            $table->ulid('code');
            $table->foreignId('employee_id')->constrained(table: 'employees', indexName: 'benefits_employee_id_foreign')->cascadeOnDelete();
            $table->string('type');
            $table->integer('amount');
            $table->string('status')->default(BenefitStatus::PENDING->value);
            $table->string('message');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefits');
    }
};
