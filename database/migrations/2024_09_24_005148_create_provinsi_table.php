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
        Schema::create('provinsi', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // your columns here
            $table->uuid('id_seksi_wilayah');
            $table->foreign('id_seksi_wilayah')->references('id')->on('seksi_wilayah')->onUpdate('cascade')->onDelete('restrict');
            $table->string('nama_provinsi');
            $table->integer('kode_provinsi');
            
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
        Schema::dropIfExists('provinsi');
    }
};
