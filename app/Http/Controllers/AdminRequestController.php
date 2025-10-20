<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;

class AdminRequestController extends Controller
{
    // Listar todas las solicitudes
    public function index()
    {
        $requests = Request::with('user')->get();

        return Inertia::render('admin/DashboardAdmin', [
            'requests' => $requests,
        ]);
    }

    // Cambiar el estado de una solicitud
    public function updateStatus(HttpRequest $request, $id)
    {
        $req = Request::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:Pendiente,Aprobada,Rechazada',
        ]);

        $req->update($data);

        return response()->json($req); // para consumo desde Vue
    }
}
