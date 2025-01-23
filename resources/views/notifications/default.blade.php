<style type="text/css">
	* {font-family: "Arial";}
	img{max-width: 120px; margin: 5px auto; display: block;}
	.container{width: 65%; margin: 0px auto; display: block; min-width: 280px;}
	.content-body, .content-footer{border: solid 1.5px rgba(15,22,121);}
	.content-footer{color: #fff; background-color: rgba(15,22,121);}
	.content-footer p{padding: 0px 10px; text-align: right;}
	.content-body{background-color: #fff;}
</style>
<section>
	<div class="container">
		@php
			$pathImageLogo = \URL::asset("img/cr_cobranzas_logo.jpg")."?id=".time();
		@endphp
		<img src="{{$pathImageLogo}}" alt="img" />
	</div>
	<div class="container content-body">
		@yield('content')
	</div>
	<div class="container content-footer">
		<p><span class="text-midelivery">{{env("APP_NAME_BUSSINESS", "")}} Copyright {{date('Y')}}</span><span class="separator-footer"> | </span><span class="text-derechos-reservados">Derechos Reservados</span></p>
	</div>
</section>