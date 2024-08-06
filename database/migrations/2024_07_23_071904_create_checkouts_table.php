<?php

use App\Models\Package;
use App\Models\User;
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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("trx_id")->default(Str::uuid()->toString());

            $table->string("first_name");
            $table->string("last_name");
            $table->string("email");
            $table->string("phone")->nullable();

            $table->decimal("total", 10, 2)->nullable();
            $table->float("tax")->nullable();

            $table->decimal("grand_total", 10, 2)->nullable();

            $table->foreignIdFor(Package::class);
            $table->foreignIdFor(User::class);

            $table->enum("status", [
                "Cancelled", "Success", "Returned", "Pending"
            ])->default("Pending");

            $table->enum('payment_status', [
                'Paid', 'Unpaid'
            ])->nullable();

            // invoice
            $table->integer('invoice')
                ->nullable();

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
