<section>
	<header>
		<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
			{{ __('Global account') }}
		</h2>

		<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
			{{ __('You have :count in your global account.', ['count' => auth()->user()->total_count]) }}
		</p>
	</header>
	<div>
		<div class="flex justify-end" x-data>
			<x-primary-button @click="$dispatch('open-modal', 'NewRegister')"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;{{ __('Register activity') }}</x-primary-button>
		</div>
		<div class="grid grid-cols-3 gap-6" x-data="dates()" x-init="stablish_date()">
			<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 sm:rounded-lg">
				<x-input-label for="from_date" :value="__('From Date')" />
				<x-text-input name="from_date" x-model="from_date" type="date" class="mt-1 block w-full" />
			</div>
			<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 sm:rounded-lg">
				<x-input-label for="to_date" :value="__('To Date')" />
				<x-text-input name="to_date" x-model="to_date" type="date" class="mt-1 block w-full" />
			</div>
			<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 sm:rounded-lg flex items-center">
				<x-secondary-button class="mt-5"
					@click="$dispatch('update-data');
        			rotate = true;
        			setTimeout(() => rotate = false, 2000);">
					<i class="fa-solid fa-arrows-rotate" :class="rotate ? 'fa-spin' : ''"></i>&nbsp;&nbsp;{{ __('Update Info') }}
				</x-secondary-button>
			</div>
		</div>
	</div>
</section>

<x-modal name="NewRegister" class="mx-auto max-w-lg" id="NewRegister">
	<div x-data="RegisterActivity()" x-init="setAndFilterActivies(@js($type_activities), @js($activities), @js($my_accounts))">
		<div>
			<x-input-label for="account" :value="__('Account')" />
			<x-select name="account" class="mt-1 block w-full" x-model="activity.account.data">
				<option value="">{{ __('Select one option') }}</option>
				<template x-for="account in accounts">
					<option :value="account.id" x-text="account.name + (account.is_card == 1 ? ' ' + account.number.slice(-4) : '')"></option>
				</template>
			</x-select>

			<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="activity.account.error"></p>
		</div>
		<div>
			<x-input-label for="type_activity" :value="__('Activity type')" />
			<x-select name="type_activity" class="mt-1 block w-full" x-model="activity.type_activity.data">
				<option value="">{{ __('Select one option') }}</option>
				<template x-for="type in type_activities">
					<option :value="type.id" x-text="type.name"></option>
				</template>
			</x-select>

			<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="activity.type_activity.error"></p>
		</div>
		<div>
			<x-input-label for="activity" :value="__('Activity')" />

			<x-select name="activity" class="mt-1 block w-full" x-bind:disabled="choose_type" x-model="activity.activity.data">
				<option value="">{{ __('Select one option') }}</option>
				<template x-for="activity in filter_activities">
					<option :value="activity.id" x-text="activity.name"></option>
				</template>
			</x-select>

			<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="activity.activity.error"></p>
		</div>
		<div>
			<x-input-label for="activity_amount" :value="__('Activity amount')" />
			<x-text-input name="activity_amount" x-model="activity.amount.data" :class="activity.amount.error ? 'is_invalid' : ''" class="mt-1 block w-full pl-4" autocomplete="off" :placeholder="__('amount of activity')" x-mask:dynamic="$money($input)" @focus="$event.target.select()" />
			<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="activity.amount.error"></p>
		</div>
		<div>
			<x-input-label for="activity_description" :value="__('Activity description').' '.__('(Optional)')" />
			<x-text-input name="activity_description" x-model="activity.description.data" type="text" :class="activity.description.error ? 'is_invalid' : ''" class="mt-1 block w-full" :placeholder="__('Description of activity')" autocomplete="off" />
		</div>
		<div>
			<x-input-label for="activity_date" :value="__('Activity date')" />
			<x-text-input name="activity_date" x-model="activity.date.data" type="date" :class="activity.date.error ? 'is_invalid' : ''" class="mt-1 block w-full" />
			<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="activity.date.error"></p>
		</div>
		<center class="mt-10">
			<x-secondary-button @click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
			<x-primary-button @click="saveNewActivity">{{ __('Save') }}</x-primary-button>
		</center>
	</div>
