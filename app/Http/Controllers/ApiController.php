<?php
namespace App\Http\Controllers;

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

        $survey = Survey::find($request->input('surveiId'));

        $survey->status     = 1;
        $survey->geojson    = $request->input('geoJson');
        $survey->updated_at = $request->input('endedAt');
        $survey->save();

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
