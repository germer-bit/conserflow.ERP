<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function index() {
        $user = Auth::user();
        return response()->json($user->requests);
    }

    public function store(HttpRequest $request) {
        $request->validate([
            'type' => 'required|string',
            'description' => 'required|string',
        ]);

        $newRequest = Request::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return response()->json($newRequest, 201);
    }

    public function update(HttpRequest $request, $id) {
        $req = Request::findOrFail($id);

        if ($req->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        if ($req->status !== 'Pendiente') {
            return response()->json(['error' => 'Solo se pueden editar solicitudes pendientes'], 403);
        }

        $req->update($request->only('type', 'description'));

        return response()->json($req);
    }

    public function destroy($id) {
        $req = Request::findOrFail($id);

        if ($req->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        if ($req->status !== 'Pendiente') {
            return response()->json(['error' => 'Solo se pueden eliminar solicitudes pendientes'], 403);
        }

        $req->delete();
        return response()->json(['message' => 'Solicitud eliminada']);
    }
}
