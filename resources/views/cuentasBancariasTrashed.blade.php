@extends('templates.master')
@section('title')
    Cuentas bancarias Trashed
@endsection
@section('container')
<div class="container mt-4">
    @if (count($errors) > 0)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            @php
                $mensaje = null;
                foreach ($errors->all() as $msg) {
                    echo $msg."<br>";
                }
            @endphp
            </div>
    @endif
    <div class="card">
        <div class="card-header" style="background-color: #E5E5E5; text-align: center;">
            <h1>Cuentas Archivadas</h1>
        </div>
        <div class="card-body">
            @if (!$cuentas->isEmpty())
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre Cuenta</th>
                            <th scope="col">Dinero en cuenta</th>
                            <th scope="col">Fecha Ultimo Cargo</th>
                            <th scope="col">Monto Ultimo Cargo</th>
                            <th scope="col">Fecha Ultimo Abono</th>
                            <th scope="col">Monto Ultimo Abono</th>
                            <th scope="col">Prueba link_token</th>
                            <th scope="col">Prueba API key</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuentas as $cuenta)
                            <tr>
                                <td>{{ $cuenta->nombreCuenta}}</td>
                                <td>Prueba</td>
                                <td>Prueba</td>
                                <td>Prueba</td>
                                <td>Prueba</td>
                                <td>Prueba</td>
                                <td>{{ $cuenta->link_token}}</td>
                                <td>{{ $cuenta->api_key}}</td>
                                <td>
                                    <form class="form-group" method="post" action="{{ route('cuentas.restore_trashed',['id'=>$cuenta])}}">
                                        <input type="text" name="id" id="id" value="{{ $cuenta->id}}" hidden>
                                        <button type="submit" class="btn btn-warning">restaurar</button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE')}}
                                    </form>
                                    <form class="form-group" method="post" action="{{ route('cuentas.forceDelete_trashed',['id'=>$cuenta])}}">
                                        <input type="text" name="id" id="id" value="{{ $cuenta->id}}" hidden>
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE')}}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 style="text-align: center;">No tienes cuentas registradas</h3>
            @endif
        </div>
    </div>
</div>
@endsection