<?php
namespace App\Modules\KoordSurvey\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\KoordSurvey\Models\KoordSurvey;
use App\Modules\Survey\Models\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KoordSurveyController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Koord Survey";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = KoordSurvey::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('KoordSurvey::koordsurvey', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_survey = Survey::all()->pluck('id_kups','id');
		
		$data['forms'] = array(
			'id_survey' => ['Survey', Form::select("id_survey", $ref_survey, null, ["class" => "form-control select2"]) ],
			'koord_x' => ['Koord X', Form::text("koord_x", old("koord_x"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'koord_y' => ['Koord Y', Form::text("koord_y", old("koord_y"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'index' => ['Index', Form::text("index", old("index"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'foto' => ['Foto', Form::text("foto", old("foto"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'ket_lokasi' => ['Ket Lokasi', Form::textarea("ket_lokasi", old("ket_lokasi"), ["class" => "form-control rich-editor"]) ],
			'ket_objek' => ['Ket Objek', Form::textarea("ket_objek", old("ket_objek"), ["class" => "form-control rich-editor"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('KoordSurvey::koordsurvey_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		// $this->validate($request, [
		// 	'id_survey' => 'required',
		// 	'koord_x' => 'required',
		// 	'koord_y' => 'required',
		// 	'index' => 'required',
		// 	'foto' => 'required',
		// 	'ket_lokasi' => 'required',
		// 	'ket_objek' => 'required',
			
		// ]);

		$cek_koord = KoordSurvey::whereIdSurvey($request->get('id_survey'))->orderBy('created_at','DESC')->first();

		if($cek_koord)
		{
			$index = $cek_koord->index + 1;
		}
		else{
			$index = 0;
		}

		if($request->has('foto'))
		{
			$foto = time().'.'.$request->foto->extension();  

			$request->foto->move(public_path('uploads/markers/'), $foto);
		}
		else{
			$foto = '';
		}

		$koordsurvey = new KoordSurvey();
		$koordsurvey->id_survey = $request->input("id_survey");
		$koordsurvey->koord_x = $request->input("koord_x");
		$koordsurvey->koord_y = $request->input("koord_y");
		$koordsurvey->index = $index;
		$koordsurvey->foto = $foto;
		$koordsurvey->ket_lokasi = $request->input("ket_lokasi");
		$koordsurvey->ket_objek = $request->input("ket_objek");
		
		$koordsurvey->created_by = Auth::id();
		$koordsurvey->save();

		$text = 'membuat '.$this->title; //' baru '.$koordsurvey->what;
		$this->log($request, $text, ['koordsurvey.id' => $koordsurvey->id]);
		return redirect()->route('survey.show', $request->get('id_survey'))->with('message_success', 'Koord Survey berhasil ditambahkan!');
	}

	public function show(Request $request, KoordSurvey $koordsurvey)
	{
		$data['koordsurvey'] = $koordsurvey;

		$text = 'melihat detail '.$this->title;//.' '.$koordsurvey->what;
		$this->log($request, $text, ['koordsurvey.id' => $koordsurvey->id]);
		return view('KoordSurvey::koordsurvey_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, KoordSurvey $koordsurvey)
	{
		$data['koordsurvey'] = $koordsurvey;

		$ref_survey = Survey::all()->pluck('id_kups','id');
		
		$data['forms'] = array(
			'id_survey' => ['Survey', Form::select("id_survey", $ref_survey, null, ["class" => "form-control select2"]) ],
			'koord_x' => ['Koord X', Form::text("koord_x", $koordsurvey->koord_x, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "koord_x"]) ],
			'koord_y' => ['Koord Y', Form::text("koord_y", $koordsurvey->koord_y, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "koord_y"]) ],
			'index' => ['Index', Form::text("index", $koordsurvey->index, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "index"]) ],
			'foto' => ['Foto', Form::text("foto", $koordsurvey->foto, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "foto"]) ],
			'ket_lokasi' => ['Ket Lokasi', Form::textarea("ket_lokasi", $koordsurvey->ket_lokasi, ["class" => "form-control rich-editor"]) ],
			'ket_objek' => ['Ket Objek', Form::textarea("ket_objek", $koordsurvey->ket_objek, ["class" => "form-control rich-editor"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$koordsurvey->what;
		$this->log($request, $text, ['koordsurvey.id' => $koordsurvey->id]);
		return view('KoordSurvey::koordsurvey_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_survey' => 'required',
			'koord_x' => 'required',
			'koord_y' => 'required',
			'index' => 'required',
			'foto' => 'required',
			'ket_lokasi' => 'required',
			'ket_objek' => 'required',
			
		]);
		
		$koordsurvey = KoordSurvey::find($id);
		$koordsurvey->id_survey = $request->input("id_survey");
		$koordsurvey->koord_x = $request->input("koord_x");
		$koordsurvey->koord_y = $request->input("koord_y");
		$koordsurvey->index = $request->input("index");
		$koordsurvey->foto = $request->input("foto");
		$koordsurvey->ket_lokasi = $request->input("ket_lokasi");
		$koordsurvey->ket_objek = $request->input("ket_objek");
		
		$koordsurvey->updated_by = Auth::id();
		$koordsurvey->save();


		$text = 'mengedit '.$this->title;//.' '.$koordsurvey->what;
		$this->log($request, $text, ['koordsurvey.id' => $koordsurvey->id]);
		return redirect()->route('koordsurvey.index')->with('message_success', 'Koord Survey berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$koordsurvey = KoordSurvey::find($id);
		$koordsurvey->deleted_by = Auth::id();
		$koordsurvey->save();
		$koordsurvey->delete();

		$text = 'menghapus '.$this->title;//.' '.$koordsurvey->what;
		$this->log($request, $text, ['koordsurvey.id' => $koordsurvey->id]);
		return back()->with('message_success', 'Koord Survey berhasil dihapus!');
	}

}
