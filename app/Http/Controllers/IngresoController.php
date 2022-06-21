<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingresos = Ingreso::Where('user_id', auth()->user()->id)->paginate(10);
		return view('ingresos.index',compact('ingresos'));
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
		$cantidad = number_format($request->cantidad, 2, '.', '');

        $ingreso = new Ingreso;
		$ingreso->cantidad = $cantidad;
		$ingreso->proviene = $request->proviene;
		$ingreso->fecha_ingresos = $request->fecha_ingreso;
		$ingreso->user_id = auth()->user()->id;
		$ingreso->save();

		return redirect('ingresos')->with('mensaje', 'Ingreso registrado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function show(Ingreso $ingreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingreso $ingreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$cantidad = number_format($request->cantidad2, 2, '.', '');

        $ingreso = Ingreso::findOrFail($request->id2);



		$ingreso->cantidad = $cantidad;
		$ingreso->proviene = $request->proviene2;
		$ingreso->fecha_ingresos = $request->fecha_ingreso2;
		$ingreso->save();

		return redirect('ingresos')->with('mensaje', 'Ingreso editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingreso  $ingreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
		if(Ingreso::destroy($request->id)){
			return "success";
		}else{
			return "denied";
		}
    }
}
