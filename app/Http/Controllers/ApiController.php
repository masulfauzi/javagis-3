<?php
namespace App\Http\Controllers;

use App\Modules\KoordSurvey\Models\KoordSurvey;
use App\Modules\Kps\Models\Kps;
use App\Modules\Survey\Models\Survey;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_kps(Request $request)
    {
        $kps = Kps::select('kps.nama_kps', 'kps.id', 'kps.koord_x', 'kps.koord_y', 'desa.nama_desa', 'kps.id_desa', 'kps.no_sk', 'kps.tgl_sk')
            ->join('desa', 'kps.id_desa', '=', 'desa.id')
            ->paginate(10)->withQueryString();

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data kps",
            "data"    => $kps,
        ], 200);
    }

    public function detail_kps(Request $request, Kps $kps)
    {
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil detail kps",
            "data"    => $kps,
        ], 200);
    }

    public function start_survei(Request $request)
    {
        // Implement your survei logic here
        // For example, store the survei data to a database
        $survey = new Survey();

        $survey->status     = 0;
        $survey->id_kps     = $request->input('id_kps');
        $survey->created_at = $request->input('started_at');
        $survey->save();

        return response()->json([
            "success"   => true,
            "survei_id" => $survey->id,
            "message"   => "Berhasil mulai survei",
        ], 200);
    }

    public function update_survei(Request $request)
    {
        // Implement your survei logic here
        // For example, update the survei data in a database

        $surveis  = json_decode($request->input('geoJson'));
        $features = $surveis->features;

        $no     = 1;
        $id_kps = '';
        foreach ($features as $feature) {
            $tipe = $feature->geometry->type;

            if ($no == 1) {
                $survey = Survey::find($request->input('surveiId'));
                $id_kps = $survey->id_kps;

                $survey->status     = 1;
                $survey->tipe       = strtolower($tipe);
                $survey->updated_at = $request->input('endedAt');
                $survey->save();
            } else {
                $survey             = new Survey();
                $survey->id_kps     = $id_kps;
                $survey->tipe       = strtolower($tipe);
                $survey->status     = 1;
                $survey->created_at = $request->input('endedAt');
                $survey->save();
            }

            // print_r($feature->properties->name);
            // print_r($feature->geometry->type);
            // print_r($feature->geometry->coordinates);
            $koordinat = $feature->geometry->coordinates;

            if ($tipe == 'Point') {
                $koord_survey = new KoordSurvey();

                $koord_survey->id_survey = $survey->id;
                $koord_survey->koord_x   = $koordinat[0];
                $koord_survey->koord_y   = $koordinat[1];
                $koord_survey->index     = 1;

                $koord_survey->save();

                // $x = $koordinat[0];
                // $y = $koordinat[1];
                // echo "X - " . $x;
                // echo "<br>";
                // echo "Y - " . $y;
                // echo "<br>";
            } else if ($tipe == 'LineString') {
                foreach ($koordinat as $titik) {

                    $koord_survey = new KoordSurvey();

                    $koord_survey->id_survey = $survey->id;
                    $koord_survey->koord_x   = $titik[0];
                    $koord_survey->koord_y   = $titik[1];
                    $koord_survey->index     = 1;

                    $koord_survey->save();

                    // print_r($titik[0]);
                    // echo "<br>";
                    // echo "X - " . $titik[0];
                    // echo "<br>";
                    // echo "Y - " . $titik[1];
                    // echo "<br>";
                }
                // die();
            } else if ($tipe == 'Polygon') {
                foreach ($koordinat[0] as $titik) {
                    $koord_survey = new KoordSurvey();

                    $koord_survey->id_survey = $survey->id;
                    $koord_survey->koord_x   = $titik[0];
                    $koord_survey->koord_y   = $titik[1];
                    $koord_survey->index     = 1;

                    $koord_survey->save();
                    // print_r($titik);
                    // echo "<br>";
                    // echo "X - " . $titik[0];
                    // echo "<br>";
                    // echo "Y - " . $titik[1];
                    // echo "<br>";
                }
                // die();
            }

            $no++;
        }

        // return $features;

        // $survey = Survey::find($request->input('surveiId'));

        // $survey->status     = 1;
        // $survey->geojson    = $request->input('geoJson');
        // $survey->updated_at = $request->input('endedAt');
        // $survey->save();

        // $tipe = $request->input('tipe');
        // $geojson = $request->input('geoJson');

        // if($tipe == 'polygon')
        // {
        //     $koordinat = $geojson['geometry']['coordinates'][0];
        // }
        // else if($tipe == 'polyline')
        // {
        //     $koordinat = $geojson['geometry']['coordinates'][0];
        // }
        // else if($tipe == 'marker')
        // {
        //     $koordinat = $geojson['geometry']['coordinates'][0];
        // }

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengupdate survei",
        ], 200);
    }
}
