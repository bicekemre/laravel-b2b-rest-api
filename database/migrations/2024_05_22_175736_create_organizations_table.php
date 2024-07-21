<?php

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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email');
            $table->integer('tax_number');
            $table->string('tax_office');
            $table->integer('mersis_no');
            $table->string('kep_address')->nullable();
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('zip');
            $table->string('signature_circus');
            $table->string('tax_certificate');
            $table->string('registration_certificate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
