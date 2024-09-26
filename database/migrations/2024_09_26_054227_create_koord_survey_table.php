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
        Schema::create('koord_survey', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // your columns here
            $table->uuid('id_survey');
            $table->foreign('id_survey')->references('id')->on('survey')->onDelete('restrict')->onUpdate('cascade');
            $table->string('koord_x');
            $table->string('koord_y');
            $table->integer('index');
            $table->string('foto');
            $table->text('ket_lokasi');
            $table->text('ket_objek');
            
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
        Schema::dropIfExists('koord_survey');
    }
};
