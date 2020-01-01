<?php

namespace WayneCook\LaraFilter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;


class FilterController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return User::LaraFilter();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validator::make($request->params, [
        //     'name' => ['bail','required', 'string', 'max:255'],
        //     'email' => ['bail','required', 'string', 'email', 'max:255'],
        //     'phone' => ['bail','required', 'string', 'max:255'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],

        // ])->validate();


        // return User::create([
        //     'name' => $request->params['name'],
        //     'email' => $request->params['email'],
        //     'phone' => $request->params['phone'],
        //     'password' => Hash::make($request->params['password']),
        // ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( User $user )
    {
        // return $user->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        // Validator::make($request->params, [
        //     'name' => ['bail','required', 'string', 'max:255'],
        //     'email' => ['bail','required', 'string', 'email', 'max:255'],
        //     'phone' => ['bail','required', 'string', 'max:255'],

        // ])->validate();


        // $user->fill($request->params)->save();

        // return $user;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // $user->delete();
        // return $user;
    }

    public function exportExcel()
    {
        // return User::exportExcel();
    }

    public function deleteSelected()
    {

        // $ids_to_delete = array_map(function($user){ return json_decode($user)->id; }, request()->all());
        // return User::whereIn('id', $ids_to_delete)->delete();

    }

    public function byCountry()
    {

        // return User::all()->groupBy('country');
    }



}
