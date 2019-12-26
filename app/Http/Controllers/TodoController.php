<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $todo = Todo::create([
            'userId' => $request->user()->id,
            'status' => 'planned',
            'title' => $request->title,
            'elapsed' => 0,
        ]);

        return new TodoResource($todo);
    }

    public function getAll(Request $request)
    {
        return TodoResource::collection(Todo::query()->where('userId', $request->user()->id)->get());
    }

    public function get(Request $request, Todo $todo)
    {
        if ($request->user()->id !== $todo->userId) {

            return response()->json(['error' => 'You can only see your own todos.'], 403);

        }
        return new TodoResource($todo);
    }

    public function update(Request $request, Todo $todo)

    {

        // check if currently authenticated user is the owner of the book

        if ($request->user()->id !== $todo->userId) {

            return response()->json(['error' => 'You can only edit your own books.'], 403);

        }



        $todo->update($request->only(['title','author', 'description']));



        return new TodoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Todo $todo)
    {
        if($request->user()->id != $todo->user_id){
            return response()->json(['error' => 'You can only delete your own books.'], 403);
        }
        try {
            $todo->delete();
        } catch (\Exception $e) {
        }
        return response()->json(null,204);
    }
}
