<?php

namespace App\Http\Controllers;

use App\Tareas;
use Illuminate\Http\Request;

class TareasApiController extends Controller
{
     public function __construct()
    {
        $this -> middleware('auth:api');
        //$this -> middleware('userapi');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Solicitud de Información
        $tareas = Tareas::all();

        // Envío de respuesta
        return $tareas;
    }

    /**
     * Display a list of items depending on the search criteria.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Search terms
        $filtro = $request -> input('filtro');
        $fecha = $request -> input('fecha');

        // Retrieval of the data according to the search terms
        if($filtro == "pendientes" || $filtro == "Pendientes" || $filtro == "pendiente" || $filtro == "Pendiente")
        {
            $tareas = Tareas::where([
                ['id_user','=', $request->user()->id],
                ['estado','=', 'Pendiente'],
                ['fecha', 'LIKE',  '%' . $fecha . '%']
                ])->get();
        }
        else if($filtro == "terminadas" || $filtro == "Terminadas" || $filtro == "terminado" || $filtro == "Terminado")
        {
            $tareas = Tareas::where([
                ['id_user','=', $request->user()->id],
                ['estado','=', 'Terminado'],
                ['fecha', 'LIKE',  '%' . $fecha . '%']
                ])->get();
        } else if($filtro == ""){
            $tareas = Tareas::where([
                ['id_user','=', $request->user()->id],
                ['fecha', 'LIKE',  '%' . $fecha . '%']
                ])->get();
        }
        else
        {
            return "No se filtraron registros pendientes ni terminados";
        }
        
        // Construcción del JSON de respuesta
        $respuesta = array();
        $respuesta['tareas'] = $tareas;
        
        return $respuesta;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tareas = new Tareas();
        
        $tareas -> fecha = $request -> input('fecha');
        $tareas -> tipo = $request -> input('tipo');
        $tareas -> estado = $request -> input('estado');
        $tareas -> id_user = $request -> user() -> id;
        $tareas -> descripcion = $request -> input('descripcion');
        
        // Contrucción de la respuesta
        $respuesta = array();
        $respuesta['exito'] = false;
        if($tareas -> save()){
            $respuesta['exito'] = true;
        }

        // Regresa una respuesta
        return $respuesta;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find primary key
        $tareas = Tareas::find($id);

        if($tareas){
            $respuesta = array();
            $respuesta['tareas'] = $tareas;
        } 
        else 
            $respuesta['tareas']= "No se encontro la tarea";

        return $respuesta;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tareas = Tareas::find($id);
        $tareas -> fecha = $request -> input('fecha');
        $tareas -> tipo = $request -> input('tipo');
        $tareas -> estado = $request -> input('estado');
        $tareas -> id_user = $request -> user() -> id;
        $tareas -> descripcion = $request -> input('descripcion');

        // Arma una respuesta
        $respuesta = array();
        $respuesta['exito'] = false;
        if($tareas -> save()){
            $respuesta['exito'] = true;
        }

        // Regresa una respuesta
        return $respuesta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
