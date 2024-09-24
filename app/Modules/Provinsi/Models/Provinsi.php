<?php

namespace App\Modules\Provinsi\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SeksiWilayah\Models\SeksiWilayah;


class Provinsi extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'provinsi';
	protected $fillable   = ['*'];	

	public function seksiWilayah(){
		return $this->belongsTo(SeksiWilayah::class,"id_seksi_wilayah","id");
	}

}
