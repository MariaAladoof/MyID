
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phone_number_ownerships', function (Blueprint $table) {
            $table->unsignedBigInteger('current_phone_number_id')
                ->nullable()
                ->virtualAs(
                    'CASE WHEN ended_at IS NULL THEN phone_number_id ELSE NULL END'
                );

            $table->unique(
                'current_phone_number_id',
                'phone_ownership_current_phone_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('phone_number_ownerships', function (Blueprint $table) {
            $table->dropUnique('phone_ownership_current_phone_unique');
            $table->dropColumn('current_phone_number_id');
        });
    }
};
