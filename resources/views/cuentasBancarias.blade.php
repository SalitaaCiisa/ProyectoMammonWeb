@extends('templates.master')
@section('title')
    Cuentas bancarias
@endsection
@section('container')
<div class="container mt-4">
    <div class="card">
        <div class="card-header" style="background-color: #E5E5E5; text-align: center;">
            <h1>Cuentas</h1>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre Cuenta</th>
                        <th scope="col">Dinero en cuenta</th>
                        <th scope="col">Fecha Ultimo Cargo</th>
                        <th scope="col">Monto Ultimo Cargo</th>
                        <th scope="col">Fecha Ultimo Abono</th>
                        <th scope="col">Monto Ultimo Abono</th>
                        <th scope="col">Prueba link_token</th>
                        <th scope="col">Prueba API key</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form action="" method="get">
                            <th scope="row">1</th><input type="hidden" name="ID" value="1">
                            <td>Banco Estado <button type="submit">Editar</button>
                            </td>
                            <td>$45670</td>
                            <td>28/09/22</td>
                            <td>$100</td>
                            <td>28/09/22</td>
                            <td>$100</td>
                        </form>
                    </tr>
                    <tr>
                        <form action="" method="get">
                            <th scope="row">2</th><input type="hidden" name="ID" value="2">
                            <td>Banco de Chile (Mi cuenta)<button type="submit">Editar</button>
                            </td>
                            <td>$30000</td>
                            <td>13/09/22</td>
                            <td>$100</td>
                            <td>28/09/22</td>
                            <td>$100</td>
                        </form>
                    </tr>
                    <tr>
                        <form action="" method="get">
                            <th scope="row">3</th> <input type="hidden" name="ID" value="3">
                            <td>Banco de Chile (Papá)<button type="submit">Editar</button></td>
                            <td>$567890</td>
                            <td>08/07/22</td>
                            <td>$100</td>
                            <td>10/09/22</td>
                            <td>$100</td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection