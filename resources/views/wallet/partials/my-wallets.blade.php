<section>
	<header class="flex items-center justify-between">
		<div>
			<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
				{{ __('Wallet') }}
			</h2>
			<p class="m-1 text-sm text-gray-600 dark:text-gray-400">
				{{ __('Here you can see and can update your accounts') }}
			</p>
		</div>
	</header>

	<div x-data="my_wallet()" x-init="getWallets()">
		<div id="card" class="md:pl-4">
			<template x-if="has_wallets">
				<div class="card-body pl-3 md:pl6">
					<table class="table-auto w-full text-left border-collapse border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
						<thead>
							<tr class="bg-gray-100 dark:bg-gray-700">
								<th class="px-4 py-2 border-b dark:border-gray-600">#</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">{{ __('Name') }}</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">{{ __('Amount') }}</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">{{ __('Is Card') }}</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">{{ __('Is Active') }}</th>
								<th class="px-4 py-2 border-b dark:border-gray-600">{{ __('Actions') }}</th>
							</tr>
						</thead>
						<tbody>
							<template x-for="(wallet, index) in wallets" :key="wallet.id">
								<tr class="border-b dark:border-gray-600">
									<td class="px-4 py-2" x-text="index + 1"></td>
									<td class="px-4 py-2">
										<p class="dark:text-white" x-text="wallet.name"></p>
									</td>
									<td class="px-4 py-2">
										<p class="dark:text-white" x-text="wallet.amount"></p>

									</td>
									<td class="px-4 py-2">
										&nbsp;&nbsp;<i class="fa-solid dark:text-white" :class="wallet.is_card == 1 ? 'fa-credit-card' : 'fa-sack-dollar'"></i>
									</td>
									<td class="px-4 py-2">
										&nbsp;&nbsp;<i class="fa-solid dark:text-white" :class="wallet.is_active == 1 ? 'fa-check' : 'fa-xmark'"></i>

									</td>
									<td class="px-4 py-2">
										<button class="px-4 py-2 text-sm font-medium text-white bg-yellow-700 rounded hover:bg-yellow-800 dark:bg-yellow-600 dark:hover:bg-yellow-700" @click="$dispatch('open-modal', 'EditWallet'); $dispatch('edit-wallet', wallet)">
											<i class="fa-solid fa-pen-to-square"></i>
										</button>
									</td>
								</tr>
							</template>
						</tbody>
					</table>
				</div>
			</template>
			<template x-if="!has_wallets">
				<div class="row">
					<div class="column-content">
						<h2 class="no-data-text">{{ __('no.data') }}</h2>
					</div>
				</div>
			</template>
		</div>
	</div>

	<x-modal name="EditWallet" class="mx-auto max-w-lg" id="EditWallet" show>
		<div x-data="edit_wallet()" @edit-wallet.window="update_wallet($event.detail)">
			<div>
				<x-input-label for="wallet_name" :value="__('Name')" />
				<x-text-input name="wallet_name" x-model="wallet.name.data" type="text" :class="wallet . name . error ? 'is_invalid' : ''" class="mt-1 block w-full" />
				<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="wallet.name.error"></p>
			</div>
			<div>
				<x-input-label for="wallet_amount" :value="__('Amount')" />
				<x-text-input name="wallet_amount" x-model="wallet.amount.data" type="text" :class="wallet . amount . error ? 'is_invalid' : ''" class="mt-1 block w-full" />
				<p class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-2" x-text="wallet.amount.error"></p>
			</div>
			<div class="grid grid-cols-4 gap-6 mt-10">
				<div class="col-span-2">
					<label class="inline-flex items-center cursor-pointer">
						<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Is Card') }}</span>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" x-model="wallet.is_card.data" :checked="wallet.is_card.data ? true : false" :name="'wallet-active-' + wallet.id" class="block w-full sr-only peer wallets">
						<div
							class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
						</div>
					</label>
				</div>
				<div class="col-span-2">
					<label class="inline-flex items-center cursor-pointer">
						<span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('Is Active') }}</span>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" x-model="wallet.is_active.data" :checked="wallet.is_active.data ? true : false" :name="'wallet-active-' + wallet.id" class="block w-full sr-only peer wallets">
						<div
							class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
						</div>
					</label>
				</div>
			</div>
			<center class="mt-10">
				<x-secondary-button>{{ __('Cancel') }}</x-secondary-button>
				<x-primary-button>{{ __('Save') }}</x-primary-button>
			</center>
		</div>
	</x-modal>
</section>
@push('scripts')
	<script>
		function my_wallet() {
			return {
				has_wallets: false,
				wallets: [],
				clone_wallets: [],
				async getWallets() {
					let url = "{{ route('wallet.my_wallets') }}"
					await fetch(url)
						.then((res) => res.json())
						.then((data) => {
							this.wallets = data;
							this.clone_wallets = data;
							if (data.length != 0) {
								this.has_wallets = true;
							} else {
								this.has_wallets = false;
							}
						})
				},
			}
		}

		function edit_wallet() {
			return {
				wallet: {
					name: {
						data: null,
						error: null,
					},
					amount: {
						data: null,
						error: null,
					},
					is_active: {
						data: false,
						error: null,
					},
					is_card: {
						data: false,
						error: null,
					},
				},
				update_wallet(wallet) {
					console.log("🚀 ~ update_wallet ~ wallet:", wallet);
					this.wallet.name.data = wallet.name;
					this.wallet.amount.data = wallet.amount;
					this.wallet.is_active.data = wallet.is_active;
					this.wallet.is_card.data = wallet.is_card;
				},
			}
		}
	</script>
@endpush
