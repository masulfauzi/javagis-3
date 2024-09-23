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
        Schema::create('seksi_wilayah', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // your columns here
            $table->string('id_balai_pskl');
            $table->foreign('id_balai_pskl')->references('id')->on('balai_pskl')->onUpdate('cascade')->onDelete('restrict');
            $table->string('nama_seksi_wilayah');
            
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
        Schema::table('seksi_wilayah', function (Blueprint $table) {
            $table->dropForeign('seksi_wilayah_id_balai_pskl_foreign');
        });

        Schema::dropIfExists('seksi_wilayah');
    }
};
