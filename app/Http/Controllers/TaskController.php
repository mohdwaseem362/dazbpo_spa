<?php

namespace App\Http\Controllers;

use App\Task;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    


    public function index()
    {
        // $userid = Auth::user()->id;
        // $tasks = Task::where('user_id',$userid)->get();
        $tasks =Task::paginate(10);  
        // $tasks =$tasks->toArray();
        // echo "<pre>";
        // print_r($tasks); exit;
        return response()->json([
            'tasks'    => $tasks,
        ], 200);
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        // $a = ($request->checkedNames);
        // $df =explode(',', $a);
        // $explode_id = array_map('intval', explode(',', $request->checkedNames));
        // // $explode_id = json_decode($request->data, true);

        // echo "<pre>";
        // print_r($df);
        // echo "</pre>";

        //  exit;
      
        $this->validate($request, [
            'name'        => 'required|max:10',
            'description' => 'required',
            'date'        => 'required',
            'checkedNames'=> 'required',
            'category'    => 'required',
            'selected'    => 'required',
        ]);

        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $path = $request->file->move(public_path('upload'), $fileName);


        $task = Task::create([
            'name'        => request('name'),
            'description' => request('description'),
            'started_date'=> request('date'),
            'checked'     => request('checkedNames'),
            'image'       => $fileName,
            'category'    => request('category'),
            'option'      => request('selected'),
            'user_id'     => Auth::user()->id
        ]);

        return response()->json([
            'task'    => $task,
            'message' => 'Success'
        ], 200);
    }

   
    public function show(Task $task)
    {
        //
    }

   
    public function edit(Task $task)
    {
        //
    }

   
    public function update(Request $request, Task $task)
    {
        

        $this->validate($request, [
            'name'        => 'required|max:255',
            'description' => 'required',
            'date'        => 'required',
            'category'    => 'required',
            'option'    => 'required',
        ]);

        $task->name         = request('name');
        $task->description  = request('description');
        $task->started_date = request('date');
        $task->category     = request('category');
        $task->option       = request('option');
        $task->save();

        return response()->json([
            'message' => 'Task updated successfully!'
        ], 200);
    }

   
    public function destroy(Task $task)
    {
       
        $task->delete();
        return response()->json([
            'message' => 'Task deleted successfully!'
        ], 200);
    }
}
