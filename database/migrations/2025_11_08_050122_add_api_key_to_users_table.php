<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('api_key', 64)->nullable()->unique()->after('auth_key_hash');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('api_key');
    });
}

};
