<?php
namespace App\Modules\Kecamatan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kecamatan\Models\Kecamatan;
use App\Modules\Kabupaten\Models\Kabupaten;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KecamatanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kecamatan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kecamatan::query()->orderBy('kode_kecamatan');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(30)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kecamatan::kecamatan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_kabupaten = Kabupaten::all()->pluck('id_provinsi','id');
		
		$data['forms'] = array(
			'id_kabupaten' => ['Kabupaten', Form::select("id_kabupaten", $ref_kabupaten, null, ["class" => "form-control select2"]) ],
			'nama_kecamatan' => ['Nama Kecamatan', Form::text("nama_kecamatan", old("nama_kecamatan"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'kode_kecamatan' => ['Kode Kecamatan', Form::text("kode_kecamatan", old("kode_kecamatan"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kecamatan::kecamatan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_kabupaten' => 'required',
			'nama_kecamatan' => 'required',
			'kode_kecamatan' => 'required',
			
		]);

		$kecamatan = new Kecamatan();
		$kecamatan->id_kabupaten = $request->input("id_kabupaten");
		$kecamatan->nama_kecamatan = $request->input("nama_kecamatan");
		$kecamatan->kode_kecamatan = $request->input("kode_kecamatan");
		
		$kecamatan->created_by = Auth::id();
		$kecamatan->save();

		$text = 'membuat '.$this->title; //' baru '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return redirect()->route('kecamatan.index')->with('message_success', 'Kecamatan berhasil ditambahkan!');
	}

	public function show(Request $request, Kecamatan $kecamatan)
	{
		$data['kecamatan'] = $kecamatan;

		$text = 'melihat detail '.$this->title;//.' '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return view('Kecamatan::kecamatan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kecamatan $kecamatan)
	{
		$data['kecamatan'] = $kecamatan;

		$ref_kabupaten = Kabupaten::all()->pluck('id_provinsi','id');
		
		$data['forms'] = array(
			'id_kabupaten' => ['Kabupaten', Form::select("id_kabupaten", $ref_kabupaten, null, ["class" => "form-control select2"]) ],
			'nama_kecamatan' => ['Nama Kecamatan', Form::text("nama_kecamatan", $kecamatan->nama_kecamatan, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_kecamatan"]) ],
			'kode_kecamatan' => ['Kode Kecamatan', Form::text("kode_kecamatan", $kecamatan->kode_kecamatan, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "kode_kecamatan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return view('Kecamatan::kecamatan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_kabupaten' => 'required',
			'nama_kecamatan' => 'required',
			'kode_kecamatan' => 'required',
			
		]);
		
		$kecamatan = Kecamatan::find($id);
		$kecamatan->id_kabupaten = $request->input("id_kabupaten");
		$kecamatan->nama_kecamatan = $request->input("nama_kecamatan");
		$kecamatan->kode_kecamatan = $request->input("kode_kecamatan");
		
		$kecamatan->updated_by = Auth::id();
		$kecamatan->save();


		$text = 'mengedit '.$this->title;//.' '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return redirect()->route('kecamatan.index')->with('message_success', 'Kecamatan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kecamatan = Kecamatan::find($id);
		$kecamatan->deleted_by = Auth::id();
		$kecamatan->save();
		$kecamatan->delete();

		$text = 'menghapus '.$this->title;//.' '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return back()->with('message_success', 'Kecamatan berhasil dihapus!');
	}

}
