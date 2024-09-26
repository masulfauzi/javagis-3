<?php

namespace App\Modules\Survey\Models;

use App\Helpers\UsesUuid;
use App\Modules\Kps\Models\Kps;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Modules\Kups\Models\Kups;


class Survey extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'survey';
	protected $fillable   = ['*'];	

	public function kps(){
		return $this->belongsTo(Kps::class,"id_kps","id");
	}

}
