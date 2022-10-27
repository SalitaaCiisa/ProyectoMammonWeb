<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class usuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($mensaje = null)
    {
        $usuarios = DB::table('usuarios')->get();
        return view('/', compact('usuarios', 'mensaje'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #REGLAS DEL FORMULARIO
        $rules =
            [
                'username' => 'required|string|min:5|max:50',
                'password' => 'required|string|min:8|max:255',
                'email' => 'required|string|min:1|max:255',
            ];

        #MENSAJES PERSONALIZADOS 
        $mensaje =
            [
                'required' => 'El campo :attribute es requerido',
                'string' => 'El campo :attribute no puede estar vacio',
                'min' => 'El campo :attribute debe ser al menos :min',
                'max' => 'El campo :attribute debe ser como máximo :max'
            ];

        #VALIDAMOS EL FORMULARIO ANTES DE INTENTAR HACER LA INSERCION
        $this->validate($request, $rules, $mensaje);
        

        #INTENTAMOS INSERTAR TOMANDO LOS DATOS DEL REQUEST
        try {
            DB::table('usuarios')->insert([
                'username' => $request->username,
                'password' => $request->password,
                'email' => $request->email,
            ]);
            $mensaje = "Usuario registrado con éxito";
            return view('/login', compact('mensaje'));
        }

        #ATRAPAMOS UN QUERY EXCEPTION EN CASO QUE OCURRA Y DEVOLVEMOS EL ERROR A LA VISTA
        catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $mensaje = "Error al crear nuevo usuario, entrada duplicada [Error Code: 1062]";
                return view('/register', compact('mensaje'));
            } else {
                $mensaje = "Ha ocurrido un error al insertar [Error Code: " . $e->errorInfo[1] . "]";
                return view('/register', compact('mensaje'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Search for the existing of an Usuario for his username and password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            $usuario = DB::table('usuarios')->where('username', $request->username)->where('password', $request->password)->get();
            return view('login', compact('usuario', 'request'));
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            //dd($e->errorInfo);

            if (false) {
                $mensaje = '';
                return view('/login', compact('mensaje'));
            }else {
                $mensaje = "Ha ocurrido un error al iniciar sesion [Error Code: " . $e->errorInfo[1] . "]";
                return view('/login', compact('mensaje'));
            }
        }
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
        #REGLAS DEL FORMULARIO
        $rules =
            [
                'username' => 'required|string|min:5|max:50',
                'password' => 'required|string|min:8|max:255',
                'email' => 'required|string|min:1|max:255',
            ];

        #MENSAJES PERSONALIZADOS 
        $customMessages =
            [
                'required' => 'El campo :attribute es requerido',
                'string' => 'El campo :attribute no puede estar vacio',
                'min' => 'El campo :attribute debe ser al menos :min',
                'max' => 'El campo :attribute debe ser como máximo :max'
            ];

        #VALIDAMOS EL FORMULARIO ANTES DE INTENTAR HACER LA INSERCION
        $this->validate($request, $rules, $customMessages);

        #INTENTAMOS HACER LA ACTUALIZACION DEL USUARIO
        try {
            DB::table('usuarios')->where('id', $id)->update($request->except(['_token', '_method']));
            $mensaje = "El usuario " . $id . " ha sido actualizado con éxito";
            return $this->index($mensaje);
        }
        #EN CASO DE ERROR EN LA QUERY ATRAPAMOS EL ERROR Y LO DEVOLVEMOS A LA VISTA
        catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $mensaje = "Error al actualizar al usuario. [Error Code: " . $e->errorInfo[1] . ".]";
            return $this->index($mensaje);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::table('usuarios')->where('id', '=', $id)->delete();
            $mensaje = "Usuario eliminado con éxito";
            return $this->index($mensaje);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $mensaje = "Error al eliminar el usuario " . $id . " [Error Code: " . $e->errorInfo[1] . "]";
            return $this->index($mensaje);
        }
    }

    /**
     * Controller to disconnect an acount from $_SESSION.
     *
     * @return \Illuminate\Http\Response
     */
    public function logOut()
    {
        session_start();
        session_unset();
        session_destroy();

        return view('login');
    }
}
