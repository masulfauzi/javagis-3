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
        Schema::create('kups', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // your columns here
            $table->string('nama_kups');
            $table->uuid('id_kps');
            $table->foreign('id_kps')->references('id')->on('kps')->onDelete('restrict')->onUpdate('cascade');
            $table->uuid('id_bentuk_kups');
            $table->foreign('id_bentuk_kups')->references('id')->on('bentuk_kups')->onDelete('restrict')->onUpdate('cascade');
            $table->uuid('id_kelas_kups');
            $table->foreign('id_kelas_kups')->references('id')->on('kelas_kups')->onDelete('restrict')->onUpdate('cascade');
            $table->string('no_sk');
            $table->date('tgl_sk');
            $table->uuid('id_skema_ps');
            $table->foreign('id_skema_ps')->references('id')->on('skema_ps')->onDelete('restrict')->onUpdate('cascade');
            $table->uuid('id_desa');
            $table->foreign('id_desa')->references('id')->on('desa')->onDelete('restrict')->onUpdate('cascade');
            $table->string('koord_x');
            $table->string('koord_y');
            $table->integer('luas');
            $table->integer('tahun_dibentuk');
            
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
        Schema::dropIfExists('kups');
    }
};
