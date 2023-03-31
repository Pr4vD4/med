<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpecialityResource;
use App\Http\Resources\UserResource;
use App\Models\Specialities;
use App\Models\User;
use App\Models\UsersSpecialities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(SpecialityResource::collection(Specialities::all()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:specialities'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 444);
        }

        $speciality = new Specialities();
        $speciality->name = $request->name;

        $speciality->save();

        return response()->json([
            'message' => 'success',
            'data' => [
                'speciality' => new SpecialityResource($speciality),
            ]
        ]);

    }

    public function doctors(int $id)
    {
        $doctors = UsersSpecialities::query()->where('specialities_id', $id)->get();


        return response()->json([
            'doctors' => $doctors
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Specialities $specialities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialities $specialities)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialities $specialities)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialities $specialities)
    {
        //
    }
}
