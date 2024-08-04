<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("slug")->default(Str::uuid());

            $table->string('title');
            $table->string('sub_title');
            $table->decimal('price', 10, 2);
            $table->float('discount')->nullable();

            $table->json('features')->nullable();

            $table->integer("duration")->nullable();

            $table->string('duration_title')->nullable();

            // status 
            $table->enum('status', [
                'Active', 'Deactive'
            ])->default('Active')->nullable();

            // need to generate QR after purchasing
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
