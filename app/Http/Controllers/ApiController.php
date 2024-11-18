<?php

namespace App\Http\Controllers;

use App\Modules\Kps\Models\Kps;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_kps(Request $request)
    {
        $kps = Kps::select('kps.nama_kps', 'kps.id', 'kps.koord_x', 'koord_y')->paginate(10)->withQueryString();

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data kps",
            "data" => $kps
        ], 200);
    }

    public function detail_kps(Request $request, Kps $kps)
    {
        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil detail kps",
            "data" => $kps
        ], 200);
    }
}
