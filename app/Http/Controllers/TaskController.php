<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use AuthTrait;
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index($id)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Board::findOrfail($id)->tasks
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
            $request->validate(
                [
                    'title' => 'required',
                    'user_id' => 'required',
                    'status' => 'required',
                    'board_id' => 'required',
                ]
            );

            $task = Task::create($request->post());
            return response()->json([
                'success' => true,
                'data' => $task
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
            $task = Task::findOrfail($id);
            if ($task->board->user->id != $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usted no tiene permisos para borrar esta tarea'
                ], $this->badRequestCode);
            }

            $task->delete();
            return response()->json([
                'success' => true,
                'message' => 'Tarea eliminada exitosamente'
            ], $this->createdCode);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], $this->badRequestCode);
        }
    }
}
