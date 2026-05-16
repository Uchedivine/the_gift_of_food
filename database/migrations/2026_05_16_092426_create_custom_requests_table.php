<?php

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
        Schema::create('custom_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('request_details');
            $table->string('occasion')->nullable();
            $table->string('quantity_estimate')->nullable();
            $table->string('budget')->nullable();
            $table->date('preferred_date')->nullable();
            $table->string('status')->default('pending');
            $table->text('admin_note')->nullable();
            $table->decimal('quoted_amount', 10, 2)->nullable();
            $table->text('admin_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_requests');
    }
};
