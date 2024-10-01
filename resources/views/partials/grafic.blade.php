<section>
	<header class="flex items-center justify-between">
		<div>
			<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
				{{ __('Movements') }}
			</h2>
			<p class="m-1 text-sm text-gray-600 dark:text-gray-400">
				{{ __('Here you can see the general movement per day') }}
			</p>
		</div>
	</header>
	<div x-data="show_grafics()" x-init="run_data" @update-data.window="show_canvas">
		<template x-if="!hide_canvas">
			<div id="container">
			</div>
		</template>
		<template x-if="hide_canvas">
			<div class="row pt-8">
				<div class="column-content">
					<h2 class="no-data-text">{{ __('no.data') }}</h2>
				</div>
			</div>
		</template>
	</div>
</section>
@push('scripts')
	<script>
		function show_grafics() {
			return {
				from_date: null,
				to_date: null,
				data: null,
				hide_canvas: true,
				run_data() {
					document.addEventListener('set-from', (event) => this.handleSetFrom(event));
					document.addEventListener('set-to', (event) => this.handleSetTo(event));
				},
				handleSetFrom(event) {
					// this.hide_canvas = true;
					this.from_date = event.detail;
					this.show_canvas();
				},
				handleSetTo(event) {
					// this.hide_canvas = true;
					this.to_date = event.detail;
					this.show_canvas();
				},
				async show_canvas() {
					if (!this.to_date || !this.from_date) return;
					this.destroyCanvas();

					this.data = await this.get_data();
					if (this.data.datasets.length) {
						this.hide_canvas = false;
						setTimeout(() => {
							this.canv()
						}, 1);
					} else {
						this.hide_canvas = true;
					}
				},
				canv() {
					const canvas = this.createCanvas();
					const container = document.getElementById("container");

					container.appendChild(canvas);
					new Chart(canvas, {
						type: 'line',
						data: this.data,
						options: {
							responsive: true,
							plugins: {
								legend: {
									position: 'top',
								},
								title: {
									display: true,
									text: "{{ __('Movements') }}"
								}
							}
						},
					});
				},
				async get_data() {
					const url = "{{ route('movements_format') }}";
					const data = new FormData();
					data.append('from_date', this.from_date);
					data.append('to_date', this.to_date);
					data.append('_token', _TOKEN);
					return await fetch(url, {
							method: 'POST',
							body: data,
						})
						.then((res) => res.json())
						.then((data) => {
							return data;
						})
						.catch((e) => {
							console.error(e);
							return null;
						});
				},
				createCanvas() {
					const canvas = document.createElement('canvas');
					canvas.id = "grafics_movements";
					return canvas;
				},
				destroyCanvas() {
					const container = document.getElementById("container");
					if (container) container.innerHTML = '';
				}
			}
		}
	</script>
@endpush
