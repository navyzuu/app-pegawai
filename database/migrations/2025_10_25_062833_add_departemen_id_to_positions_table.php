<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->unsignedBigInteger('departemen_id')->nullable()->after('id');
            
            $table->foreign('departemen_id')
                  ->references('id')->on('departments')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign(['departemen_id']);
            $table->dropColumn('departemen_id');
        });
    }
};