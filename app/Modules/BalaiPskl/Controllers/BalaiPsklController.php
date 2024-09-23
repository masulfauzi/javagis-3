<?php
namespace App\Modules\BalaiPskl\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\BalaiPskl\Models\BalaiPskl;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BalaiPsklController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Balai Pskl";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = BalaiPskl::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('BalaiPskl::balaipskl', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'nama_balai_pskl' => ['Nama Balai Pskl', Form::text("nama_balai_pskl", old("nama_balai_pskl"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('BalaiPskl::balaipskl_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_balai_pskl' => 'required',
			
		]);

		$balaipskl = new BalaiPskl();
		$balaipskl->nama_balai_pskl = $request->input("nama_balai_pskl");
		
		$balaipskl->created_by = Auth::id();
		$balaipskl->save();

		$text = 'membuat '.$this->title; //' baru '.$balaipskl->what;
		$this->log($request, $text, ['balaipskl.id' => $balaipskl->id]);
		return redirect()->route('balaipskl.index')->with('message_success', 'Balai Pskl berhasil ditambahkan!');
	}

	public function show(Request $request, BalaiPskl $balaipskl)
	{
		$data['balaipskl'] = $balaipskl;

		$text = 'melihat detail '.$this->title;//.' '.$balaipskl->what;
		$this->log($request, $text, ['balaipskl.id' => $balaipskl->id]);
		return view('BalaiPskl::balaipskl_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, BalaiPskl $balaipskl)
	{
		$data['balaipskl'] = $balaipskl;

		
		$data['forms'] = array(
			'nama_balai_pskl' => ['Nama Balai Pskl', Form::text("nama_balai_pskl", $balaipskl->nama_balai_pskl, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_balai_pskl"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$balaipskl->what;
		$this->log($request, $text, ['balaipskl.id' => $balaipskl->id]);
		return view('BalaiPskl::balaipskl_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_balai_pskl' => 'required',
			
		]);
		
		$balaipskl = BalaiPskl::find($id);
		$balaipskl->nama_balai_pskl = $request->input("nama_balai_pskl");
		
		$balaipskl->updated_by = Auth::id();
		$balaipskl->save();


		$text = 'mengedit '.$this->title;//.' '.$balaipskl->what;
		$this->log($request, $text, ['balaipskl.id' => $balaipskl->id]);
		return redirect()->route('balaipskl.index')->with('message_success', 'Balai Pskl berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$balaipskl = BalaiPskl::find($id);
		$balaipskl->deleted_by = Auth::id();
		$balaipskl->save();
		$balaipskl->delete();

		$text = 'menghapus '.$this->title;//.' '.$balaipskl->what;
		$this->log($request, $text, ['balaipskl.id' => $balaipskl->id]);
		return back()->with('message_success', 'Balai Pskl berhasil dihapus!');
	}

}
