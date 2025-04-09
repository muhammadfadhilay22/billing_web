<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tb_nomorhp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_costumer')->constrained('tb_costumer')->onDelete('cascade');
            $table->string('nohp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_nomorhp');
    }
};
