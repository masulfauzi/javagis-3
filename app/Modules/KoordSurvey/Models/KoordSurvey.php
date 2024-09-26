<?php

namespace App\Modules\KoordSurvey\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Survey\Models\Survey;


class KoordSurvey extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $casts      = ['deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
	protected $table      = 'koord_survey';
	protected $fillable   = ['*'];	

	public function survey(){
		return $this->belongsTo(Survey::class,"id_survey","id");
	}

}
