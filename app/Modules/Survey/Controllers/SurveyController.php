<?php
namespace App\Modules\Survey\Controllers;

use App\Helpers\Format;
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
use Codedge\Fpdf\Fpdf\Fpdf;

use function PHPUnit\Framework\returnValue;

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

		$pdf = new Fpdf;

		$data['pdf'] = $pdf;
		$data['survey'] = $survey;
		$data['nama'] = Auth::user()->name;
		$data['tgl_pembuatan'] = Format::tanggal($survey->created_at, false, false);

		



		// dd(Auth::user()->name);


		return view('Survey::survey_print', $data);
		// $pdf = Pdf::loadView('Survey::survey_print', $data)->setPaper('a4', 'landscape');
    	// return $pdf->download('hasil-survey.pdf');
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
			'metode' => 'required',
			'nama' => 'required',
		]);

		$survey = new Survey();
		$survey->id_kps = $request->input("id_kps");
		$survey->type = $request->input("type");
		$survey->nama_survey = $request->input("nama");
		$survey->keterangan = $request->input("keterangan");
		$survey->metode = $request->input('metode');
		
		$survey->created_by = Auth::id();
		$survey->save();

		if($request->input('type') == 'marker')
		{
			if($request->input('metode') == 'aktual')
			{
				return redirect()->route('survey.marker.start.show', $survey->id);
			}
			else if($request->input('metode') == 'manual')
			{
				return redirect()->route('survey.marker.manual.show', $survey->id);
			}

		}
		else if($request->input('type') == 'polygon')
		{
			if($request->input('metode') == 'titik')
			{
				return redirect()->route('survey.polygon.start.show', $survey->id);
			}
			else if($request->input('metode') == 'tracking')
			{
				return redirect()->route('survey.tracking.show', $survey->id);
			}
		}
		else if($request->input('type') == 'polyline')
		{
			if($request->input('metode') == 'titik')
            {
                return redirect()->route('survey.polyline.start.show', $survey->id);
            }
            else if($request->input('metode') == 'tracking')
            {
                return redirect()->route('survey.polyline.tracking.show', $survey->id);
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
	
	public function polyline_tracking(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->get();
		// dd($data['koord_survey']);
		$data['kps'] = Kps::find($survey->id_kps);

		return view('Survey::survey_polyline_tracking', array_merge($data, ['title' => $this->title]));
	}

	public function marker(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->get();

		return view('Survey::survey_marker', array_merge($data, ['title' => $this->title]));
	}
	
	public function marker_manual(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->get();

		return view('Survey::survey_marker_manual', array_merge($data, ['title' => $this->title]));
	}

	public function marker_start(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->get();

		return view('Survey::survey_marker_start', array_merge($data, ['title' => $this->title]));
	}

	public function polygon_start(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->orderby('index')->get();
		$data['koord_survey_pertama'] = KoordSurvey::whereIdSurvey($survey->id)->orderby('index')->first();

		return view('Survey::survey_polygon_start', array_merge($data, ['title' => $this->title]));
	}
	
	public function polyline_start(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->orderby('index')->get();
		$data['koord_survey_pertama'] = KoordSurvey::whereIdSurvey($survey->id)->orderby('index')->first();

		return view('Survey::survey_polyline_start', array_merge($data, ['title' => $this->title]));
	}
	
	public function polygon(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->orderby('index')->get();
		


		return view('Survey::survey_polygon', array_merge($data, ['title' => $this->title]));
	}
	
	public function polyline(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;
		$data['kps'] = Kps::find($survey->id_kps);
		$data['koord_survey'] = KoordSurvey::whereIdSurvey($survey->id)->orderby('index')->get();

		return view('Survey::survey_polyline', array_merge($data, ['title' => $this->title]));
	}

	public function simpan_luas(Request $request)
	{
		$survey = Survey::find($request->input('id_survey'));

		$survey->luas = $request->input('luas');
		$survey->save();
	}

	public function form_survey(Request $request, Kups $kups)
	{
		return view('Survey::form_survey');
	}
	
	public function form_line(Request $request, Kups $kups)
	{
		return view('Survey::form_line');
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

		// $ref_kups = Kups::all()->pluck('nama_kups','id');
		
		$data['forms'] = array(
			'id_kps' => ['', Form::hidden("id_kps", $survey->id_kps, ["class" => "form-control"]) ],
			'nama_survey' => ['Nama Survey', Form::text("nama_survey", $survey->nama_survey, ["class" => "form-control","placeholder" => ""]) ],
			'luas' => ['Luas', Form::text("luas", $survey->luas .' M Persegi', ["class" => "form-control","placeholder" => "", "disabled" => "disabled", "id" => "type"]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", $survey->keterangan, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "type"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return view('Survey::survey_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_survey' => 'required',
			// 'type' => 'required',
			
		]);
		
		$survey = Survey::find($id);
		$survey->keterangan = $request->input("keterangan");
		$survey->nama_survey = $request->input("nama_survey");
		
		$survey->updated_by = Auth::id();
		$survey->save();


		$text = 'mengedit '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->back()->with('message_success', 'Survey berhasil diubah!');
	}

	public function form_polygon_manual(Request $request)
	{
		return view('Survey::survey_polygon_manual');
	}
	
	public function form_polyline_manual(Request $request)
	{
		return view('Survey::survey_polyline_manual');
	}

	public function simpan_polygon_manual(Request $request)
	{
		$koordinat = json_decode($request->geojson, true);

		$arr_koordinat = $koordinat['geometry']['coordinates'][0];

		// dd($koordinat['geometry']['coordinates'][0]);

		$survey = new Survey();
		$survey->id_kps = $request->input("id_kps");
		$survey->type = $request->input("type");
		$survey->nama_survey = $request->input("nama");
		$survey->keterangan = $request->input("keterangan");
		$survey->luas = $request->input("luas");
		
		$survey->created_by = Auth::id();
		$survey->save();

		$i = 1;
		foreach($arr_koordinat as $item)
		{
			$koord_x = $item[1];
			// dd($koord_x);
			$koord_y = $item[0];

			$koord_survey = new KoordSurvey();
            $koord_survey->id_survey = $survey->id;
            $koord_survey->index = $i;
            $koord_survey->koord_x = $koord_x;
            $koord_survey->koord_y = $koord_y;
            $koord_survey->save();

			$i++;
		}

		$text = 'mengedit '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->back()->with('message_success', 'Survey berhasil dibuat!');
	}
	
	public function simpan_polyline_manual(Request $request)
	{
		$koordinat = json_decode($request->geojson, true);

		// dd($koordinat);

		$arr_koordinat = $koordinat['geometry']['coordinates'];

		// dd($koordinat['geometry']['coordinates']);

		$survey = new Survey();
		$survey->id_kps = $request->input("id_kps");
		$survey->type = $request->input("type");
		$survey->nama_survey = $request->input("nama");
		$survey->keterangan = $request->input("keterangan");
		$survey->luas = $request->input("luas");
		
		$survey->created_by = Auth::id();
		$survey->save();

		$i = 1;
		foreach($arr_koordinat as $item)
		{
			$koord_x = $item[1];
			// dd($koord_x);
			$koord_y = $item[0];

			$koord_survey = new KoordSurvey();
            $koord_survey->id_survey = $survey->id;
            $koord_survey->index = $i;
            $koord_survey->koord_x = $koord_x;
            $koord_survey->koord_y = $koord_y;
            $koord_survey->save();

			$i++;
		}

		$text = 'menambah line manual '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->back()->with('message_success', 'Survey berhasil dibuat!');
	}

	public function destroy(Request $request, $id)
	{
		$survey = Survey::find($id);

		$id_kps = $survey->id_kps;

		$survey->deleted_by = Auth::id();
		$survey->save();
		$survey->delete();

		$text = 'menghapus '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->route('kps.survey.index', $id_kps)->with('message_success', 'Survey berhasil dihapus!');
	}

}