</x-modal>
@push('scripts')
	<script>
		function dates() {
			return {
				from_date: null,
				to_date: null,
				rotate: false,
				stablish_date() {
					this.$watch('from_date', value => {
						document.dispatchEvent(new CustomEvent('set-from', {
							detail: value
						}));
					});
					this.$watch('to_date', value => {
						document.dispatchEvent(new CustomEvent('set-to', {
							detail: value
						}));
					});
					let date = getDatesLastMonth();
					this.from_date = date[0];
					this.to_date = date[1];
				},
			}
		}

		function RegisterActivity() {
			return {
				choose_type: true,
				type_activities: null,
				activities: null,
				accounts: null,
				filter_activities: null,
				activity: {
					account: {
						data: null,
						error: null,
					},
					type_activity: {
						data: null,
						error: null,
					},
					activity: {
						data: null,
						error: null,
					},
					description: {
						data: null,
						error: null,
					},
					date: {
						data: new Date().toLocaleString('sv-SE', DATE_OPTIONS).split(' ')[0],
						error: null,
					},
					amount: {
						data: null,
						error: null,
					},
				},
				setAndFilterActivies(type_activities, activities, accounts) {
					this.type_activities = type_activities;
					this.activities = activities;
					this.accounts = accounts;

					this.$watch('activity.type_activity.data', value => {
						this.activity.type_activity.data = value;
						this.choose_type = value == '';
						this.filter_activities = activities.filter(activity => activity.type_id === value);
					});
				},
				validarInfo() {
					this.activity.account.error = this.activity.account.data == '' || this.activity.account.data == null ? 'La cartera es requerida.' : null;
					this.activity.type_activity.error = this.activity.type_activity.data == '' || this.activity.type_activity.data == null ? 'El tipo de actividad es requerido.' : null;
					this.activity.activity.error = this.activity.activity.data == '' || this.activity.activity.data == null ? 'La actividad es requerida.' : null;
					this.activity.date.error = this.activity.date.data == '' || this.activity.date.data == null ? 'La fecha es requerida.' : null;
					this.activity.amount.error = this.activity.amount.data == '' || this.activity.amount.data == null ? 'La cantidad es requerida.' : (this.activity.amount.data <= 0 ? 'La cantidad no puede ser menor a 1' : null);

					return (this.activity.account.error == null &&
						this.activity.type_activity.error == null &&
						this.activity.activity.error == null &&
						this.activity.date.error == null &&
						this.activity.amount.error == null
					);
				},
				saveNewActivity() {
					if (this.validarInfo()) {
						const data = new FormData();
						let url = "{{ route('store_activity') }}";

						data.append('_token', _TOKEN);
						data.append('account_money_id', this.activity.account.data);
						data.append('type_activity_id', this.activity.type_activity.data);
						data.append('activity_id', this.activity.activity.data);
						data.append('description', this.activity.description.data);
						data.append('date', this.activity.date.data);
						data.append('amount', parseCurrency(this.activity.amount.data));

						fetch(url, {
								method: "POST",
								body: data,
							})
							.then((res) => {
								if (res.ok) return res.json();
								return res.status;
							})
							.then((data) => {
								processJsonResponse(data);
								this.closeModalAndUpdateGrafics();
							})
							.catch((e) => {
								processJsonResponse(e);
							})
					}
				},
				closeModalAndUpdateGrafics() {
					this.clearData();
					this.$dispatch('close');
					this.$dispatch('update-data');
				},
				clearData() {
					this.activity = {
						account: {
							data: null,
							error: null,
						},
						type_activity: {
							data: null,
							error: null,
						},
						activity: {
							data: null,
							error: null,
						},
						description: {
							data: null,
							error: null,
						},
						date: {
							data: new Date().toLocaleString('sv-SE', DATE_OPTIONS).split(' ')[0],
							error: null,
						},
						amount: {
							data: null,
							error: null,
						},
					}
				}
			}
		}
	</script>
@endpush
