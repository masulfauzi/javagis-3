<?php
namespace App\Modules\SeksiWilayah\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\SeksiWilayah\Models\SeksiWilayah;
use App\Modules\BalaiPskl\Models\BalaiPskl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SeksiWilayahController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Seksi Wilayah";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = SeksiWilayah::query()->orderBy('id_balai_pskl');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('SeksiWilayah::seksiwilayah', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_balai_pskl = BalaiPskl::all()->pluck('nama_balai_pskl','id');
		$ref_balai_pskl->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'id_balai_pskl' => ['Balai Pskl', Form::select("id_balai_pskl", $ref_balai_pskl, null, ["class" => "form-control select2"]) ],
			'nama_seksi_silayah' => ['Nama Seksi Silayah', Form::text("nama_seksi_silayah", old("nama_seksi_silayah"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('SeksiWilayah::seksiwilayah_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_balai_pskl' => 'required',
			'nama_seksi_silayah' => 'required',
			
		]);

		$seksiwilayah = new SeksiWilayah();
		$seksiwilayah->id_balai_pskl = $request->input("id_balai_pskl");
		$seksiwilayah->nama_seksi_silayah = $request->input("nama_seksi_silayah");
		
		$seksiwilayah->created_by = Auth::id();
		$seksiwilayah->save();

		$text = 'membuat '.$this->title; //' baru '.$seksiwilayah->what;
		$this->log($request, $text, ['seksiwilayah.id' => $seksiwilayah->id]);
		return redirect()->route('seksiwilayah.index')->with('message_success', 'Seksi Wilayah berhasil ditambahkan!');
	}

	public function show(Request $request, SeksiWilayah $seksiwilayah)
	{
		$data['seksiwilayah'] = $seksiwilayah;

		$text = 'melihat detail '.$this->title;//.' '.$seksiwilayah->what;
		$this->log($request, $text, ['seksiwilayah.id' => $seksiwilayah->id]);
		return view('SeksiWilayah::seksiwilayah_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, SeksiWilayah $seksiwilayah)
	{
		$data['seksiwilayah'] = $seksiwilayah;

		$ref_balai_pskl = BalaiPskl::all()->pluck('nama_balai_pskl','id');
		
		$data['forms'] = array(
			'id_balai_pskl' => ['Balai Pskl', Form::select("id_balai_pskl", $ref_balai_pskl, null, ["class" => "form-control select2"]) ],
			'nama_seksi_silayah' => ['Nama Seksi Silayah', Form::text("nama_seksi_silayah", $seksiwilayah->nama_seksi_silayah, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_seksi_silayah"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$seksiwilayah->what;
		$this->log($request, $text, ['seksiwilayah.id' => $seksiwilayah->id]);
		return view('SeksiWilayah::seksiwilayah_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_balai_pskl' => 'required',
			'nama_seksi_silayah' => 'required',
			
		]);
		
		$seksiwilayah = SeksiWilayah::find($id);
		$seksiwilayah->id_balai_pskl = $request->input("id_balai_pskl");
		$seksiwilayah->nama_seksi_silayah = $request->input("nama_seksi_silayah");
		
		$seksiwilayah->updated_by = Auth::id();
		$seksiwilayah->save();


		$text = 'mengedit '.$this->title;//.' '.$seksiwilayah->what;
		$this->log($request, $text, ['seksiwilayah.id' => $seksiwilayah->id]);
		return redirect()->route('seksiwilayah.index')->with('message_success', 'Seksi Wilayah berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$seksiwilayah = SeksiWilayah::find($id);
		$seksiwilayah->deleted_by = Auth::id();
		$seksiwilayah->save();
		$seksiwilayah->delete();

		$text = 'menghapus '.$this->title;//.' '.$seksiwilayah->what;
		$this->log($request, $text, ['seksiwilayah.id' => $seksiwilayah->id]);
		return back()->with('message_success', 'Seksi Wilayah berhasil dihapus!');
	}

}
