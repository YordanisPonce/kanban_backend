<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    use AuthTrait;
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }


    public function index(Request $request)
    {
        try {
            $boards = $request->user()->boards()->withCount('users')->get();

            return response()->json([
                'success' => true,
                'data' => $boards
            ], $this->successCode);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $this->badRequestCode);
        }
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required',
                'subtitle' => 'required',
            ]);

            $request->merge(['user_id' => $request->user()->id]);

            $board = Board::create($request->post());

            return response()->json([
                'success' => true,
                'data' => $board
            ], $this->createdCode);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $this->badRequestCode);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $board = Board::findOrfail($id);
            if ($board->user->id != $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usted no tiene permisos para borrar esta tarea'
                ], $this->badRequestCode);
            }
            $board->delete();
            return response()->json([
                'success' => true,
                'message' => 'Tablero eliminado exitosamente'
            ], $this->successCode);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $this->badRequestCode);
        }
    }
}
