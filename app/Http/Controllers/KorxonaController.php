<?php

namespace App\Http\Controllers;

use App\Models\Korxona;
use Illuminate\Http\Request;

class KorxonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $korxona= Korxona::with('qarzdorlar')->get();

        return view('korxona.index',compact('korxona'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'korxona_name' => 'required|string|max:255',
        ]);

        Korxona::create([
            'name' => $request->korxona_name,
        ]);

        return back()->with(['success' => 'Korxona muvaffaqiyatli qo\'shildi']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Korxona  $korxona
     * @return \Illuminate\Http\Response
     */
    public function show(Korxona $korxona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Korxona  $korxona
     * @return \Illuminate\Http\Response
     */
    public function edit(Korxona $korxona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Korxona  $korxona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'korxona_name' => 'required|string|max:255',
        ]);

        $korxona = Korxona::findOrFail($id);
        $korxona->update([
            'name' => $request->korxona_name,
        ]);

        return redirect()->route('korxona.index')->with('success', 'Korxona muvaffaqiyatli yangilandi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Korxona  $korxona
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $korxona = Korxona::findOrFail($id);
        $korxona->delete();

        return redirect()->route('korxona.index')->with('success', 'Korxona muvaffaqiyatli o\'chirildi');
    }






}
