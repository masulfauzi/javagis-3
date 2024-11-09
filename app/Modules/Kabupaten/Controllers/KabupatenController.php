<?php
namespace App\Modules\Kabupaten\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kabupaten\Models\Kabupaten;
use App\Modules\Provinsi\Models\Provinsi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KabupatenController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kabupaten";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kabupaten::query()->orderBy('kode_kabupaten');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(20)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kabupaten::kabupaten', array_merge($data, ['title' => $this->title]));
	}

	public function get_kabupaten(Request $request)
	{
		$data = [];

        if($request->filled('id_provinsi')){
            $data = Kabupaten::select("kabupaten.id", "kabupaten.nama_kabupaten")
								->whereIdProvinsi($request->id_provinsi)
                        		->get();
        }

        return response()->json($data);
	}

	public function get_kabupaten_tematik(Request $request)
	{
		$data = [];

        if($request->filled('id_provinsi')){
            $data = Kabupaten::select("kabupaten.id", "kabupaten.nama_kabupaten")
								->join('kecamatan as kec', 'kec.id_kabupaten', '=', 'kabupaten.id')
								->join('desa as des', 'des.id_kecamatan', '=', 'kec.id')
								->join('kps', 'kps.id_desa', '=', 'des.id')
								->join('tematik as tik', 'tik.id', '=', 'kps.id_tematik')
								->whereIdProvinsi($request->id_provinsi)
                        		->get();
        }

        return response()->json($data);
	}

	public function create(Request $request)
	{
		$ref_provinsi = Provinsi::all()->pluck('id_seksi_wilayah','id');
		
		$data['forms'] = array(
			'id_provinsi' => ['Provinsi', Form::select("id_provinsi", $ref_provinsi, null, ["class" => "form-control select2"]) ],
			'nama_kabupaten' => ['Nama Kabupaten', Form::text("nama_kabupaten", old("nama_kabupaten"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kabupaten::kabupaten_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_provinsi' => 'required',
			'nama_kabupaten' => 'required',
			
		]);

		$kabupaten = new Kabupaten();
		$kabupaten->id_provinsi = $request->input("id_provinsi");
		$kabupaten->nama_kabupaten = $request->input("nama_kabupaten");
		
		$kabupaten->created_by = Auth::id();
		$kabupaten->save();

		$text = 'membuat '.$this->title; //' baru '.$kabupaten->what;
		$this->log($request, $text, ['kabupaten.id' => $kabupaten->id]);
		return redirect()->route('kabupaten.index')->with('message_success', 'Kabupaten berhasil ditambahkan!');
	}

	public function show(Request $request, Kabupaten $kabupaten)
	{
		$data['kabupaten'] = $kabupaten;

		$text = 'melihat detail '.$this->title;//.' '.$kabupaten->what;
		$this->log($request, $text, ['kabupaten.id' => $kabupaten->id]);
		return view('Kabupaten::kabupaten_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kabupaten $kabupaten)
	{
		$data['kabupaten'] = $kabupaten;

		$ref_provinsi = Provinsi::all()->pluck('id_seksi_wilayah','id');
		
		$data['forms'] = array(
			'id_provinsi' => ['Provinsi', Form::select("id_provinsi", $ref_provinsi, null, ["class" => "form-control select2"]) ],
			'nama_kabupaten' => ['Nama Kabupaten', Form::text("nama_kabupaten", $kabupaten->nama_kabupaten, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_kabupaten"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kabupaten->what;
		$this->log($request, $text, ['kabupaten.id' => $kabupaten->id]);
		return view('Kabupaten::kabupaten_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_provinsi' => 'required',
			'nama_kabupaten' => 'required',
			
		]);
		
		$kabupaten = Kabupaten::find($id);
		$kabupaten->id_provinsi = $request->input("id_provinsi");
		$kabupaten->nama_kabupaten = $request->input("nama_kabupaten");
		
		$kabupaten->updated_by = Auth::id();
		$kabupaten->save();


		$text = 'mengedit '.$this->title;//.' '.$kabupaten->what;
		$this->log($request, $text, ['kabupaten.id' => $kabupaten->id]);
		return redirect()->route('kabupaten.index')->with('message_success', 'Kabupaten berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kabupaten = Kabupaten::find($id);
		$kabupaten->deleted_by = Auth::id();
		$kabupaten->save();
		$kabupaten->delete();

		$text = 'menghapus '.$this->title;//.' '.$kabupaten->what;
		$this->log($request, $text, ['kabupaten.id' => $kabupaten->id]);
		return back()->with('message_success', 'Kabupaten berhasil dihapus!');
	}

}
