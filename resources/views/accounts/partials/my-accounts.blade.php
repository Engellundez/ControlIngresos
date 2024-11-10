<section>
	<header class="flex items-center justify-between">
		<div>
			<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
				{{ __('Accounts Manager') }}
			</h2>
			<p class="m-1 text-sm text-gray-600 dark:text-gray-400">
				{{ __('Here you can see and can update your accounts') }}
			</p>
		</div>
	</header>

	<div class="flex justify-end mb-5" x-data>
		<x-primary-button @click="$dispatch('new-account')"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;{{ __('Register account') }}</x-primary-button>
	</div>
	<div x-data="my_accounts()" x-init="getMyAccounts()" class="mt-5">
		<div id="card" class="md:pl-4" @reload-accounts.window="getMyAccounts()">
			<template x-if="has_accounts">
				<div class="card-body pl-3 md:pl6">
					<table class="table-auto w-full text-left border-collapse border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
						<thead>
							<tr class="bg-gray-100 dark:bg-gray-700">
								<th class="px-4 py-2 border-b dark:border-gray-600">
									<center>#</center>
								</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">
									<center>{{ __('Name') }}</center>
								</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">
									<center>{{ __('Amount') }}</center>
								</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">
									<center>{{ __('Is Card') }}</center>
								</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">
									<center>{{ __('Is Active') }}</center>
								</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">
									<center>{{ __('Actions') }}</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<template x-for="(account, index) in accounts" :key="index">
								<tr class="border-b dark:border-gray-600">
									<td class="px-4 py-2">
										<center x-text="index + 1"></center>
									</td>
									<td class="px-4 py-2">
										<center>
											<p class="dark:text-white" x-text="account.name"></p>
											<p class="dark:text-white" x-show="account.is_card == '1'" x-text="'**** '+ account.number"></p>
										</center>
									</td>
									<td class="px-4 py-2">
										<center>
											<template x-if="account.is_credit == 1">
												<div>
													<p class="text-red-800" x-text="getCreditDebt(account)" x-show="getCreditDebt(account) != '$0.00'"></p>

													<p class="dark:text-white" x-text="formatCurrency(account.amount)"></p>
												</div>
											</template>
											<template x-if="account.is_credit == 0">
												<p class="dark:text-white" x-text="formatCurrency(account.amount)"></p>
											</template>
										</center>
									</td>
									<td class="px-4 py-2">
										<center><i class="fa-solid dark:text-white" :class="account.is_card == 1 ? (account.is_credit == 1 ? 'fa-money-check-dollar' : 'fa-credit-card') : 'fa-sack-dollar'"></i></center>
									</td>
									<td class="px-4 py-2">
										<center><i class="fa-solid dark:text-white" :class="account.is_active == 1 ? 'fa-check' : 'fa-xmark'"></i></center>
									</td>
									<td class="px-4 py-2">
										<center class="grid grid-cols-2 gap-5">
											<button class="py-2 text-sm font-medium text-white bg-yellow-400 rounded hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-500" @click="$dispatch('edit-account', account.id_crypt)"><i class="fa-solid fa-pen-to-square"></i></button>
											<button class="py-2 text-sm font-medium text-white bg-red-500 rounded hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-400" @click="deleteAccount(account)"><i class="fa-solid fa-trash"></i></button>
										</center>
									</td>
								</tr>
							</template>
						</tbody>
					</table>
				</div>
			</template>
			<template x-if="!has_accounts">
				<div class="row">
					<div class="column-content">
						<center>
							<h2 class="no-data-text">{{ __('no.data') }}</h2>
							<br>
							<x-secondary-button @click="getMyAccounts()">{{ __('refresh') }}</x-secondary-button>
						</center>
					</div>
				</div>
			</template>
		</div>
	</div>

	<x-modal name="NewOrEditAccount" class="mx-auto max-w-lg" id="NewOrEditAccount">
		<div x-data="new_or_edit_account()" @edit-account.window="updateAccount($event.detail)" @new-account.window="newAccount()" @keyup.enter="save()">
			<center>
				<h2>
					<div class="grid grid-cols-4 gap-1">
						<span></span>
						<i class="fa-solid dark:text-white" :class="account.is_card.data ? (account.is_credit.data ? 'fa-money-check-dollar' : 'fa-credit-card') : 'fa-sack-dollar'"></i>
						<i class="fa-solid dark:text-white" :class="account.is_active.data ? 'fa-check' : 'fa-xmark'"></i>
						<span></span>
					</div>
				</h2>
			</center>
			<div class="grid grid-cols-3 gap-4 mt-10">
				<div>
					<label class="inline-flex items-center cursor-pointer">
						<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Is Active') }}</span>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" x-model="account.is_active.data" :checked="account.is_active.data ? true : false" :name="'account-active-' + account.id" class="block w-full sr-only peer accounts">
						<div
							class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
						</div>
					</label>
				</div>
				<div>
					<label class="inline-flex items-center cursor-pointer">
						<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Is Card') }}</span>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" x-model="account.is_card.data" :checked="account.is_card.data ? true : false" :name="'account-active-' + account.id" class="block w-full sr-only peer accounts">
						<div
							class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
						</div>
					</label>
				</div>
				<div x-show="account.is_card.data" x-transition>
					<label class="inline-flex items-center cursor-pointer">
						<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Is Credit Card') }}</span>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" x-model="account.is_credit.data" :checked="account.is_credit.data ? true : false" :name="'account-active-' + account.id" class="block w-full sr-only peer accounts">
						<div
							class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
						</div>
					</label>
				</div>
			</div>
			<div class="mt-5">
				<x-input-label for="account_name" :value="__('Name')" />
				<x-text-input name="account_name" x-model="account.name.data" autocomplete="off" type="text" :class="account.name.error ? 'is_invalid' : ''" class="mt-1 block w-full" :placeholder="__('Name')" @input="$event.target.value = $event.target.value.toUpperCase()" />
				<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="account.name.error"></p>
			</div>
			<div>
				<x-input-label for="account_amount" :value="__('Amount')" />
				<x-text-input name="account_amount" x-model="account.amount.data" type="text" :class="account.amount.error ? 'is_invalid' : ''" class="mt-1 block w-full" :placeholder="__('Amount')" x-mask:dynamic="$money($input)" @focus="$event.target.select()" />
				<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="account.amount.error"></p>
			</div>
			<div class="mt-5" x-show="account.is_card.data" x-transition>
				<x-input-label for="card_number" :value="__('Number')" />
				<x-text-input id="card_number" name="card_number" type="text" x-model="account.number.data" :class="account.number.error ? 'is_invalid' : ''" class="mt-1 block w-full pl-4" placeholder="0" autocomplete="off" @input="$event.target.value = formatCreditCard($event.target.value)" @focus="$event.target.select()" />
				<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="account.number.error"></p>
			</div>
			<div class="mt-4" x-show="account.is_credit.data && account.is_card.data" x-transition>
				<x-anotation type="info">{{ __('We remind you that since it is a credit card, the money will be handled as negative when shown in the graphs and other sections.') }}</x-anotation>
				<div>
					<x-input-label for="credit_limit" :value="__('Credit limit')" />
					<x-text-input id="credit_limit" name="credit_limit" type="text" x-model="account.credit.limit.data" :class="account.credit.limit.error ? 'is_invalid' : ''" class="mt-1 block w-full pl-4" placeholder="0" autocomplete="off" x-mask:dynamic="$money($input)" />
					<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="account.credit.limit.error"></p>
				</div>
				<div class="grid grid-cols-2 gap-4">
					<div>
						<x-input-label for="credit_cutdate" :value="__('Cut-off date')" />
						<x-text-input name="credit_cutdate" x-model="account.credit.cutdate.data" type="date" :class="account.credit.cutdate.error ? 'is_invalid' : ''" class="mt-1 block w-full" :placeholder="__('Cut-off date')" />
						<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="account.credit.cutdate.error"></p>
					</div>
					<div>
						<x-input-label for="credit_deadline" :value="__('Payment deadline')" />
						<x-text-input name="credit_deadline" x-model="account.credit.deadline.data" type="date" :class="account.credit.deadline.error ? 'is_invalid' : ''" class="mt-1 block w-full" :placeholder="__('Payment deadline')" />
						<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="account.credit.deadline.error"></p>
					</div>
				</div>
			</div>
			<center class="mt-10">
				<x-secondary-button @click="$dispatch('close')">{{ __('Cancel') }}</x-secondary-button>
				<x-primary-button x-text="save_button" @click="save()"></x-primary-button>
			</center>
		</div>
	</x-modal>

	<x-modal name="ShowInfoAccount" class="mx-auto max-w-lg" id="ShowInfoAccount">

	</x-modal>
