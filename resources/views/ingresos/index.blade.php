@extends('layouts.main')

@section('title', 'Ingresos')

@section('content')
@if (Session::has('mensaje'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{Session::get('mensaje')}}
		<button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@endif
<div class="p-3">
	<!-- Button trigger modal -->
	<button type="button" id="button-Reg-Ingreso" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
		Agregar Ingreso
	</button>
</div>
<div id="container-tabla"></div>

<!-- Modal -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Nuevo Ingreso</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" onclick="CerrarModal()" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="{{ route('ingreso') }}" id="FormIngreso" method="post">
					@csrf

					<div class="form-group mb-2 mt-2">
						<label class="form-label form-control-lg" for="fecha_ingreso"><i class="fa-solid fa-calendar"></i>&nbsp; Fecha de Ingreso <span style="color: red;">*</span></label>
						<input class="form-control form-control-lg" required type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ date('Y-m-d') }}">
					</div>
					<div class="form-group mb-2 mt-2">
						<label class="form-label form-control-lg" for="fecha_ingreso"><i class="fa-solid fa-dollar-sign"></i>&nbsp; Cantidad <span style="color: red;">*</span></label>
						<input class="form-control form-control-lg" required type="number" step="0.01" name="cantidad" id="cantidad" value="{{ old('cantidad') }}">
					</div>
					<div class="form-group mb-2 mt-2">
						<label class="form-label form-control-lg" for="fecha_ingreso"><i class="fa-solid fa-circle-question"></i>&nbsp; De donde proviene</label>
						<input class="form-control form-control-lg" type="text" name="proviene" id="proviene" value="{{ old('proviene') }}">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="CerrarModal()">Cerrar</button>
				<button type="submit" class="btn btn-success" form="FormIngreso">Guardar</button>
			</div>

		</div>
	</div>
</div>

<!-- Modal ACTUALIZAR -->
<div class="modal fade" id="modalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Editar Ingreso</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" onclick="CerrarModal()" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="{{ route('actualizar') }}" id="FormActualizar" method="post">
					@csrf
					@method('PUT')
					<input type="hidden" name="id2" id="id2" value="">
					<div class="form-group mb-2 mt-2">
						<label class="form-label form-control-lg" for="fecha_ingreso"><i class="fa-solid fa-calendar"></i>&nbsp; Fecha de Ingreso <span style="color: red;">*</span></label>
						<input class="form-control form-control-lg" required type="date" name="fecha_ingreso2" id="fecha_ingreso2" value="">
					</div>
					<div class="form-group mb-2 mt-2">
						<label class="form-label form-control-lg" for="fecha_ingreso"><i class="fa-solid fa-dollar-sign"></i>&nbsp; Cantidad <span style="color: red;">*</span></label>
						<input class="form-control form-control-lg" required type="number" step="0.01" name="cantidad2" id="cantidad2" value="">
					</div>
					<div class="form-group mb-2 mt-2">
						<label class="form-label form-control-lg" for="fecha_ingreso"><i class="fa-solid fa-circle-question"></i>&nbsp; De donde proviene</label>
						<input class="form-control form-control-lg" type="text" name="proviene2" id="proviene2" value="">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="CerrarModal()">Cerrar</button>
				<button type="submit" class="btn btn-warning" form="FormActualizar">Editar</button>
			</div>

		</div>
	</div>
</div>

@endsection
@section('scrips')
	<script>
		$(document).ready(function(){
			Cargartabla(1);
		});

		function Cargartabla(page){
			console.log(page);
		}

		function CerrarModal(){
			document.getElementById('cantidad').value = "";
			document.getElementById('proviene').value = "";
		}

		function llenarDatos(id, fecha_ingreso, cantidad, proviene){
			// console.log(id, cantidad, proviene, fecha_ingreso);
			document.getElementById('id2').setAttribute('value', id);
			document.getElementById('cantidad2').setAttribute('value', cantidad);
			document.getElementById('proviene2').setAttribute('value', proviene);
			document.getElementById('fecha_ingreso2').setAttribute('value', fecha_ingreso);
		}

		function eliminar(id){
			Swal.fire({
				title: '¿Deseas Eliminar el Ingreso?',
				icon: 'question',
				text: 'No podras Recuperar esta información',
				showCancelButton: true,
				confirmButtonColor: '#dc3545',
				confirmButtonText: 'Eliminar',
				cancelButtonColor: '#0dcaf0',
				cancelButtonText: 'Cancelar',
			}).then((result) => {
				if(result.isConfirmed) {
					$.post("{{route('eliminar')}}",{
						"_token": "{{csrf_token()}}",
						id: id,
					}, function (data) {
						if (data == 'success') {
						Swal.fire({
							title: 'Eliminado',
							text: "Se ha eliminado el registro.",
							icon: 'success',
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'De acuerdo',
						}).then((result) => {
							if (result.isConfirmed) {
								$('#removerId' + id).remove();
								// location.reload();
							} else {
								$('#removerId' + id).remove();
								// location.reload();
							}
						})
					} else if (data == 'denied') {
						Swal.fire({
							title: 'No se ha eliminado.',
							text: 'No fue posible eliminar el registro, el expediente ya cuenta con un responsable.',
							icon: 'error',
							confirmButtonText: 'De acuerdo'
						})
					}
					});
				}
			});
		}
	</script>
@endsection
