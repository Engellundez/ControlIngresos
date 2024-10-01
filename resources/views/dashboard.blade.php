<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Dashboard') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<!-- Título de las columnas -->
			<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
				<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
					@include('partials.my-account')
				</h2>
			</div>

			<!-- Contenido de las columnas -->
			<div class="grid grid-cols-5 gap-6">
				<!-- Primera columna: ocupa 2/5 del espacio -->
				<div class="col-span-2 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
					@include('partials.last-movements')
				</div>

				<!-- Segunda columna: ocupa 3/5 del espacio -->
				<div class="col-span-3 p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
					@include('partials.grafic')
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
		<script>
			function getDatesLastMonth() {
				let to_date = new Date();
				let from_date = new Date(to_date); // Copiar la fecha actual
				from_date.setMonth(from_date.getMonth() - 1); // Restar un mes

				// Formatear las fechas según la zona horaria especificada
				from_date = from_date.toLocaleString('sv-SE', DATE_OPTIONS).split(' ')[0];
				to_date = to_date.toLocaleString('sv-SE', DATE_OPTIONS).split(' ')[0];

				return [from_date, to_date];
			}
		</script>
	@endpush
</x-app-layout>
