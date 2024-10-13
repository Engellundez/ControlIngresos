<section>
	<header class="flex items-center justify-between">
		<div>
			<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
				{{ __('Debts Manager') }}
			</h2>
			<p class="m-1 text-sm text-gray-600 dark:text-gray-400">
				{{ __('Here you can see and can update your debts') }}
			</p>
		</div>
	</header>

	<div class="flex justify-end mb-5" x-data>
		<x-primary-button @click="$dispatch('new-debt')"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;{{ __('Register debt') }}</x-primary-button>
	</div>
	<div x-data="my_debts()" x-init="getMyDebts()" class="mt-5">
		<div id="card" class="md:pl-4" @reload-debts.window="getMyDebts()">
			<template x-if="has_debts">
				<div class="card-body pl-3 md:pl6">
					<table class="table-auto w-full text-left border-collapse border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
						<thead>
							{{-- <tr class="bg-gray-100 dark:bg-gray-700">
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
							</tr> --}}
						</thead>
						<tbody>
							{{-- <template x-for="(account, index) in accounts" :key="index">
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
											<p class="dark:text-white" x-text="formatCurrency(account.amount)"></p>
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
							</template> --}}
						</tbody>
					</table>
				</div>
			</template>
			<template x-if="!has_debts">
				<div class="row">
					<div class="column-content">
						<center>
							<h2 class="no-data-text">{{ __('no.data') }}</h2>
							<br>
							<x-secondary-button @click="getMyDebts()">{{ __('refresh') }}</x-secondary-button>
						</center>
					</div>
				</div>
			</template>
		</div>
	</div>
</section>
@push('scripts')
	<script>
		function my_debts(){
			return {
				has_debts: false,
				getMyDebts(){

				}
			}
		}
	</script>
@endpush
