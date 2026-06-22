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
    Schema::table('setorans', function (Blueprint $table) {
        $table->decimal('liter_final', 8, 2)->nullable()->after('grade');
    });
}

public function down(): void
{
    Schema::table('setorans', function (Blueprint $table) {
        $table->dropColumn('liter_final');
    });
}
};
