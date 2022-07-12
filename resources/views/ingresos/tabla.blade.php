<table class="table table-striped table-responsive">
	<thead class="table-dark">
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">Fecha del Ingreso</th>
			<th class="text-center">Cantidad</th>
			<th class="text-center">De donde proviene</th>
			<th class="text-center">Acciones</th>
		</tr>
	</thead>
	<tbody>
		@php
			$incremento = 1;
		@endphp
		@if ($ingresos->count() >=1)
			@foreach ($ingresos as $ingreso)
				<tr id="removerId{{$ingreso->id}}">
					<td class="text-center" scope="row">{{$incremento}}</td>
					<td class="text-center">{{$ingreso->fecha_ingresos}}</td>
					<td class="text-center">{{$ingreso->cantidad}}</td>
					<td class="text-center">{{$ingreso->proviene}}</td>
					<td class="text-center">
						<button class="btn btn-warning btn-block" id="button-update" data-bs-toggle="modal" data-bs-target="#modalActualizar" onclick="llenarDatos({{$ingreso->id}},'{{$ingreso->fecha_ingresos}}', {{$ingreso->cantidad}}, '{{$ingreso->proviene}}')"><i class="fa-solid fa-pen"></i>&nbsp; Editar</button> | <button class="btn btn-danger btn-block" id="button-destroy" onclick="eliminar('{{$ingreso->id}}')"><i class="fa-solid fa-trash"></i>&nbsp; Borrar</button>
					</td>
				</tr>
				@php
					$incremento++
				@endphp
			@endforeach
		@else
			<tr>
				<td colspan="5" class="text-center">No hay Ingresos Registrados</td>
			</tr>
		@endif
	</tbody>
</table>
{{$ingresos->links()}}
