<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tareas;

class TareasController extends Controller
{
    public function __construct()
    {
        $this -> middleware('auth');
        //$this -> middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tareas = Tareas::all();
        $argumentos = array();
        $argumentos['tareas'] = $tareas;
        return view('admin.tareas.index', $argumentos);
    }

    /**
     * Display a list of items depending on the search criteria.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Search terms
        $filter = $request -> input('filtro');
        $search = $request -> input('search');

        // Retrieval of the data according to the search terms
        if($filter == "fecha")
        {
            $tareas = Tareas::where('fecha_hora', 'LIKE', '%' . $search . '%')->get();
        }
        else if($filter == "estado")
        {
            $tareas = Tareas::where('estado', 'LIKE', '%' . $search . '%')->get();
        } 
        else if($filter == "usuario")
        {
            $tareas = Tareas::where('id_user', 'LIKE', '%' . $search . '%')->get();
        }
        
        // Data arguments with which to refresh the index page
        $argumentos = array();
        $argumentos['tareas'] = $tareas;
        return view('admin.tareas.index', $argumentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tareas.create');
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
        $tareas -> id_user = $request -> input('id_user');
        $tareas -> estado = $request -> input('estado');
        $tareas -> foto = $request -> input('foto');
        $tareas -> fecha_hora = $request -> input('fecha_hora');
        $tareas -> ubicacion = $request -> input('ubicacion');

        // Photo File verification and upload with its path's string
        if($request -> hasFile('foto')) {
            $archivoProfile = $request -> file('foto');
            $rutaArchivo = $archivoProfile -> store('public\tarea');
            $rutaArchivo = substr($rutaArchivo, 19);
            $tareas -> foto = $rutaArchivo;
        }

        if($tareas -> save())
        {
            return redirect() -> route('tareas.index') -> with('success', 'La tarea fue guardada correctamente');
        }
        // In case the if() doesn't finish the execution of the code with the return, then cookies will be used to validate 
        return redirect() -> route('tareas.index') -> with('failure', 'La tarea no pudo ser guardada correctamente');
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
        
        if($tareas)
        {
            $argumentos = array();
            $argumentos['tareas'] = $tareas;
            return view('admin.tareas.show', $argumentos);
        }
        
        return redirect() -> route('tareas.index' -> with('failure', 'No se encontró la tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Find primary key
        $tareas = Tareas::find($id);

        if($tareas)
        {
            $argumentos = array();
            $argumentos['tareas'] = $tareas;
            return view('admin.tareas.edit', $argumentos);
        }
        
        return redirect() -> route('tareas.index' -> with('failure', 'No se encontró la tarea'));
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
        // Busca un registro a partir de la llave primaria (SELECT * FROM Noticia)
        $tareas = Tareas::find($id);
        if($tareas)
        {
            $tareas -> id_user = $request -> input('id_user');
            $tareas -> estado = $request -> input('estado');
            $tareas -> foto = $request -> input('foto');
            $tareas -> fecha_hora = $request -> input('fecha_hora');
            $tareas -> ubicacion = $request -> input('ubicacion');

            // Photo File verification and upload with its path's string
            if($request -> hasFile('foto')) {
                $archivoProfile = $request -> file('foto');
                $rutaArchivo = $archivoProfile -> store('public\tarea');
                $rutaArchivo = substr($rutaArchivo, 19);
                $tareas -> foto = $rutaArchivo;
            }
            
            if($tareas -> save())
            {
                return redirect() -> route('tareas.edit', $id) -> with('success', 'La tarea se actualizó exitosamente');
            }
            // If tarea can't be updated
            return redirect() -> route('tareas.edit', $id) -> with('failure', 'No se pudo actualizar la tarea');
        }
        // If tarea isn't even found
        return redirect() -> route('tareas.index') -> with('failure', 'No se encontró la tarea');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tareas = Tareas::find($id);
        
        if($tareas) {
            if($tareas -> delete()){
                return redirect() -> route('tareas.index') -> with('exito', 'Tarea eliminada exitosamente');
            }
            return redirect() -> route('tareas.index') ->with('failure', 'No se pudo eliminar la tarea');
        }
        return redirect() -> route('tareas.index') -> with('failure', 'No se encontró la tarea');
    }
}
