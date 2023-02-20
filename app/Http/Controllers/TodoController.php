<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;



class TodoController extends Controller
{
    //Display Post using pagination
    public function show()
    {
        $todo = Todo::paginate(5);
        return view('welcome', compact('todo'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    //Post List
    public function store(Request $request)
    {
        $todo = new Todo;

        $todo->title = $request->title;
        $todo->priority = $request->priority;

        $todo->save();

        return response()->json(["status" => "Akunamatata"], 201);
    }

   //Delete List by id
   public function destroy($postId)
    {
        $todo = Todo::find($postId);
        $todo->delete();

        return response()->json(["status" => "Item deleted!"], 200);       
    }

    //Update entry
    public function update(Request $request, $postId)
    {
        /*
        $todo = Todo::find($postId);

        if($request->has('title')){
           $todo->title = $request->title;
        }
        if($request->has('priority')){
            $todo->priority = $request->priority;
         }
        */

        // Find the record to be updated
        $todo = Todo::findorFail($postId);

        // Loop through the request data and update the fields as needed
        foreach ($request->all() as $key => $value) {
            // Only update fields that are not null or empty
            if (!empty($value)) {
                $todo->{$key} = $value;
            }
        }

     //   \Log::info(json_encode( $data));
        $todo->save();
   
        return response()->json(["result" => "Record Updated"], 201);       
    }

}
