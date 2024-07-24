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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("trx_id");

            $table->string("first_name");
            $table->string("last_name");
            $table->string("email");
            $table->string("phone")->nullable();

            // card info
            $table->string("card_number");
            $table->string("cvc");
            $table->string("expiry");

            $table->decimal("total", 10, 2);
            $table->float("tax")->nullable();

            $table->decimal("grand_total", 10, 2);

            $table->foreignIdFor(Package::class);
            $table->foreignIdFor(User::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
