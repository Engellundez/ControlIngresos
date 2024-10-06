<section>
	<header class="flex items-center justify-between">
		<div>
			<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
				{{ __('Last movements') }}
			</h2>
			<p class="m-1 text-sm text-gray-600 dark:text-gray-400">
				{{ __('Here you can see the latest movements of your accounts.') }}
			</p>
		</div>
		<a href="#" class="link-header-card">
			{{ __('View all') }}
		</a>
	</header>


	<div x-data="last_moves()" x-init="icons = @js($icons);
	colors = @js($colors);
	symbols = @js($symbols);
	accountsIcons = @js($accountsIcons);
	initial();" @update-data.window="getActivities">
		<div id="card" class="md:pl-4">
			<div class="card-body pl-3 md:pl6">
				<ul role="list" class="list">
					<div x-show="activities.length > 0">
						<template x-for="activity in activities">
							<li class="item-list">
								<div class="row">
									<div class="column-image relative">
										<i class="fa-solid" :class="getIconTypeAccount(activity) + ' ' + getColor(activity)"></i>
										<i class="secondary-image fa-solid absolute" :class="icons[activity.activitable_type] + ' ' + getColor(activity)"></i>
									</div>
									<div class="column-content">
										<p class="principal-text" x-text="titleActivity(activity.account_money_name,activity.description)"></p>
										<p class="secondary-text" x-text="activity.motion"></p>
										<small class="secondary-text" x-text="activity.formatted_activity_date"></small>
									</div>
									<div class="column-mount" :class="getColor(activity)" x-text="symbols[activity.activitable_type] + formatCurrency(activity.amount)"></div>
								</div>
							</li>
						</template>
					</div>
					<div x-show="activities.length <= 0">
						<li class="item-list">
							<div class="row">
								<div class="column-content">
									<h2 class="no-data-text">{{ __('no.data') }}</h2>
								</div>
							</div>
						</li>
					</div>
				</ul>
			</div>
		</div>
	</div>

</section>
@push('scripts')
	<script>
		function last_moves() {
			return {
				icons: null,
				colors: null,
				symbols: null,
				activities: [],
				accountsIcons: null,
				list_open_index: 0,
				from_date: null,
				to_date: null,
				initial() {
					document.addEventListener('set-from', (event) => this.handleSetFrom(event));
					document.addEventListener('set-to', (event) => this.handleSetTo(event));
				},
				handleSetFrom(event) {
					this.from_date = event.detail;
					this.getActivities();
				},
				handleSetTo(event) {
					this.to_date = event.detail;
					this.getActivities();
				},
				async getActivities() {
					if (!this.to_date || !this.from_date) return;

					const data = new FormData();
					const URL = "{{ route('movements') }}";

					data.append('from_date', this.from_date);
					data.append('to_date', this.to_date);
					data.append('_token', _TOKEN);

					await fetch(URL, {
							method: 'POST',
							body: data,
						})
						.then((res) => {
							if (res.ok) return res.json();
							return res.status;
						})
						.then((data) => {
							this.activities = data;
							while (this.activities.length > 4) {
								this.activities.pop();
							}
						})
						.catch((e) => {
							console.error(e);
							this.activities = null;
						})
				},
				titleActivity(account = null, description = null) {
					let text = account;
					if (description != null && description != 'null' && description != '') {
						text += ' > ' + description
					};
					return text;
				},
				getIconTypeAccount(activity) {
					return this.accountsIcons[activity.account_money.is_card == 1 ? (activity.account_money.is_credit == 1 ? 2 : 1) : 0];
				},
				getColor(activity) {
					// console.log("🚀 ~ getColor ~ this.colors:", this.colors)
					// console.log("🚀 ~ getColor ~ this.colors[activity.activitable_type]:", this.colors[activity.activitable_type])
					return this.colors[activity.activitable_type];
				}
			}
		}
	</script>
@endpush
