<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('some_identifier')->nullable()->unique();
            $table->string('email');
            $table->string('name');
            $table->timestamps();

            $table->unique(['tenant_id', 'email']);
        });

        Schema::create('groups', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('some_identifier')->nullable()->unique();
            $table->string('name');
            $table->timestamps();

            $table->unique(['tenant_id', 'name']);
        });

        Schema::create('group_person', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('person_id')->constrained();
            $table->unique(['group_id', 'person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_person');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('people');
        Schema::dropIfExists('tenants');
    }
};
