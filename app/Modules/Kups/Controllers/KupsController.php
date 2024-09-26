<?php
namespace App\Modules\Kups\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kups\Models\Kups;
use App\Modules\Kps\Models\Kps;
use App\Modules\BentukKups\Models\BentukKups;
use App\Modules\KelasKups\Models\KelasKups;
use App\Modules\SkemaPs\Models\SkemaPs;
use App\Modules\Desa\Models\Desa;

use App\Http\Controllers\Controller;
use App\Modules\Survey\Models\Survey;
use Illuminate\Support\Facades\Auth;

class KupsController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kups";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kups::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kups::kups', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_kps = Kps::all()->pluck('nama_kps','id');
		$ref_bentuk_kups = BentukKups::all()->pluck('bentuk_kups','id');
		$ref_kelas_kups = KelasKups::all()->pluck('nama_kelas_kups','id');
		$ref_skema_ps = SkemaPs::all()->pluck('nama_skema','id');
		$ref_desa = Desa::all()->pluck('id_kecamatan','id');
		
		$data['forms'] = array(
			'nama_kups' => ['Nama Kups', Form::text("nama_kups", old("nama_kups"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'id_kps' => ['Kps', Form::select("id_kps", $ref_kps, null, ["class" => "form-control select2"]) ],
			'id_bentuk_kups' => ['Bentuk Kups', Form::select("id_bentuk_kups", $ref_bentuk_kups, null, ["class" => "form-control select2"]) ],
			'id_kelas_kups' => ['Kelas Kups', Form::select("id_kelas_kups", $ref_kelas_kups, null, ["class" => "form-control select2"]) ],
			'no_sk' => ['No Sk', Form::text("no_sk", old("no_sk"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'tgl_sk' => ['Tgl Sk', Form::text("tgl_sk", old("tgl_sk"), ["class" => "form-control datepicker", "required" => "required"]) ],
			'id_skema_ps' => ['Skema Ps', Form::select("id_skema_ps", $ref_skema_ps, null, ["class" => "form-control select2"]) ],
			'id_desa' => ['Desa', Form::select("id_desa", $ref_desa, null, ["class" => "form-control select2"]) ],
			'koord_x' => ['Koord X', Form::text("koord_x", old("koord_x"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'koord_y' => ['Koord Y', Form::text("koord_y", old("koord_y"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'luas' => ['Luas', Form::text("luas", old("luas"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'tahun_dibentuk' => ['Tahun Dibentuk', Form::text("tahun_dibentuk", old("tahun_dibentuk"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kups::kups_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_kups' => 'required',
			'id_kps' => 'required',
			'id_bentuk_kups' => 'required',
			'id_kelas_kups' => 'required',
			'no_sk' => 'required',
			'tgl_sk' => 'required',
			'id_skema_ps' => 'required',
			'id_desa' => 'required',
			'koord_x' => 'required',
			'koord_y' => 'required',
			'luas' => 'required',
			'tahun_dibentuk' => 'required',
			
		]);

		$kups = new Kups();
		$kups->nama_kups = $request->input("nama_kups");
		$kups->id_kps = $request->input("id_kps");
		$kups->id_bentuk_kups = $request->input("id_bentuk_kups");
		$kups->id_kelas_kups = $request->input("id_kelas_kups");
		$kups->no_sk = $request->input("no_sk");
		$kups->tgl_sk = $request->input("tgl_sk");
		$kups->id_skema_ps = $request->input("id_skema_ps");
		$kups->id_desa = $request->input("id_desa");
		$kups->koord_x = $request->input("koord_x");
		$kups->koord_y = $request->input("koord_y");
		$kups->luas = $request->input("luas");
		$kups->tahun_dibentuk = $request->input("tahun_dibentuk");
		
		$kups->created_by = Auth::id();
		$kups->save();

		$text = 'membuat '.$this->title; //' baru '.$kups->what;
		$this->log($request, $text, ['kups.id' => $kups->id]);
		return redirect()->route('kups.index')->with('message_success', 'Kups berhasil ditambahkan!');
	}

	public function show(Request $request, Kups $kups)
	{
		$data['kups'] = $kups;
		$data['kps']  = Kps::find($kups->id_kps);

		$text = 'melihat detail '.$this->title;//.' '.$kups->what;
		$this->log($request, $text, ['kups.id' => $kups->id]);
		return view('Kups::kups_detail', array_merge($data, ['title' => $this->title]));
	}

	public function survey(Request $request, Kups $kups)
	{
		$data['kups'] = $kups;
		$data['kps']  = Kps::find($kups->id_kps);
		$data['marker'] = Survey::whereIdKups($kups->id)
								->join('koord_survey', 'koord_survey.id_survey','=','survey.id')
								->where('survey.type', 'marker')
								->get();

		$text = 'melihat detail '.$this->title;//.' '.$kups->what;
		$this->log($request, $text, ['kups.id' => $kups->id]);
		return view('Kups::kups_survey', array_merge($data, ['title' => $this->title]));
	}

	public function simpan_batas(Request $request)
	{
		$kups = Kups::find($request->id_kups);

		$kups->geojson = $request->koordinat;

		$kups->save();
	}

	public function edit(Request $request, Kups $kups)
	{
		$data['kups'] = $kups;

		$ref_kps = Kps::all()->pluck('nama_kps','id');
		$ref_bentuk_kups = BentukKups::all()->pluck('bentuk_kups','id');
		$ref_kelas_kups = KelasKups::all()->pluck('nama_kelas_kups','id');
		$ref_skema_ps = SkemaPs::all()->pluck('nama_skema','id');
		$ref_desa = Desa::all()->pluck('id_kecamatan','id');
		
		$data['forms'] = array(
			'nama_kups' => ['Nama Kups', Form::text("nama_kups", $kups->nama_kups, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_kups"]) ],
			'id_kps' => ['Kps', Form::select("id_kps", $ref_kps, null, ["class" => "form-control select2"]) ],
			'id_bentuk_kups' => ['Bentuk Kups', Form::select("id_bentuk_kups", $ref_bentuk_kups, null, ["class" => "form-control select2"]) ],
			'id_kelas_kups' => ['Kelas Kups', Form::select("id_kelas_kups", $ref_kelas_kups, null, ["class" => "form-control select2"]) ],
			'no_sk' => ['No Sk', Form::text("no_sk", $kups->no_sk, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "no_sk"]) ],
			'tgl_sk' => ['Tgl Sk', Form::text("tgl_sk", $kups->tgl_sk, ["class" => "form-control datepicker", "required" => "required", "id" => "tgl_sk"]) ],
			'id_skema_ps' => ['Skema Ps', Form::select("id_skema_ps", $ref_skema_ps, null, ["class" => "form-control select2"]) ],
			'id_desa' => ['Desa', Form::select("id_desa", $ref_desa, null, ["class" => "form-control select2"]) ],
			'koord_x' => ['Koord X', Form::text("koord_x", $kups->koord_x, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "koord_x"]) ],
			'koord_y' => ['Koord Y', Form::text("koord_y", $kups->koord_y, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "koord_y"]) ],
			'luas' => ['Luas', Form::text("luas", $kups->luas, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "luas"]) ],
			'tahun_dibentuk' => ['Tahun Dibentuk', Form::text("tahun_dibentuk", $kups->tahun_dibentuk, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "tahun_dibentuk"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kups->what;
		$this->log($request, $text, ['kups.id' => $kups->id]);
		return view('Kups::kups_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_kups' => 'required',
			'id_kps' => 'required',
			'id_bentuk_kups' => 'required',
			'id_kelas_kups' => 'required',
			'no_sk' => 'required',
			'tgl_sk' => 'required',
			'id_skema_ps' => 'required',
			'id_desa' => 'required',
			'koord_x' => 'required',
			'koord_y' => 'required',
			'luas' => 'required',
			'tahun_dibentuk' => 'required',
			
		]);
		
		$kups = Kups::find($id);
		$kups->nama_kups = $request->input("nama_kups");
		$kups->id_kps = $request->input("id_kps");
		$kups->id_bentuk_kups = $request->input("id_bentuk_kups");
		$kups->id_kelas_kups = $request->input("id_kelas_kups");
		$kups->no_sk = $request->input("no_sk");
		$kups->tgl_sk = $request->input("tgl_sk");
		$kups->id_skema_ps = $request->input("id_skema_ps");
		$kups->id_desa = $request->input("id_desa");
		$kups->koord_x = $request->input("koord_x");
		$kups->koord_y = $request->input("koord_y");
		$kups->luas = $request->input("luas");
		$kups->tahun_dibentuk = $request->input("tahun_dibentuk");
		
		$kups->updated_by = Auth::id();
		$kups->save();


		$text = 'mengedit '.$this->title;//.' '.$kups->what;
		$this->log($request, $text, ['kups.id' => $kups->id]);
		return redirect()->route('kups.index')->with('message_success', 'Kups berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kups = Kups::find($id);
		$kups->deleted_by = Auth::id();
		$kups->save();
		$kups->delete();

		$text = 'menghapus '.$this->title;//.' '.$kups->what;
		$this->log($request, $text, ['kups.id' => $kups->id]);
		return back()->with('message_success', 'Kups berhasil dihapus!');
	}

}
