<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('type'); // 1 = tools, 2 = qualifications, 3 = career paths
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted')->nullable();
        });
        DB::statement("ALTER TABLE affiliates ADD FULLTEXT(name)");
        //apply full text index
    }

    public function down() {
        DB::statement("ALTER TABLE affiliates DROP INDEX name");
        Schema::dropIfExists('affiliates');
    }
};

