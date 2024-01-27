<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use Illuminate\Http\Request;
use Exception;

class ApiController extends Controller
{
    public function getModuleApi(Request $request)
    {
        try {
            $dbStadiums = Stadium::with(['advertisingSections' => function ($query) use ($request) {
                $query->select('advertising_sections.*', 'file as file_path');
                if ($request->has('advertising_section_id')) {
                    // Conditionally add where clause based on ad_sec_id in the request
                    $query->where('id', $request->advertising_section_id);
                }
            }])
                ->select('stadiums.*', 'stadiums.file as file_path');

            if ($request->stadium_id) {
                $dbStadiums->where('stadiums.id', $request->stadium_id);
            }

            $stadiums = $dbStadiums->get();
            return response()->json([
                'code' => 200,
                'message' => 'Stadium data fetched successfully.',
                'data' => $stadiums
            ]);

        } catch (Exception $e) {
//            dd($e->getMessage(), $e->getTraceAsString());
            return response()->json([
                'code' => 500,
                'message' => 'Something went wrong. Please try again after some time.',
            ]);
        }
    }
}