</section>
@push('scripts')
	<script>
		function show_account() {
			return {

			}
		}

		function my_accounts() {
			return {
				has_accounts: false,
				accounts: [],
				async getMyAccounts() {
					let url = "{{ route('accounts.my_accounts') }}"
					await fetch(url)
						.then((res) => {
							if (res.ok) return res.json();
							return Promise.reject(new Error(res.statusText || 'Error en la solicitud'));
						})
						.then((data) => {
							this.accounts = data;
							if (data.length != 0) {
								this.has_accounts = true;
							} else {
								this.has_accounts = false;
							}
						}).catch((error) => {
							processJsonResponse(error.message);
						});
				},
				deleteAccount(account) {
					if (account.is_card == 1) {
						name = account.name + ' ' + account.number.slice(-4);
					} else {
						name = account.name
					}

					Swal.fire({
						icon: "question",
						title: `{{ __('Delete account whit name :name', ['name' => '${name}']) }}`,
						text: "{{ __('Please note that this action is not reversible.') }}",
						showCancelButton: true,
						cancelButtonText: "{{ __('Cancel') }}",
						confirmButtonText: "{{ __('Confirm') }}",
					}).then((result) => {
						if (result.isConfirmed) {
							let payload = new FormData();
							payload.append("_token", _TOKEN);
							payload.append("id", account.id_crypt);
							payload.append("_method", 'DELETE');

							let url = "{{ route('accounts.delete_account') }}";
							fetch(url, {
								method: 'POST',
								body: payload,
							}).then((res) => {
								if (res.ok) return res.json();
								return Promise.reject(new Error(res.statusText || 'Error en la solicitud'));
							}).then((response) => {
								processJsonResponse(response);
								this.$dispatch('reload-accounts');
							}).catch((error) => {
								processJsonResponse(error.message);
							})
						}
					});
				},
				getCreditDebt(account) {
					let amount = account.credit_card.limit_credit - account.amount;
					return formatCurrency(amount);
				}
			}
		}

		function new_or_edit_account() {
			return {
				account: {
					id: null,
					name: {
						data: null,
						error: null,
					},
					number: {
						data: null,
						error: null,
					},
					amount: {
						data: 0.00,
						error: null,
					},
					is_active: {
						data: true,
						error: null,
					},
					is_card: {
						data: false,
						error: null,
					},
					is_credit: {
						data: false,
						error: null,
					},
					credit: {
						limit: {
							data: null,
							error: null,
						},
						cutdate: {
							data: new Date().toISOString().split('T')[0],
							error: null,
						},
						deadline: {
							data: new Date().toISOString().split('T')[0],
							error: null,
						},
					},
				},
				save_button: "{{ __('Save') }}",
				open_modal() {
					this.$dispatch('open-modal', 'NewOrEditAccount');
				},
				newAccount() {
					this.resetAccount();
					this.save_button = "{{ __('Create') }}";
					this.open_modal();
				},
				async updateAccount(id) {
					let url = "{{ route('accounts.get_account') }}";
					let payload = new FormData();
					payload.append('id', id)
					payload.append('_token', _TOKEN)
					this.resetAccount();
					this.save_button = "{{ __('Save') }}";
					await fetch(url, {
						method: 'POST',
						body: payload
					}).then((res) => {
						if (res.ok) return res.json();
						return Promise.reject(new Error(res.statusText || 'Error en la solicitud'));
					}).then((account) => {
						this.account.id = account.id_crypt;
						this.account.name.data = account.name;
						this.account.number.data = formatCreditCard(account.number);
						this.account.amount.data = formatCurrency(account.amount);
						this.account.is_active.data = parseInt(account.is_active);
						this.account.is_card.data = parseInt(account.is_card);
						this.account.is_credit.data = parseInt(account.is_credit);

						this.account.credit.limit.data = formatCurrency(account.credit_card?.limit_credit);
						this.account.credit.cutdate.data = account.credit_card?.cut_off_date;
						this.account.credit.deadline.data = account.credit_card?.payment_deadline;
						this.open_modal();
					}).catch((error) => {
						processJsonResponse(error.message);
					});
				},
				resetAccount() {
					this.account = {
						id: null,
						name: {
							data: null,
							error: null,
						},
						number: {
							data: null,
							error: null,
						},
						amount: {
							data: 0.00,
							error: null,
						},
						is_active: {
							data: true,
							error: null,
						},
						is_card: {
							data: false,
							error: null,
						},
						is_credit: {
							data: false,
							error: null,
						},
						credit: {
							limit: {
								data: null,
								error: null,
							},
							cutdate: {
								data: new Date().toISOString().split('T')[0],
								error: null,
							},
							deadline: {
								data: new Date().toISOString().split('T')[0],
								error: null,
							},
						},
					}
				},
				resetError() {
					this.account.name.error = null;
					this.account.amount.error = null;
					this.account.number.error = null;
					this.account.credit.limit.error = null;
					this.account.credit.cutdate.error = null;
					this.account.credit.deadline.error = null;
				},
				validate() {
					this.resetError();

					this.account.name.error = !this.account.name.data ? "{{ __('the name is required') }}" : null;
					this.account.amount.error = (this.account.amount.data && this.account.amount.data <= -1) ? "{{ __('the amount is required') }}" : null;
					if (this.account.is_card.data) {
						this.account.number.error = !this.account.number.data ? "{{ __('the number is requiered') }}" : null;
					}
					if (this.account.is_card.data && this.account.is_credit.data) {
						this.account.credit.limit.error = !this.account.credit.limit.data ? "{{ __('the limit is required') }}" : null;
						this.account.credit.cutdate.error = !this.account.credit.cutdate.data ? "{{ __('the cutdate is required') }}" : null;
						this.account.credit.deadline.error = !this.account.credit.deadline.data ? "{{ __('the deadline is required') }}" : null;
					}
					return (this.account.name.error == null &&
						this.account.amount.error == null &&
						this.account.number.error == null &&
						this.account.credit.limit.error == null &&
						this.account.credit.cutdate.error == null &&
						this.account.credit.deadline.error == null)
				},
				save() {
					if (!this.validate()) return;

					let payload = new FormData();
					payload.append("_token", _TOKEN);
					payload.append("id", this.account.id);
					payload.append("name", this.account.name.data);
					payload.append("amount", parseCurrency(this.account.amount.data));
					payload.append("number", this.account.is_card.data ? this.account.number.data : null);
					payload.append("is_active", this.account.is_active.data);
					payload.append("is_card", this.account.is_card.data);
					payload.append("is_credit", this.account.is_credit.data);
					payload.append("credit_limit", this.account.is_credit.data ? parseCurrency(this.account.credit.limit.data) : null);
					payload.append("credit_cutdate", this.account.is_credit.data ? this.account.credit.cutdate.data : null);
					payload.append("credit_deadline", this.account.is_credit.data ? this.account.credit.deadline.data : null);

					let url = "{{ route('accounts.cu_account') }}";
					fetch(url, {
						method: 'POST',
						body: payload,
					}).then((res) => {
						if (res.ok) return res.json();
						return Promise.reject(new Error(res.statusText || 'Error en la solicitud'));
					}).then((response) => {
						processJsonResponse(response)
						this.$dispatch('close');
						this.$dispatch('reload-accounts');
					}).catch((error) => {
						processJsonResponse(error.message);
					})
				}
			}
		}
	</script>
@endpush
