<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\User;

class UsuarioController extends Controller
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
        $usuarios = User::all();
        $argumentos = array();
        $argumentos['usuarios'] = $usuarios;
        return view('admin.usuarios.index', $argumentos);
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
        if($filter == "user_type")
        {
            $usuarios = User::where('user_type', 'LIKE', '%' . $search . '%')->get();
        }
        else if($filter == "name")
        {
            $usuarios = User::where('name', 'LIKE', '%' . $search . '%')->get();
        }
        else if($filter == "email")
        {
            $usuarios = User::where('email', 'LIKE', '%' . $search . '%')->get();
        }
        
        // Data arguments with which to refresh the index page
        $argumentos = array();
        $argumentos['usuarios'] = $usuarios;
        return view('admin.usuarios.index', $argumentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuarios = new User();
        $usuarios -> user_type = $request -> input('user_type');
        $usuarios -> name = $request -> input('name');
        $usuarios -> email = $request -> input('email');
        $usuarios -> password = bcrypt($request -> input('password'));

       
        if($usuarios -> save())
        {
            return redirect() -> route('usuarios.index') -> with('success', 'Usuario guardado correctamente');
        }
        // In case the if() doesn't finish the execution of the code with the return, then cookies will be used to validate 
        return redirect() -> route('usuarios.index') -> with('failure', 'El usuario no pudo ser guardada correctamente');
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
        $usuarios = User::find($id);
        
        if($usuarios)
        {
            $argumentos = array();
            $argumentos['usuarios'] = $usuarios;
            return view('admin.usuarios.show', $argumentos);
        }
        
        return redirect() -> route('usuarios.index' -> with('failure', 'No se encontró al  usuario'));
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
        $usuarios = User::find($id);

        if($usuarios)
        {
            $argumentos = array();
            $argumentos['usuarios'] = $usuarios;
            return view('admin.usuarios.edit', $argumentos);
        }
        
        return redirect() -> route('usuarios.index' -> with('failure', 'No se encontró al usuario'));
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
        $usuarios = User::find($id);
        if($usuarios)
        {
            $usuarios -> user_type = $request -> input('user_type');
            $usuarios -> name = $request -> input('name');
            $usuarios -> email = $request -> input('email');
            $usuarios -> password = bcrypt($request -> input('password'));


            if($usuarios -> save())
            {
                return redirect() -> route('usuarios.edit', $id) -> with('success', 'El usuario se actualizó exitosamente');
            }
            // If usuario can't be updated
            return redirect() -> route('usuarios.edit', $id) -> with('failure', 'No se pudo actualizar el usuario');
        }
        // If usuario isn't even found
        return redirect() -> route('usuarios.index') -> with('failure', 'No se encontró al usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuarios = User::find($id);
        
        if($usuarios) {
            if($usuarios -> delete()){
                return redirect() -> route('usuarios.index') -> with('exito', 'Usuario eliminado exitosamente');
            }
            return redirect() -> route('usuarios.index') ->with('failure', 'No se pudo eliminar al usuario');
        }
        return redirect() -> route('usuarios.index') -> with('failure', 'No se encontró al usuario');
    }
}
