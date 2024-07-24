<?php

use App\Models\Package;
use App\Models\User;
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
        Schema::create('package_expirations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(Package::class);

            $table->foreignIdFor(User::class);

            $table->boolean("is_expired")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_expirations');
    }
};
