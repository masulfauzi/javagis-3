<?php

namespace App\Modules\SeksiWilayah\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\BalaiPskl\Models\BalaiPskl;


class SeksiWilayah extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'seksi_wilayah';
	protected $fillable   = ['*'];	

	public function balaiPskl(){
		return $this->belongsTo(BalaiPskl::class,"id_balai_pskl","id");
	}

}
