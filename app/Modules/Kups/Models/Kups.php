<?php

namespace App\Modules\Kups\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Kps\Models\Kps;
use App\Modules\BentukKups\Models\BentukKups;
use App\Modules\KelasKups\Models\KelasKups;
use App\Modules\SkemaPs\Models\SkemaPs;
use App\Modules\Desa\Models\Desa;


class Kups extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'kups';
	protected $fillable   = ['*'];	

	public function kps(){
		return $this->belongsTo(Kps::class,"id_kps","id");
	}
public function bentukKups(){
		return $this->belongsTo(BentukKups::class,"id_bentuk_kups","id");
	}
public function kelasKups(){
		return $this->belongsTo(KelasKups::class,"id_kelas_kups","id");
	}
public function skemaPs(){
		return $this->belongsTo(SkemaPs::class,"id_skema_ps","id");
	}
public function desa(){
		return $this->belongsTo(Desa::class,"id_desa","id");
	}

}
