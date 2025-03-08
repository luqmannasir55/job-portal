<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('personalities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('personalities');
    }
};

