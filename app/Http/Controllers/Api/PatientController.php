<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    // GET /api/patients
    public function index()
    {
        return response()->json(
            Patient::where('active', true)->get(),
            Response::HTTP_OK
        );
    }

    // GET /api/patients/{id}
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient || !$patient->active) {
            return response()->json([
                'message' => 'Paciente no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($patient, Response::HTTP_OK);
    }

    // POST /api/patients
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required|string|max:50',
        ]);

        $patient = Patient::create($data);

        return response()->json($patient, Response::HTTP_CREATED);
    }

    // PUT /api/patients/{id}
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Paciente no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $data = $request->validate([
            'full_name' => 'sometimes|string|max:255',
            'email'     => 'sometimes|email',
            'phone'     => 'sometimes|string|max:50',
            'active'    => 'sometimes|boolean',
        ]);

        $patient->update($data);

        return response()->json($patient, Response::HTTP_OK);
    }

    // DELETE /api/patients/{id}  (borrado lógico)
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'message' => 'Paciente no encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        $patient->active = false;
        $patient->delete(); // soft delete

        return response()->json([
            'message' => 'Paciente eliminado lógicamente'
        ], Response::HTTP_OK);
    }
}
