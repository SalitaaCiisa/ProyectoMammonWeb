<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Cuentas;
use App\Models\CuentasAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\FlareClient\Api;

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
            //$cuentas = DB::table('cuentas')->where('idUsuario',$_SESSION['idUsuario'])->get();
            $cuentasDB = Cuentas::where('idUsuario',$_SESSION['idUsuario'])->get();

            $cuentas = array();

            $url = 'https://api.fintoc.com/v1/accounts';
            foreach ($cuentasDB as $cuenta) {
                $response = Http::withHeaders([
                    'Authorization' => $cuenta->api_key
                ])
                    ->get($url, [
                    'link_token' => $cuenta->link_token
                ]);

                $jsonCuentas = $response->json();

                array_push($cuentas, new CuentasAPI($jsonCuentas,$cuenta));

                //dd($jsonCuentas[0]['balance']['available']);
            }

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
     * @param  \App\Models\Cuentas  $cuentas
     * @return \Illuminate\Http\Response
     */
    public function show(Cuentas $cuentas)
    {
        //
    }

    /**
     * Display a list of trashed resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_trashed($mensaje = null)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }

        try {
        //$cuentas = Cuentas::onlytrashed()->where('idUsuario',$_SESSION['idUsuario'])->get();
        $cuentas = Cuentas::where('idUsuario',$_SESSION['idUsuario'])->onlyTrashed()->get();
        return view('cuentasBancariasTrashed', compact('cuentas','mensaje'));
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
     * Restores a trashed resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore_trashed($id){
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }

        try {
            $cuenta = Cuentas::onlyTrashed()->find($id);
            $cuenta->restore();

            $mensaje = "Se ha restaurado la cuenta de id: $id con exito";
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $mensaje = "Error al restaurar la cuenta de id =".$id." [Error Code: ".$e->errorInfo[1]."]";
            //dd($e->errorInfo);
            return $this->show_trashed($mensaje);
        }

        return $this->show_trashed($mensaje);
    }

    /**
     * Delete permanently a trashed resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete_trashed($id){
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['idUsuario'])) {
            header("Location:/login");
            exit();
        }

        try {
            $cuenta = Cuentas::onlyTrashed()->find($id);
            $cuenta->forceDelete();

            $mensaje = "Se ha eliminado la cuenta de id: $id con exito";
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $mensaje = "Error al eliminar la cuenta de id =".$id." [Error Code: ".$e->errorInfo[1]."]";
            //dd($e->errorInfo);
            return $this->show_trashed($mensaje);
        }

        return $this->show_trashed($mensaje);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuentas  $cuentas
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuentas $cuentas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuentas  $cuentas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuentas $cuentas)
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
            Cuentas::where('id', $cuentas->id)->where('idUsuario' , $_SESSION['idUsuario'])->update($request->except(['_token', '_method']));
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
            $cuenta = Cuentas::find($id);

            $respuesta = $cuenta->where('id','=', $id)->where('idUsuario' ,'=', $_SESSION['idUsuario'])->delete();

            //$respuesta = Cuentas::where('id','=', $cuentas->id)->where('idUsuario' ,'=', $_SESSION['idUsuario'])->delete();

            if ($respuesta == 1) {
                $mensaje = "Cuenta bancaria archivada con éxito";
                return $this->index($mensaje);
            } elseif ($respuesta > 1) {
                $mensaje = "WARNING Se han archivado $respuesta cuentas";
                return $this->index($mensaje);
            }else {
                $mensaje = "No se ha podido archivar esa cuenta";
                return $this->index($mensaje);
            }
        }
        catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            $mensaje = "Error al archivar la cuenta de id =".$id." [Error Code: ".$e->errorInfo[1]."]";
            //dd($e->errorInfo);
            return $this->index($mensaje);
        }
    }
}
