
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phone_number_ownerships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('phone_number_id')
                ->constrained('phone_numbers')
                ->restrictOnDelete();

            $table->foreignId('subscriber_id')
                ->constrained('subscribers')
                ->restrictOnDelete();

            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();

            $table->timestamps();

            $table->index(['phone_number_id', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phone_number_ownerships');
    }
};
