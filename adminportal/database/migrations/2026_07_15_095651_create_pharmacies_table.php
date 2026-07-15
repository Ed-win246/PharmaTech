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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_number');
            $table->string('address');
            $table->string('owner_name');
            $table->string('owner_email')->unique();
            $table->string('owner_phone');
            $table->enum('status',['active','suspended'])->default('active');

            $table->enum('billing_cycle',['monthly','yearly'])->default('monthly');
            $table->decimal('subscription_fee',10,2)->default(0);
            $table->date('billing_date')->nullable();
            $table->date('next_billing_date')->nullable();
            $table->enum('billing_status',['active','overdue','suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
