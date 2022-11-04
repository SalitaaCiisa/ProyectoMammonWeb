@extends('templates.master')
@section('title')
    Abonos
@endsection
@section('container')
<div class="container mt-4">
    <div class="card">
        <div class="card-header" style="background-color: #E5E5E5; text-align: center;">
            <!-- Message -->
            @if(isset($mensaje))
                <div class="alert alert-success alert-dismissible fade show" role="alert">{{ $mensaje }}</div>
            @endif
            <h1>Abonos</h1>
            <!-- Create Abono Modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAbonoModal">Agregar</button>
            <!-- Modal -->
            <div class="modal fade" id="createAbonoModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAbonoModal">Nuevo abono</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" method="POST" action="*******">
                                <label>Nombre de abono</label>
                                <input type="text" id="nombreAbono" name="nombreAbono" class="form-control" placeholder="Sueldo">
                                <label>Quien abonará</label>
                                <input type="text" id="abonador" name="abonador" class="form-control" placeholder="Jefe">
                                <label>Monto</label>
                                <input type="number" id="monto" name="monto" class="form-control" placeholder="1000000">
                                <label>fecha del abono</label>
                                <input type="date" id="fechaAbono" name="fechaAbono" class="form-control" placeholder="">
                                <label>Frecuencia</label>
                                <br>
                                <div class="d-flex justify-content-around">
                                    <div><input type="radio" id="frecuencia" name="frecuencia" value="Unico"> Unico</div>
                                    <div><input type="radio" id="frecuencia" name="frecuencia" value="Mensual"> Mensual</div>
                                    <div><input type="radio" id="frecuencia" name="frecuencia" value="Semanal"> Semanal</div>
                                </div>
                                <br>
                                <label>Descripción</label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                                {{ csrf_field() }}
                                {{ method_field('POST') }}
                            </form>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card-body">
            @if (false/*!$abonos->isEmpty()*/)
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre Abono</th>
                            <th scope="col">Quien abonará</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Fecha del abono</th>
                            <th scope="col">Frecuencia</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($abonos as $abono)
                            <tr>
                                <td>{{ $abono->nombreAbono}}</td>
                                <td>{{ $abono->abonador}}</td>
                                <td>{{ $abono->monto}}</td>
                                <td>{{ $abono->fechaAbono}}</td>
                                <td>{{ $abono->frecuencia}}</td>
                                <td><!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#descripcionModal{{$abono->id}}">
                                      Mostrar
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="descripcionModal{{$abono->id}}" tabindex="-1" aria-labelledby="descripcionModal{{$abono->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="descripcionModal{{$abono->id}}Label">Descripción</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <p>{{ $abono->descripcion}}</p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 style="text-align: center;">No tienes abonos registrados</h1>
            @endif
        </div>
    </div>
</div>
@endsection