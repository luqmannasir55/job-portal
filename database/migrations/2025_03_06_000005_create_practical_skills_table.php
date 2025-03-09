<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('practical_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted')->nullable();
        });
        DB::statement("ALTER TABLE practical_skills ADD FULLTEXT(name)");
        //apply full text index
    }

    public function down() {
        DB::statement("ALTER TABLE practical_skills DROP INDEX name");
        Schema::dropIfExists('practical_skills');
    }
};

