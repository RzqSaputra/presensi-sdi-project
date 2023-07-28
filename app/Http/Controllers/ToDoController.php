<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;

class ToDoController extends Controller
{
    public function index()
    {
        $title = 'Task';
        $todo = ToDo::orderBy('id', 'desc')->get();
        return view('pegawai.todo', compact('todo','title'));
    }

    public function create()
    {
        $statuses = [
            [
                'label' => 'Todo',
                'value' => 'Todo',
            ],
            [
                'label' => 'Done',
                'value' => 'Done',
            ]
        ];
        $title = 'Task';
        return view('pegawai.create', compact('statuses','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $todo = new ToDo();
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->status = $request->status;
        $todo->save();
        return redirect()->route('index');
    }

    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        $statuses = [
            [
                'label' => 'Todo',
                'value' => 'Todo',
            ],
            [
                'label' => 'Done',
                'value' => 'Done',
            ]
        ];
        return view('edit', compact('statuses', 'todo'));
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $request->validate([
            'title' => 'required'
        ]);

        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->status = $request->status;
        $todo->save();
        return redirect()->route('index');
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return redirect()->route('index');
    }
}
