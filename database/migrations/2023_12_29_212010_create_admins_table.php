<?php

declare(strict_types=1);

use App\Enums\EnumTitles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('admins', static function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->string('title')->default(EnumTitles::MR);
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('name')->virtualAs("CONCAT(first_name,' ',last_name)");
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_super_admin')->default(false);

            $table->string('password');

            $table->softDeletes();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
