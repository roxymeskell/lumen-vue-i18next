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
        Schema::create('i18n', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('locale', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('translation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('i18n_id')->references('id')->on('i18n');
            $table->unsignedBigInteger('locale_id')->references('id')->on('locale');
            $table->foreign('i18n_id')->references('id')->on('i18n');
            $table->foreign('locale_id')->references('id')->on('locale');

            $table->string('content');
            $table->timestamps();
            $table->softDeletes();

            // $table->primary(['i18n_id', 'locale_id']); // Add composite key
            $table->unique(['i18n_id', 'locale_id']);
            $table->index(['i18n_id', 'locale_id']);
        });

        Schema::create('article', function (Blueprint $table) {
            $table->id();
            $table->string('title_i18n_key')->references('key')->on('i18n');
            $table->string('content_i18n_key')->references('key')->on('i18n');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');

        Schema::dropIfExists('i18n');
        Schema::dropIfExists('locale');
        Schema::dropIfExists('translation');
    }
};
