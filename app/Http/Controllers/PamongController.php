<?php

namespace App\Http\Controllers;

use App\Imports\PamongImport;
use App\Models\Dosen;
use App\Models\Lokasi;
use App\Models\MitraTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class PamongController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dpls = MitraTransaction::all();
        return view('admin.superadmin.pamong.pamong')->with('data', $dpls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = Lokasi::all();
        $dosen = Dosen::all();

        $data = [
            'lokasi' => $lokasi,
            'dosen' => $dosen
        ];
        return view('admin.superadmin.pamong.add')->with('data', $data);;
    }
    public function import()
    {
        Excel::import(new PamongImport, request()->file('file'));

        return back()->with('success', 'Data imported successfully!');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request...
        $dpl = MitraTransaction::create($request->only(['dosen_id']));

        // Attach multiple locations
        $dpl->lokasis()->attach($request->input('lokasi_id'));

        return redirect()->route('admin.dpl')->with('success', 'DPL created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DPL  $dpl
     * @return \Illuminate\Http\Response
     */
    public function show(DPL $dpl)
    {
        return view('dpls.show', compact('dpl'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DPL  $dpl
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lokasi = Lokasi::all();
        $dosen = Dosen::all();

        $data = [
            'lokasi' => $lokasi,
            'dosen' => $dosen
        ];
        return view('admin.superadmin.pamong.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DPL  $dpl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DPL $dpl)
    {
        // Validate the request...

        $dpl->update($request->all());

        return redirect()->route('dpls.index')
            ->with('success', 'DPL updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DPL  $dpl
     * @return \Illuminate\Http\Response
     */
    public function destroy(DPL $dpl)
    {
        $dpl->delete();

        return redirect()->route('dpls.index')
            ->with('success', 'DPL deleted successfully');
    }
}
