<?php

namespace App\Modules\Kps\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Desa\Models\Desa;


class Kps extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'kps';
	protected $fillable   = ['*'];	

	public function desa(){
		return $this->belongsTo(Desa::class,"id_desa","id");
	}

}
