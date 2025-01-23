@extends('adminlte::page')

@section('htmlheader_title')
Reportes CRDIAL
@endsection

@section('contentheader_title')
    <i class="fa fa-id-card-o"></i> Supervisores
@endsection

@section('contentheader_description')
    Reportes CRDIAL
@endsection

@section('contentheader_breadcrumb')
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Supervisores</li>
</ol>
@endsection

@section('main-content') {{-- Usa 'main-content' en lugar de 'content' --}}
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">REPORTES DE CRDIAL</h1>

            <div class="row">
                <!-- CORE 1 reportwhtasapp   Reporte de Whatsapp  coreone.Asignacion  -->
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">CORE 1</h3>
                        </div>
                        <div class="box-body">
                            <ul>
                            <h4 class="box-title" style="font-weight: bold; text-decoration: underline;">Reportes vicidial</h4>
                            <li><a href="{{ route('coreone.reportspeech') }}">Export speech Analitycs Report</a></li>
                             <li><a href="{{ route('coreone.reportHistorico') }}">Export CSV Histórico de Gestiones</a></li>           
                            <li><a href="{{ route('coreone.reportgestionbfb') }}">Reporte Gestiones Falabella</a></li>  
                            <li><a href="{{ route('coreone.reportpromesasbfb') }}">Reporte Promesas Falabella</a></li>                              
                            <li><a href="{{ route('coreone.reportsantgest') }}">Reporte Gestiones Santander</a></li>                         
                            <li><a href="{{ route('coreone.reportcencosud') }}">Reporte Gestiones Cencosud</a></li>  
                            <li><a href="{{ route('coreone.reportpromesacencosud') }}">Reporte Promesas Cencosud</a></li>     
                            <li><a href="{{ route('coreone.reportgestionibk') }}">Reporte Gestiones Interbank</a></li>      
                            <li><a href="{{ route('coreone.reportpromesasibk') }}">Reporte Promesas Interbank</a></li>                 
                            <li><a href="{{ route('coreone.reportmaf') }}">Reporte Gestiones MAF</a></li>       
                            <li><a href="{{ route('coreone.reportgestFoh') }}">Reporte Gestiones Financiera OH</a></li>                    
                            <li><a href="{{ route('coreone.reportwhtasapp') }}">Reporte Whatsapp</a></li>  
                            <li><a href="{{ route('coreone.agentproduc') }}">Reporte Tiempos Operativos</a></li> 
                            <h4 class="box-title" style="font-weight: bold; text-decoration: underline;">Cargas Data</h4>
                            <li><a href="{{ route('coreone.Asignacion') }}">Carga Asignacion</a></li> 
                            <li><a href="{{ route('coreone.Pagos') }}">Carga Pagos</a></li> 
                            <span class="hidden-xs" data-toggle="tooltip" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</span> 
                            
                            <li>Carga Mascara</li>
                            <li>Carga Courrier</li> 
                            <li><a href="{{ route('coreone.updateList') }}">Actualizar Lista</a></li>  
                           
                                
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- CORE 2 -->
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">CORE 2</h3>
                        </div>
                        <div class="box-body">
                            <ul>
                            <h4 class="box-title" style="font-weight: bold; text-decoration: underline;">Reportes vicidial</h4>
                            <li><a href="{{ route('coreone.reportspeech') }}">Export speech Analitycs Report</a></li> 
                            <li>Export CSV Histórico de Gestiones</li>
                            <li>Reporte Gestiones Falabella</li>    
                            <li>Reporte Promesas Falabella</li>                         
                            <li><a href="{{ route('coreone.reportsantgest') }}">Reporte Santander</a></li>  
                            <li>Reporte Gestiones Cencosud</li> 
                            <li>Reporte Promesas Cencosud</li>     
                            <li>Reporte Gestiones Interbank</li> 
                            <li>Reporte Promesas Interbank</li> 
                            <li>Reporte Gestiones MAF</li> 
                            <li>Reporte Promesas MAF</li>   
                            <li>Reporte Gestiones Financiera OH</li>                     
                            <li><a href="{{ route('coreone.reportwhtasapp') }}">Reporte Whatsapp</a></li>  
                            <h4 class="box-title" style="font-weight: bold; text-decoration: underline;">Cargas Data</h4>
                            <li>Carga Asignacion</li> 
                            <li>Carga Pagos</li> 
                            <li>Carga Mascara</li>
                            <li>Carga Courrier</li> 
                            <li>Actualizar Lista</li> 
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- CORE 3 -->
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">CORE 3</h3>
                        </div>
                        <div class="box-body">
                            <ul>
                            <h4 class="box-title" style="font-weight: bold; text-decoration: underline;">Reportes vicidial</h4>
                            <li><a href="{{ route('coreone.reportspeech') }}">Export speech Analitycs Report</a></li> 
                            <li>Export CSV Histórico de Gestiones</li>
                            <li>Reporte Gestiones Falabella</li>    
                            <li>Reporte Promesas Falabella</li>                         
                            <li><a href="{{ route('coreone.reportsantgest') }}">Reporte Santander</a></li>  
                            <li>Reporte Gestiones Cencosud</li> 
                            <li>Reporte Promesas Cencosud</li>     
                            <li>Reporte Gestiones Interbank</li> 
                            <li>Reporte Promesas Interbank</li> 
                            <li>Reporte Gestiones MAF</li> 
                            <li>Reporte Promesas MAF</li>   
                            <li>Reporte Promesas Financiera OH</li>                     
                            <li><a href="{{ route('coreone.reportwhtasapp') }}">Reporte Whatsapp</a></li>  
                            <h4 class="box-title" style="font-weight: bold; text-decoration: underline;">Cargas Data</h4>
                            <li>Carga Asignacion</li> 
                            <li>Carga Pagos</li> 
                            <li>Carga Mascara</li>
                            <li>Carga Courrier</li> 
                            <li>Actualizar Lista</li> 
                                
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- CORE NUBE -->
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">CORE NUBE</h3>
                        </div>
                        <div class="box-body">
                            <ul>
                            <h4 class="box-title" style="font-weight: bold; text-decoration: underline;">Reportes vicidial</h4>
                            <li><a href="{{ route('coreone.reportspeech') }}">Export speech Analitycs Report</a></li> 
                            <li>Export CSV Histórico de Gestiones</li>
                            <li>Reporte Gestiones Falabella</li>    
                            <li>Reporte Promesas Falabella</li>                         
                            <li><a href="{{ route('coreone.reportsantgest') }}">Reporte Santander</a></li>  
                            <li>Reporte Gestiones Cencosud</li> 
                            <li>Reporte Promesas Cencosud</li>     
                            <li>Reporte Gestiones Interbank</li> 
                            <li>Reporte Promesas Interbank</li> 
                            <li>Reporte Gestiones MAF</li> 
                            <li>Reporte Promesas MAF</li>   
                            <li>Reporte Promesas Financiera OH</li>                     
                            <li><a href="{{ route('coreone.reportwhtasapp') }}">Reporte Whatsapp</a></li>  
                            <h4 class="box-title" style="font-weight: bold; text-decoration: underline;">Cargas Data</h4>
                            <li>Carga Asignacion</li> 
                            <li>Carga Pagos</li> 
                            <li>Carga Mascara</li>
                            <li>Carga Courrier</li> 
                            <li>Actualizar Lista</li> 
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
