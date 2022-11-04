@extends('templates.master')
@section('title')
    Cobros
@endsection
@section('container')
<div class="container mt-4">
    <div class="card">
        <div class="card-header" style="background-color: #E5E5E5; text-align: center;">
            <!-- Message -->
            @if(isset($mensaje))
                <div class="alert alert-success alert-dismissible fade show" role="alert">{{ $mensaje }}</div>
            @endif
            <h1>Cobros</h1>
            <!-- Create Cobro Modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCobroModal">Agregar</button>
            <!-- Modal -->
            <div class="modal fade" id="createCobroModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createCobroModal">Nuevo Cobro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" method="POST" action="*******">
                                <label>Nombre de Cobro</label>
                                <input type="text" id="nombreCobro" name="nombreCobro" class="form-control" placeholder="Netflix familiar">
                                <label>Quien cobrará</label>
                                <input type="text" id="cobrador" name="cobrador" class="form-control" placeholder="Netflix">
                                <label>Monto</label>
                                <input type="number" id="monto" name="monto" class="form-control" placeholder="6700">
                                <label>fecha del Cobro</label>
                                <input type="date" id="fechaCobro" name="fechaCobro" class="form-control" placeholder="">
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
            @if (false/*!$Cobros->isEmpty()*/)
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre Cobro</th>
                            <th scope="col">Quien cobrará</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Fecha del Cobro</th>
                            <th scope="col">Frecuencia</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Cobros as $Cobro)
                            <tr>
                                <td>{{ $Cobro->nombreCobro}}</td>
                                <td>{{ $Cobro->cobrador}}</td>
                                <td>{{ $Cobro->monto}}</td>
                                <td>{{ $Cobro->fechaCobro}}</td>
                                <td>{{ $Cobro->frecuencia}}</td>
                                <td><!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#descripcionModal{{$Cobro->id}}">
                                      Mostrar
                                    </button>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="descripcionModal{{$Cobro->id}}" tabindex="-1" aria-labelledby="descripcionModal{{$Cobro->id}}Label" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="descripcionModal{{$Cobro->id}}Label">Descripción</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <p>{{ $Cobro->descripcion}}</p>
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
                <h3 style="text-align: center;">No tienes Cobros registrados</h1>
            @endif
        </div>
    </div>
</div>
@endsection