<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('fund_watch_disclaimer')) {
            Schema::create('fund_watch_disclaimer', function (Blueprint $table) {
                $table->id();
                $table->text('disclaimer')->nullable();
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        if (! DB::table('fund_watch_disclaimer')->where('status', 1)->exists()) {
            $now = now();

            DB::table('fund_watch_disclaimer')->insert([
                'disclaimer' => 'Data shown is for informational purposes only and should not be treated as investment advice.',
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('fund_watch_disclaimer');
    }
};
