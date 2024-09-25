<?php
namespace App\Modules\KelasKups\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\KelasKups\Models\KelasKups;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KelasKupsController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kelas Kups";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = KelasKups::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('KelasKups::kelaskups', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'nama_kelas_kups' => ['Nama Kelas Kups', Form::text("nama_kelas_kups", old("nama_kelas_kups"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('KelasKups::kelaskups_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_kelas_kups' => 'required',
			
		]);

		$kelaskups = new KelasKups();
		$kelaskups->nama_kelas_kups = $request->input("nama_kelas_kups");
		
		$kelaskups->created_by = Auth::id();
		$kelaskups->save();

		$text = 'membuat '.$this->title; //' baru '.$kelaskups->what;
		$this->log($request, $text, ['kelaskups.id' => $kelaskups->id]);
		return redirect()->route('kelaskups.index')->with('message_success', 'Kelas Kups berhasil ditambahkan!');
	}

	public function show(Request $request, KelasKups $kelaskups)
	{
		$data['kelaskups'] = $kelaskups;

		$text = 'melihat detail '.$this->title;//.' '.$kelaskups->what;
		$this->log($request, $text, ['kelaskups.id' => $kelaskups->id]);
		return view('KelasKups::kelaskups_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, KelasKups $kelaskups)
	{
		$data['kelaskups'] = $kelaskups;

		
		$data['forms'] = array(
			'nama_kelas_kups' => ['Nama Kelas Kups', Form::text("nama_kelas_kups", $kelaskups->nama_kelas_kups, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_kelas_kups"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kelaskups->what;
		$this->log($request, $text, ['kelaskups.id' => $kelaskups->id]);
		return view('KelasKups::kelaskups_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_kelas_kups' => 'required',
			
		]);
		
		$kelaskups = KelasKups::find($id);
		$kelaskups->nama_kelas_kups = $request->input("nama_kelas_kups");
		
		$kelaskups->updated_by = Auth::id();
		$kelaskups->save();


		$text = 'mengedit '.$this->title;//.' '.$kelaskups->what;
		$this->log($request, $text, ['kelaskups.id' => $kelaskups->id]);
		return redirect()->route('kelaskups.index')->with('message_success', 'Kelas Kups berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kelaskups = KelasKups::find($id);
		$kelaskups->deleted_by = Auth::id();
		$kelaskups->save();
		$kelaskups->delete();

		$text = 'menghapus '.$this->title;//.' '.$kelaskups->what;
		$this->log($request, $text, ['kelaskups.id' => $kelaskups->id]);
		return back()->with('message_success', 'Kelas Kups berhasil dihapus!');
	}

}
