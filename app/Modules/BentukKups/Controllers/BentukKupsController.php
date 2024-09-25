<?php
namespace App\Modules\BentukKups\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\BentukKups\Models\BentukKups;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BentukKupsController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Bentuk Kups";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = BentukKups::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('BentukKups::bentukkups', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'bentuk_kups' => ['Bentuk Kups', Form::text("bentuk_kups", old("bentuk_kups"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('BentukKups::bentukkups_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'bentuk_kups' => 'required',
			
		]);

		$bentukkups = new BentukKups();
		$bentukkups->bentuk_kups = $request->input("bentuk_kups");
		
		$bentukkups->created_by = Auth::id();
		$bentukkups->save();

		$text = 'membuat '.$this->title; //' baru '.$bentukkups->what;
		$this->log($request, $text, ['bentukkups.id' => $bentukkups->id]);
		return redirect()->route('bentukkups.index')->with('message_success', 'Bentuk Kups berhasil ditambahkan!');
	}

	public function show(Request $request, BentukKups $bentukkups)
	{
		$data['bentukkups'] = $bentukkups;

		$text = 'melihat detail '.$this->title;//.' '.$bentukkups->what;
		$this->log($request, $text, ['bentukkups.id' => $bentukkups->id]);
		return view('BentukKups::bentukkups_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, BentukKups $bentukkups)
	{
		$data['bentukkups'] = $bentukkups;

		
		$data['forms'] = array(
			'bentuk_kups' => ['Bentuk Kups', Form::text("bentuk_kups", $bentukkups->bentuk_kups, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "bentuk_kups"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$bentukkups->what;
		$this->log($request, $text, ['bentukkups.id' => $bentukkups->id]);
		return view('BentukKups::bentukkups_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'bentuk_kups' => 'required',
			
		]);
		
		$bentukkups = BentukKups::find($id);
		$bentukkups->bentuk_kups = $request->input("bentuk_kups");
		
		$bentukkups->updated_by = Auth::id();
		$bentukkups->save();


		$text = 'mengedit '.$this->title;//.' '.$bentukkups->what;
		$this->log($request, $text, ['bentukkups.id' => $bentukkups->id]);
		return redirect()->route('bentukkups.index')->with('message_success', 'Bentuk Kups berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$bentukkups = BentukKups::find($id);
		$bentukkups->deleted_by = Auth::id();
		$bentukkups->save();
		$bentukkups->delete();

		$text = 'menghapus '.$this->title;//.' '.$bentukkups->what;
		$this->log($request, $text, ['bentukkups.id' => $bentukkups->id]);
		return back()->with('message_success', 'Bentuk Kups berhasil dihapus!');
	}

}
