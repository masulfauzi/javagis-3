<?php

namespace App\Modules\Survey\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Kups\Models\Kups;


class Survey extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'survey';
	protected $fillable   = ['*'];	

	public function kups(){
		return $this->belongsTo(Kups::class,"id_kups","id");
	}

}
