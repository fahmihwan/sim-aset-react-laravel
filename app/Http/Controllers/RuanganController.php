<?php

namespace App\Http\Controllers;

use App\Http\Resources\RuanganCollection;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Ruangan::paginate(5);
        return  Inertia::render('Master_data/Ruangan/Index', [
            'ruangans' => Ruangan::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  Inertia::render('Master_data/Ruangan/Create');
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
            'ruangan' => 'required'
        ]);

        Ruangan::create([
            'ruangan' => $request->ruangan
        ]);

        return redirect('/ruangan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function show(Ruangan $ruangan)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return  Inertia::render('Master_data/Ruangan/Edit', [
            'data' => Ruangan::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ruangan' => 'required'
        ]);
        Ruangan::where('id', $id)->update([
            'ruangan' => $request->ruangan
        ]);
        return redirect('/ruangan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ruangan  $ruangan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ruangan::destroy($id);
        return redirect()->back();
    }
}
