<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Offices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    public function index()
    {
        try {
            $offices = Offices::orderBy('id', 'desc')->get();
            return response()->json(['success' => true, 'data' => $offices]);
        } catch (\Throwable $th) {
            Log::error('Failed to fetch data office: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'office_name' => 'required',
            'office_lat' => 'required',
            'office_long' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }

        try {
            $offices = Offices::create([
                'office_name' => $request->office_name,
                'office_phone'   => $request->office_phone,
                'office_address' => $request->office_address,
                'office_lat' => $request->office_lat,
                'office_long' => $request->office_long,
                'is_active' => $request->is_active,
            ]);
            return response()->json(['success' => true, 'message' => 'Offices added success', 'data' => $offices], 201);
        } catch (\Throwable $th) {
            Log::error('Failed insert : ' . $th->getMessage());
            return response()->json(['success' => false, 'message' =>  $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $office = Offices::findOrFail($id);
            return response()->json(['success' => true, 'message' => 'Show Data Success', 'data' => $office]);
        } catch (\Throwable $th) {
            Log::error('Failed Show : ' . $th->getMessage());
            return response()->json(['success' => false, 'message' =>  $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'office_name' => 'required',
            'office_lat'   => 'required',
            'office_long'   => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors(),
            ], 422);
        }

        try {
            $data = [
                'office_name' => $request->office_name,
                'office_phone'   => $request->office_phone,
                'office_address' => $request->office_address,
                'office_lat' => $request->office_lat,
                'office_long' => $request->office_long,
                'is_active' => $request->is_active,
            ];
            $offices = Offices::findOrFail($id);
            $offices->update($data);
            return response()->json(['success' => true, 'message' => 'Offices update success', 'data' => $offices]);
        } catch (\Throwable $th) {
            Log::error('Failed update : ' . $th->getMessage());
            return response()->json(['success' => false, 'message' =>  $th->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $office = Offices::find($id)->delete();
            return response()->json(['message' => 'Office delete success']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    // method: delete
    // endpoint :  http://localhost:8000/employee/1
}
