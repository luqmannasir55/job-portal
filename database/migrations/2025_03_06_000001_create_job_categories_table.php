<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted')->nullable();
        });

        DB::statement("ALTER TABLE job_categories ADD FULLTEXT(name)");
        //apply full text index
    }

    public function down() {
        DB::statement("ALTER TABLE job_categories DROP INDEX name");
        Schema::dropIfExists('job_categories');
    }
};

