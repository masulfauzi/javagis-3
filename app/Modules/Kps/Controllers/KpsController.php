<?php
namespace App\Modules\Kps\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kps\Models\Kps;
use App\Modules\Desa\Models\Desa;

use App\Http\Controllers\Controller;
use App\Modules\BalaiPskl\Models\BalaiPskl;
use App\Modules\Kabupaten\Models\Kabupaten;
use App\Modules\Kups\Models\Kups;
use App\Modules\Provinsi\Models\Provinsi;
use App\Modules\SeksiWilayah\Models\SeksiWilayah;
use App\Modules\Survey\Models\Survey;
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
		$query = Kps::select('kps.*')
					->join('desa as des', 'des.id', '=', 'kps.id_desa')
					->join('kecamatan as kec', 'kec.id', '=', 'des.id_kecamatan')
					->join('kabupaten as kab', 'kab.id', '=', 'kec.id_kabupaten')
					->join('provinsi as prov', 'prov.id', '=', 'kab.id_provinsi')
					->join('seksi_wilayah as seksi', 'seksi.id', '=', 'prov.id_seksi_wilayah')
					->join('balai_pskl as balai', 'balai.id', '=', 'seksi.id_balai_pskl');

		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}

		if($request->has('id_balai'))
		{
			$query->where('balai.id', $request->get('id_balai'));
			$data['seksi_wilayah'] = SeksiWilayah::whereIdBalaiPskl($request->get('id_balai'))->pluck('nama_seksi_wilayah', 'id');
			// dd($data['seksi_wilayah']);
		}

		if($request->has('id_seksi_wilayah') && $request->get('id_seksi_wilayah') != '')
		{
			$query->where('seksi.id', $request->get('id_seksi_wilayah'));
			$data['provinsi'] = Provinsi::whereIdSeksiWilayah($request->get('id_seksi_wilayah'))->pluck('nama_provinsi', 'id');
		}

		if($request->has('id_provinsi') && $request->get('id_provinsi') != '')
		{
			$query->where('prov.id', $request->get('id_provinsi'));
			$data['kabupaten'] = Kabupaten::whereIdProvinsi($request->get('id_provinsi'))->pluck('nama_kabupaten', 'id');
		}

		if($request->has('id_kabupaten') && $request->get('id_kabupaten') != '')
		{
			$query->where('kab.id', $request->get('id_kabupaten'));
		}

		$data['selected'] = [
			'id_balai'	=> $request->get('id_balai'),
			'id_seksi_wilayah'	=> $request->get('id_seksi_wilayah'),
			'id_provinsi'	=> $request->get('id_provinsi'),
			'id_kabupaten'	=> $request->get('id_kabupaten'),
		];

		$data['data'] = $query->paginate(10)->withQueryString();
		$data['balai'] = BalaiPskl::all()->pluck('nama_balai_pskl', 'id');
		$data['balai']->prepend('-PILIH SALAH SATU-', '');

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kps::kps', array_merge($data, ['title' => $this->title]));
	}

	

	public function survey(Request $request, Kps $kps)
	{
		// dd($kps);
		$data['kps']  = $kps;
		$data['marker'] = Survey::whereIdKps($kps->id)
								->join('koord_survey', 'koord_survey.id_survey','=','survey.id')
								->where('survey.type', 'marker')
								->get();
		$data['survey'] = Survey::whereIdKps($kps->id)->get();

		$text = 'melihat detail '.$this->title;//.' '.$kups->what;
		$this->log($request, $text, ['kps.id' => $kps->id]);
		return view('Kps::kps_survey', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_desa = Desa::limit(3)->pluck('id_kecamatan','id');
		
		$data['forms'] = array(
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
			'koordinat' => 'required',
			// 'koord_y' => 'required',
			
		]);

		$pecah_koordinat = explode(",",$request->input('koordinat'));

		// dd($request->input('koordinat'));

		$kps = new Kps();
		$kps->nama_kps = $request->input("nama_kps");
		$kps->id_desa = $request->input("id_desa");
		$kps->no_sk = $request->input("no_sk");
		$kps->tgl_sk = $request->input("tgl_sk");
		$kps->luas = $request->input("luas");
		$kps->koord_x = $pecah_koordinat[0];
		$kps->koord_y = $pecah_koordinat[1];
		
		$kps->created_by = Auth::id();
		$kps->save();

		$text = 'membuat '.$this->title; //' baru '.$kps->what;
		$this->log($request, $text, ['kps.id' => $kps->id]);
		return redirect()->route('kps.index')->with('message_success', 'Kps berhasil ditambahkan!');
	}

	public function show(Request $request, Kps $kps)
	{
		$data['kps'] = $kps;
		$data['kups'] = Kups::whereIdKps($kps->id)->get();
		$data['survey'] = Survey::whereIdKps($kps->id)->get();

		$text = 'melihat detail '.$this->title;//.' '.$kps->what;
		$this->log($request, $text, ['kps.id' => $kps->id]);
		return view('Kps::kps_detail', array_merge($data, ['title' => $this->title]));
	}

	public function simpan_batas(Request $request)
	{
		$kps = Kps::find($request->id_kps);

		$kps->geojson = $request->koordinat;

		$kps->save();
	}

	public function edit(Request $request, Kps $kps)
	{
		$data['kps'] = $kps;

		
		// $ref_desa = Desa::all()->pluck('id_kecamatan','id');
		
		// dd($data);
		$data['forms'] = array(
			'nama_kps' => ['Nama Kps', Form::text("nama_kps", $kps->nama_kps, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_kps"]) ],
			// 'id_desa' => ['Desa', Form::select("id_desa", $ref_desa, null, ["class" => "form-control select2"]) ],
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
