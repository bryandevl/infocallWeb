<div class="box-body table-responsive">
    <div class="table-responsive-md">
        <table class="table table-hover table-striped nowrap" style="width:100%">
        	<thead>
        		<tr>
	        		<th></th>
	        		<th colspan="{{count($campaignsArray)}}">CAMPAÑAS</th>
	        	</tr>
	        	<tr>
	        		<th></th>
	        		@foreach($campaignsArray as $key => $value)
	        		<th>{{$value}}</th>
	        		@endforeach
	        	</tr>
        	</thead>
        	<tbody>
        		@foreach($campaignsResultArray as $key => $value)
        		<tr>
        			<td><b>{{$key}}</b></td>
        			@foreach($campaignsArray as $key2 => $value2)
        			@php
        				$cantidad = isset($value[$key2])? $value[$key2] : 0;
        			@endphp
        			<td>{{$cantidad}}</td>
        			@endforeach
        		</tr>
        		@endforeach
        	</tbody>
        </table>
    </div>
</div>