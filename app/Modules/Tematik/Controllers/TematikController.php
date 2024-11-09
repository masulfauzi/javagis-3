<?php
namespace App\Modules\Tematik\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Tematik\Models\Tematik;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TematikController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Tematik";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Tematik::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Tematik::tematik', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'tematik' => ['Tematik', Form::text("tematik", old("tematik"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Tematik::tematik_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'tematik' => 'required',
			
		]);

		$tematik = new Tematik();
		$tematik->tematik = $request->input("tematik");
		
		$tematik->created_by = Auth::id();
		$tematik->save();

		$text = 'membuat '.$this->title; //' baru '.$tematik->what;
		$this->log($request, $text, ['tematik.id' => $tematik->id]);
		return redirect()->route('tematik.index')->with('message_success', 'Tematik berhasil ditambahkan!');
	}

	public function show(Request $request, Tematik $tematik)
	{
		$data['tematik'] = $tematik;

		$text = 'melihat detail '.$this->title;//.' '.$tematik->what;
		$this->log($request, $text, ['tematik.id' => $tematik->id]);
		return view('Tematik::tematik_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Tematik $tematik)
	{
		$data['tematik'] = $tematik;

		
		$data['forms'] = array(
			'tematik' => ['Tematik', Form::text("tematik", $tematik->tematik, ["class" => "form-control","placeholder" => "", "id" => "tematik"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$tematik->what;
		$this->log($request, $text, ['tematik.id' => $tematik->id]);
		return view('Tematik::tematik_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'tematik' => 'required',
			
		]);
		
		$tematik = Tematik::find($id);
		$tematik->tematik = $request->input("tematik");
		
		$tematik->updated_by = Auth::id();
		$tematik->save();


		$text = 'mengedit '.$this->title;//.' '.$tematik->what;
		$this->log($request, $text, ['tematik.id' => $tematik->id]);
		return redirect()->route('tematik.index')->with('message_success', 'Tematik berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$tematik = Tematik::find($id);
		$tematik->deleted_by = Auth::id();
		$tematik->save();
		$tematik->delete();

		$text = 'menghapus '.$this->title;//.' '.$tematik->what;
		$this->log($request, $text, ['tematik.id' => $tematik->id]);
		return back()->with('message_success', 'Tematik berhasil dihapus!');
	}

}
