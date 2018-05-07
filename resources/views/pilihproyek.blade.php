@extends('layouts.template')

@section('title','Home')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
     @if (Route::has('login'))
        @if (Auth::check())
                {!! Form::open(['url' => '/pilihproyekk', 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div  class="panel panel-default" style="padding: 20px; margin:auto;">
                            <div class="row">
                                    <div class="col-md-3">Pilih Proyek</div>
                                    <div class="col-md-9">
                                        <select name="pilihanproyek" id="pilihanproyek" class="form-control" required>
                                           <option value="">-- Pilih Proyek -- </option>
                                            @foreach($proyeks as $proyek)
                                               @if(session()->get('pilihanproyek')==$proyek->kodeProyek)
                                                <option value="{{$proyek->kodeProyek}}" selected>{{$proyek->uraian}}</option>
                                               @else
                                                <option value="{{$proyek->kodeProyek}}">{{$proyek->uraian}}</option>
                                               @endif
                                            @endforeach
                                       </select>
                                    </div>
                            </div>
                            <div class="row">
                                 <input type="submit" name="btnPilihan" value="PILIH" class="btn btn-default">
                            </div>
                        </div>
                    </div>
                </div>
                    
                {!! Form::close() !!}
        @endif  
    @endif
</div>
<!-- /page content -->
@endsection