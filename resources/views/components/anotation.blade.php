@props(['type' => 'info', 'show' => false])

<div x-data="anotation()" class="flex items-center m-4 p-2 text-sm border rounded-lg" :class="getColors()" role="alert">
	<i class="fa-solid fa-circle-info mr-3"></i>
	<span class="sr-only">Info</span>
	<div class="text-ellipsis overflow-hidden">
		<span class="font-small" x-text="text[type]"></span>
		{{ $slot }}
	</div>
</div>

@push('scripts')
	<script>
		function anotation() {
			return {
				show: @js($show),
				type: @js($type),
				text: {
					info: '{{ __('Info!') }}',
					danger: '{{ __('Danger!') }}',
					success: '{{ __('Success!') }}',
					warning: '{{ __('Warning!') }}',
					dark: '{{ __('Alert!') }}',
				},
				colors: {
					text: {
						info: 'text-blue-800 dark:text-blue-400',
						danger: 'text-red-800 dark:text-red-400',
						success: 'text-green-800 dark:text-green-400',
						warning: 'text-yellow-800 dark:text-yellow-300',
						dark: 'text-gray-800 dark:text-gray-300',
					},
					border: {
						info: 'border-blue-300 dark:border-blue-800',
						danger: 'border-red-300 dark:border-red-800',
						success: 'border-green-300 dark:border-green-800',
						warning: 'border-yellow-300 dark:border-yellow-800',
						dark: 'border-gray-300 dark:border-gray-600',
					},
					background: {
						info: 'bg-blue-50 dark:bg-gray-800',
						danger: 'bg-red-50 dark:bg-gray-800',
						success: 'bg-green-50 dark:bg-gray-800',
						warning: 'bg-yellow-50 dark:bg-gray-800',
						dark: 'bg-gray-50 dark:bg-gray-800',
					}
				},
				getColors() {
					let new_class = `${this.colors.text[this.type]} ${this.colors.border[this.type]} ${this.colors.background[this.type]}`;
					return new_class;
				}
			}
		}
	</script>
@endpush
