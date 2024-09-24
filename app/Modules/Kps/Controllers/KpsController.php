<?php
namespace App\Modules\Kps\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kps\Models\Kps;
use App\Modules\Desa\Models\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KpsController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kps";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kps::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kps::kps', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_desa = Desa::limit(3)->pluck('id_kecamatan','id');
		
		$data['forms'] = array(
			'nama_kps' => ['Nama Kps', Form::text("nama_kps", old("nama_kps"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'id_desa' => ['Desa', Form::select("id_desa", $ref_desa, null, ["class" => "form-control", "id" => "id_desa"]) ],
			'no_sk' => ['No Sk', Form::text("no_sk", old("no_sk"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'tgl_sk' => ['Tgl Sk', Form::text("tgl_sk", old("tgl_sk"), ["class" => "form-control datepicker", "required" => "required"]) ],
			'luas' => ['Luas', Form::text("luas", old("luas"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'koord_x' => ['Koord X', Form::text("koord_x", old("koord_x"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'koord_y' => ['Koord Y', Form::text("koord_y", old("koord_y"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kps::kps_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_kps' => 'required',
			'id_desa' => 'required',
			'no_sk' => 'required',
			'tgl_sk' => 'required',
			'luas' => 'required',
			'koord_x' => 'required',
			'koord_y' => 'required',
			
		]);

		$kps = new Kps();
		$kps->nama_kps = $request->input("nama_kps");
		$kps->id_desa = $request->input("id_desa");
		$kps->no_sk = $request->input("no_sk");
		$kps->tgl_sk = $request->input("tgl_sk");
		$kps->luas = $request->input("luas");
		$kps->koord_x = $request->input("koord_x");
		$kps->koord_y = $request->input("koord_y");
		
		$kps->created_by = Auth::id();
		$kps->save();

		$text = 'membuat '.$this->title; //' baru '.$kps->what;
		$this->log($request, $text, ['kps.id' => $kps->id]);
		return redirect()->route('kps.index')->with('message_success', 'Kps berhasil ditambahkan!');
	}

	public function show(Request $request, Kps $kps)
	{
		$data['kps'] = $kps;

		$text = 'melihat detail '.$this->title;//.' '.$kps->what;
		$this->log($request, $text, ['kps.id' => $kps->id]);
		return view('Kps::kps_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kps $kps)
	{
		$data['kps'] = $kps;

		$ref_desa = Desa::all()->pluck('id_kecamatan','id');
		
		$data['forms'] = array(
			'nama_kps' => ['Nama Kps', Form::text("nama_kps", $kps->nama_kps, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_kps"]) ],
			'id_desa' => ['Desa', Form::select("id_desa", $ref_desa, null, ["class" => "form-control select2"]) ],
			'no_sk' => ['No Sk', Form::text("no_sk", $kps->no_sk, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "no_sk"]) ],
			'tgl_sk' => ['Tgl Sk', Form::text("tgl_sk", $kps->tgl_sk, ["class" => "form-control datepicker", "required" => "required", "id" => "tgl_sk"]) ],
			'luas' => ['Luas', Form::text("luas", $kps->luas, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "luas"]) ],
			'koord_x' => ['Koord X', Form::text("koord_x", $kps->koord_x, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "koord_x"]) ],
			'koord_y' => ['Koord Y', Form::text("koord_y", $kps->koord_y, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "koord_y"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kps->what;
		$this->log($request, $text, ['kps.id' => $kps->id]);
		return view('Kps::kps_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_kps' => 'required',
			'id_desa' => 'required',
			'no_sk' => 'required',
			'tgl_sk' => 'required',
			'luas' => 'required',
			'koord_x' => 'required',
			'koord_y' => 'required',
			
		]);
		
		$kps = Kps::find($id);
		$kps->nama_kps = $request->input("nama_kps");
		$kps->id_desa = $request->input("id_desa");
		$kps->no_sk = $request->input("no_sk");
		$kps->tgl_sk = $request->input("tgl_sk");
		$kps->luas = $request->input("luas");
		$kps->koord_x = $request->input("koord_x");
		$kps->koord_y = $request->input("koord_y");
		
		$kps->updated_by = Auth::id();
		$kps->save();


		$text = 'mengedit '.$this->title;//.' '.$kps->what;
		$this->log($request, $text, ['kps.id' => $kps->id]);
		return redirect()->route('kps.index')->with('message_success', 'Kps berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kps = Kps::find($id);
		$kps->deleted_by = Auth::id();
		$kps->save();
		$kps->delete();

		$text = 'menghapus '.$this->title;//.' '.$kps->what;
		$this->log($request, $text, ['kps.id' => $kps->id]);
		return back()->with('message_success', 'Kps berhasil dihapus!');
	}

}
