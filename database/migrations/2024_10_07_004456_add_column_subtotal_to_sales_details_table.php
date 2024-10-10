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
        Schema::table('sales_details', function (Blueprint $table) {
            //            
            $table->decimal('subtotal')->after('taxrate')->default(0);
            $table->decimal('total')->after('subtotal')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_details', function (Blueprint $table) {
            //
            $table->dropColumn('subtotal');
            $table->dropColumn('total');
        });
    }
};
