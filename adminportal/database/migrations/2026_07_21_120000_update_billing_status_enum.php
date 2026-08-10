<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Map existing values to the new domain
        DB::table('pharmacies')->where('billing_status', 'active')->update(['billing_status' => 'paid']);
        DB::table('pharmacies')->where('billing_status', 'overdue')->update(['billing_status' => 'pending']);
        DB::table('pharmacies')->where('billing_status', 'suspended')->update(['billing_status' => 'pending']);

        // Alter enum to the new values (MySQL syntax)
        DB::statement("ALTER TABLE `pharmacies` MODIFY `billing_status` ENUM('paid','pending') NOT NULL DEFAULT 'paid'");
    }

    public function down(): void
    {

        DB::table('pharmacies')->where('billing_status', 'paid')->update(['billing_status' => 'active']);
        DB::table('pharmacies')->where('billing_status', 'pending')->update(['billing_status' => 'overdue']);

        DB::statement("ALTER TABLE `pharmacies` MODIFY `billing_status` ENUM('active','overdue','suspended') NOT NULL DEFAULT 'active'");
    }
};
