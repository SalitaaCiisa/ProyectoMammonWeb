@extends('templates.master')
@section('title')
    Inicio
@endsection
@section('container')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header" style="background-color: #E5E5E5; text-align: center;">
                <h1>Resumen</h1>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-start">
                    <p style="font-size: 26px;">Presupuesto: 2000$
                    <p>
                </div>
                <div class="d-flex justify-content-start">
                    <p style="font-size: 15px; font-weight: bold;">Total cuentas: 12000$
                    <p>
                </div>
                <div class="d-flex justify-content-end">
                    <div style="width: max-content;">
                        <div class="d-flex justify-content-start">
                            <p style="font-size: 20px;">Falta por pagar: 10000$
                            <p>
                        </div>
                        <div class="d-flex justify-content-start">
                            <p style="font-size: 20px;">Falta por cobrar: 0$
                            <p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
