<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class cuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($mensaje = null)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }

        try {
        $cuentas = DB::table('cuentas')->where('idUsuario',$_SESSION['idUsuario'])->get();
        return view('cuentasBancarias', compact('cuentas','mensaje'));
        }
        catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            $cuentas = null;
            $mensaje = "Error al buscar cuentas [Error Code: ".$e->errorInfo[1]."]";
            //dd($e->errorInfo);
            return view('cuentasBancarias', compact('cuentas','mensaje'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }
        #REGLAS DEL FORMULARIO
        $rules =
            [
                'nombreCuenta' => 'required|string|min:1|max:100',
                'link_token' => 'required|string',
                'api_key' => 'required|string',
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

        #INTENTAMOS INSERTAR TOMANDO LOS DATOS DEL REQUEST
        try {
            DB::table('cuentas')->insert([
                'idUsuario' => $_SESSION['idUsuario'],
                'nombreCuenta' => $request->nombreCuenta,
                'link_token' => $request->link_token,
                'api_key' => $request->api_key,
            ]);
            $mensaje = "Usuario registrado con éxito";
            return $this->index($mensaje);
        }

        #ATRAPAMOS UN QUERY EXCEPTION EN CASO QUE OCURRA Y DEVOLVEMOS EL ERROR A LA VISTA
        catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $mensaje = "Error al crear nueva cuenta, entrada duplicada [Error Code: 1062]";
                return $this->index($mensaje);
            } else {
                $mensaje = "Ha ocurrido un error al insertar [Error Code: " . $e->errorInfo[1] . "]";
                //dd($e->errorInfo);
                return $this->index($mensaje);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }
        #REGLAS DEL FORMULARIO
        $rules =
            [
                'nombreCuenta' => 'required|string|min:1|max:100',
                'link_token' => 'required|string',
                'api_key' => 'required|string',
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

        try{
            DB::table('cuentas')->where('id', $id)->where('idUsuario' , $_SESSION['idUsuario'])->update($request->except(['_token', '_method']));
            $mensaje = "La cuenta bancaria '$request->nombreCuenta' ha sido actualizada con éxito";
            return $this->index($mensaje);            
        }
        #EN CASO DE ERROR EN LA QUERY ATRAPAMOS EL ERROR Y LO DEVOLVEMOS A LA VISTA
        catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            $mensaje = "Error al actualizar la cuenta bancaria. [Error Code: ".$e->errorInfo[1].".]";
            //dd($e->errorInfo);
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
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }
        try{
            $respuesta = DB::table('cuentas')->where('id','=', $id)->where('idUsuario' ,'=', $_SESSION['idUsuario'])->delete();

            if ($respuesta == 1) {
                $mensaje = "Cuenta bancaria eliminado con éxito";
                return $this->index($mensaje);
            } elseif ($respuesta > 1) {
                $mensaje = "WARNING Se han eliminado $respuesta cuentas";
                return $this->index($mensaje);
            }else {
                $mensaje = "No se ha podido eliminar esa cuenta";
                return $this->index($mensaje);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            $mensaje = "Error al eliminar la cuenta de id =".$id." [Error Code: ".$e->errorInfo[1]."]";
            //dd($e->errorInfo);
            return $this->index($mensaje);
        }
    }
}
