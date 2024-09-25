<?php
namespace App\Modules\SkemaPs\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\SkemaPs\Models\SkemaPs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SkemaPsController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Skema Ps";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = SkemaPs::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('SkemaPs::skemaps', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'nama_skema' => ['Nama Skema', Form::text("nama_skema", old("nama_skema"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'kode_skema' => ['Kode Skema', Form::text("kode_skema", old("kode_skema"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('SkemaPs::skemaps_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_skema' => 'required',
			'kode_skema' => 'required',
			
		]);

		$skemaps = new SkemaPs();
		$skemaps->nama_skema = $request->input("nama_skema");
		$skemaps->kode_skema = $request->input("kode_skema");
		
		$skemaps->created_by = Auth::id();
		$skemaps->save();

		$text = 'membuat '.$this->title; //' baru '.$skemaps->what;
		$this->log($request, $text, ['skemaps.id' => $skemaps->id]);
		return redirect()->route('skemaps.index')->with('message_success', 'Skema Ps berhasil ditambahkan!');
	}

	public function show(Request $request, SkemaPs $skemaps)
	{
		$data['skemaps'] = $skemaps;

		$text = 'melihat detail '.$this->title;//.' '.$skemaps->what;
		$this->log($request, $text, ['skemaps.id' => $skemaps->id]);
		return view('SkemaPs::skemaps_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, SkemaPs $skemaps)
	{
		$data['skemaps'] = $skemaps;

		
		$data['forms'] = array(
			'nama_skema' => ['Nama Skema', Form::text("nama_skema", $skemaps->nama_skema, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_skema"]) ],
			'kode_skema' => ['Kode Skema', Form::text("kode_skema", $skemaps->kode_skema, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "kode_skema"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$skemaps->what;
		$this->log($request, $text, ['skemaps.id' => $skemaps->id]);
		return view('SkemaPs::skemaps_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_skema' => 'required',
			'kode_skema' => 'required',
			
		]);
		
		$skemaps = SkemaPs::find($id);
		$skemaps->nama_skema = $request->input("nama_skema");
		$skemaps->kode_skema = $request->input("kode_skema");
		
		$skemaps->updated_by = Auth::id();
		$skemaps->save();


		$text = 'mengedit '.$this->title;//.' '.$skemaps->what;
		$this->log($request, $text, ['skemaps.id' => $skemaps->id]);
		return redirect()->route('skemaps.index')->with('message_success', 'Skema Ps berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$skemaps = SkemaPs::find($id);
		$skemaps->deleted_by = Auth::id();
		$skemaps->save();
		$skemaps->delete();

		$text = 'menghapus '.$this->title;//.' '.$skemaps->what;
		$this->log($request, $text, ['skemaps.id' => $skemaps->id]);
		return back()->with('message_success', 'Skema Ps berhasil dihapus!');
	}

}
