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
        return $this->successResponse($user->todos, 'Todolar listelendi', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        $user = $request->user();
        $todo = $user->todos()->create($request->only(['title', 'description']));
        return $this->successResponse($todo, 'Todo oluşturuldu', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        if($todo->user_id !== $request->user()->id) {
            return $this->errorResponse('Bu todoya erişim yetkiniz yok', 403);
        }

        return $this->successResponse($todo, 'Todo detayı getirildi', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        if($todo->user_id !== $request->user()->id) {
            return $this->errorResponse('Bu todoya erişim yetkiniz yok', 403);
        }

        $todo->update($request->only(['title', 'description']));
        return $this->successResponse($todo, 'Todo güncellendi', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        if($todo->user_id !== $request->user()->id) {
            return $this->errorResponse('Bu todoya erişim yetkiniz yok', 403);
        }

        $todo->delete();
        return $this->successResponse(null, 'Todo silindi', 200);
    }

    public function toggle(Request $request, string $id)
    {
        $todo = Todo::findOrFail($id);

        if($todo->user_id !== $request->user()->id) {
            return $this->errorResponse('Bu todoya erişim yetkiniz yok', 403);
        }
        $todo->is_completed = !$todo->is_completed;
        $todo->save();
        $message = $todo->is_completed ? 'Todo tamamlandı olarak işaretlendi' : 'Todo tamamlanmadı olarak işaretlendi';
        return $this->successResponse($todo, $message, 200);
    }
}
