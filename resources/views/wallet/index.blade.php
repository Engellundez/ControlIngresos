<x-app-layout>
	<x-slot name="header">{{ __('Wallet') }}</x-slot>
	<input type="hidden" name="" class="dark:text-emerald-400 dark:text-red-400 dark:text-sky-300">

	<x-style-body>
		<div data-accordion="open" x-data="accordion()" x-init="wallets = @js($wallets);
icons = @js($icons);
colors = @js($colors);
symbols = @js($symbols);">
			<template x-for="(wallet, index) in wallets">
				<div>
					<h2 @click="list_open_index = list_open_index == index ? null : index">
						<button type="button" class="accordion-header" :class="index == 0 ? 'rounded-t-xl' : ''" data-accordion-target="#accordion-open-body-1" aria-expanded="true" aria-controls="accordion-open-body-1">
							<span class="flex items-center">
								<i class="fa-solid" :class="wallet.is_card == 1 ? 'fa-credit-card' : 'fa-money-bill-wave'"></i>
								&nbsp;&nbsp;
								<span x-text="wallet.name"></span>
							</span>
							<i class="fa-solid" :class="list_open_index != index ? 'fa-chevron-down' : 'fa-chevron-left'"></i>
						</button>
					</h2>
					<div x-show="list_open_index == index" x-transition.duration.300ms :aria-labelledby="'accordion-open-heading-' + index">
						<div class="accordion-body">
							<div id="card" class="md:pl-4">
								<div class="header-card">
									<h5 class="title-header-card"> {{ __('Last movements') }} </h5>
									<a href="#" class="link-header-card">{{ __('View all') }}</a>
								</div>
								<div class="card-body pl-3 md:pl6">
									<ul role="list" class="list">
										<div x-show="wallet.activities.length > 0">
											<template x-for="activity in wallet.activities">
												<li class="item-list">
													<div class="row">
														<div class="column-image"><i class="fa-solid" :class="icons[activity.activitable_type] + ' ' + colors[activity.activitable_type]"></i></div>
														<div class="column-content">
															<p class="principal-text" x-text="activity.motion"></p>
															<p class="secondary-text" x-text="activity.description"></p>
															<p class="secondary-text" x-text="activity.formatted_activity_date"></p>
														</div>
														<div class="column-mount" :class="colors[activity.activitable_type]" x-text="symbols[activity.activitable_type] +' $'+activity.amount"></div>
													</div>
												</li>
											</template>
										</div>
										<div x-show="wallet.activities.length <= 0">
											<li class="item-list">
												<div class="row">
													<div class="column-content">
														<h2 class="no-data-text">{{__('no.data')}}</h2>
													</div>
												</div>
											</li>
										</div>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</template>
		</div>
	</x-style-body>

	@push('scripts')
		<script>
			function accordion() {
				return {
					wallets: null,
					icons: null,
					colors: null,
					symbols: null,
					list_open_index: 0,
					con() {
						console.log(this.wallets,
							this.icons[3],
							this.colors[3],
							this.symbols[3],
						);


					}
				}
			}
		</script>
	@endpush

</x-app-layout>
