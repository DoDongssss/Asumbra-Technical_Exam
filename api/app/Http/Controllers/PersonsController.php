<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonsResource;
use App\Models\Persons;
use Illuminate\Http\Request;

class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $persons = Persons::latest('updated_at')->get();

        return PersonsResource::collection($persons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Firstname' => ['required', 'string'],
            'Lastname' => ['required', 'string'],
            'Middle_Initial' => ['required', 'string'],
            'Birthday' => ['required'],
            'Gender' => ['required'],
            'Date_registered' => ['required']
        ]);

        Persons::create($request->all());

        return response()->json([
            'message' => 'success',
            'data' => $request->all()
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persons $persons, $id)
    {
        $request->validate([
            'Firstname' => ['required', 'string'],
            'Lastname' => ['required', 'string'],
            'Middle_Initial' => ['required', 'string'],
            'Birthday' => ['required'],
            'Gender' => ['required'],
            'Date_registered' => ['required']
        ]);

        $person = Persons::findOrFail($id);

        if (
            $person->Firstname == $request->Firstname &&
            $person->Lastname == $request->Lastname &&
            $person->Middle_Initial == $request->Middle_Initial &&
            $person->Birthday == $request->Birthday &&
            $person->Gender == $request->Gender &&
            $person->Date_registered == $request->Date_registered
        ) {
            return response()->json(['message' => 'Nothing has changed'], 200);
        }

        $person->update($request->all());


        return response()->json([
            'message' => 'Successfully Updated',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persons $persons, $id)
    {
        $persons = Persons::findOrFail($id);

        $persons->delete();

        return response()->json([
            'message' => 'Successfully Deleted',
        ], 200);
    }
}
