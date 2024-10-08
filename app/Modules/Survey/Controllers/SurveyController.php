<?php
namespace App\Modules\Survey\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Survey\Models\Survey;
use App\Modules\Kups\Models\Kups;

use App\Http\Controllers\Controller;
use App\Modules\KoordSurvey\Models\KoordSurvey;
use App\Modules\Kps\Models\Kps;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SurveyController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Survey";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Survey::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Survey::survey', array_merge($data, ['title' => $this->title]));
	}

	public function save_image(Request $request)
	{
		$fileName = time().'.'.$request->image->extension();  

        $request->image->move(public_path('export_image/'), $fileName);

		$survey = Survey::find($request->input('id_survey'));

		$survey->image = $fileName;

		$survey->save();

		return json_encode(['status' => true]);
	}

	public function print(Request $request, Survey $survey)
	{
		// dd(Auth::user()->name);

		$data['survey'] = $survey;

		// return view('Survey::survey_print', $data);
		$pdf = Pdf::loadView('Survey::survey_print', $data);
    	return $pdf->download('hasil-survey.pdf');
	}

	public function export_survey(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->orderBy('index')->get();

		// dd($data['koord_survey']);

		$text = 'melihat detail '.$this->title;//.' '.$kups->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return view('Survey::survey_export', array_merge($data, ['title' => $this->title]));
	}

	public function form_marker(Request $request, Kups $kups)
	{
		return view('Survey::form_marker');
	}

	public function create(Request $request)
	{
		$ref_kups = Kups::all()->pluck('nama_kups','id');
		
		$data['forms'] = array(
			'id_kups' => ['Kups', Form::select("id_kups", $ref_kups, null, ["class" => "form-control select2"]) ],
			'type' => ['Type', Form::text("type", old("type"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Survey::survey_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		// dd($request);

		$this->validate($request, [
			'id_kps' => 'required',
			'type' => 'required',
			// 'metode' => 'required',
			'nama' => 'required',
		]);

		$survey = new Survey();
		$survey->id_kps = $request->input("id_kps");
		$survey->type = $request->input("type");
		$survey->nama_survey = $request->input("nama");
		
		$survey->created_by = Auth::id();
		$survey->save();

		if($request->input('type') == 'marker')
		{
			return redirect()->route('survey.marker.show', $survey->id);
		}
		else if($request->input('type') == 'polygon')
		{
			if($request->input('metode') == 'titik')
			{
				return redirect()->route('survey.show', $survey->id);
			}
			else if($request->input('metode') == 'tracking')
			{
				return redirect()->route('survey.tracking.show', $survey->id);
			}
		}


		$text = 'membuat '.$this->title; //' baru '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->back()->with('message_success', 'Survey berhasil ditambahkan!');
	}

	public function tracking(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->get();
		// dd($data['koord_survey']);
		$data['kps'] = Kps::find($survey->id_kps);

		return view('Survey::survey_tracking', array_merge($data, ['title' => $this->title]));
	}

	public function marker(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->get();

		return view('Survey::survey_marker', array_merge($data, ['title' => $this->title]));
	}

	public function form_survey(Request $request, Kups $kups)
	{
		return view('Survey::form_survey');
	}

	public function show(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->orderBy('index')->get();
		$data['kps']	= Kps::find($survey->id_kps);

		// dd($data['koord_survey']);


		$text = 'melihat detail '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return view('Survey::survey_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;

		$ref_kups = Kups::all()->pluck('nama_kups','id');
		
		$data['forms'] = array(
			'id_kups' => ['Kups', Form::select("id_kups", $ref_kups, null, ["class" => "form-control select2"]) ],
			'type' => ['Type', Form::text("type", $survey->type, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "type"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return view('Survey::survey_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_kups' => 'required',
			'type' => 'required',
			
		]);
		
		$survey = Survey::find($id);
		$survey->id_kups = $request->input("id_kups");
		$survey->type = $request->input("type");
		
		$survey->updated_by = Auth::id();
		$survey->save();


		$text = 'mengedit '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->route('survey.index')->with('message_success', 'Survey berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$survey = Survey::find($id);
		$survey->deleted_by = Auth::id();
		$survey->save();
		$survey->delete();

		$text = 'menghapus '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return back()->with('message_success', 'Survey berhasil dihapus!');
	}

}
