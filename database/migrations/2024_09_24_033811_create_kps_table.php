<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kps', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // your columns here
            $table->string('nama_kps');
            $table->uuid('id_desa');
            $table->foreign('id_desa')->references('id')->on('desa')->onDelete('restrict')->onUpdate('cascade');
            $table->string('no_sk');
            $table->date('tgl_sk');
            $table->integer('luas');
            $table->string('koord_x');
            $table->string('koord_y');
            
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kps');
    }
};
