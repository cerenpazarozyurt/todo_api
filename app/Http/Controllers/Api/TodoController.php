<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Models\User;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return $user->todos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $user = $request->user();
        $todo = $user->todos()->create($request->only(['title', 'description']));
        return response()->json($todo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        if($todo->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Bu todoya erişim yetkiniz yok'],403);
        }

        return response()->json($todo, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        if($todo->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Bu todoya erişim yetkiniz yok'],403);
        }

        $todo->update($request->only(['title', 'description']));
        return response()->json($todo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        if($todo->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Bu todoya erişim yetkiniz yok'],403);
        }

        $todo->delete();
        return response()->json(["message" => "Todo silindi."], 200);
    }
}
