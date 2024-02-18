<x-app-layout>
	<x-slot name="header">{{ __('Dashboard') }}</x-slot>

	<x-style-body>
		{{ __('You have $:count in your global account.', ['count' => auth()->user()->total_count]) }}
	</x-style-body>
</x-app-layout>
