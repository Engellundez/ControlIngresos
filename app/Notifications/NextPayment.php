<?php

namespace App\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NextPayment extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 */
	public function __construct(private Activity $activity) {}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @return array<int, string>
	 */
	public function via(object $notifiable): array
	{
		return ['database']; // borrar
		return ['database','broadcast'];
	}

	/**
	 * Get the broadcast representation of the notification.
	 */
	public function toBroadcast(object $notifiable): BroadcastMessage
	{
		return new BroadcastMessage([
			// 'invoice_id' => $this->invoice->id,
		]);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return array<string, mixed>
	 */
	public function toDatabase(object $notifiable): array
	{
		// $account = $this->activity->account_money;
		// $dates = Controller::setCutDateAndPaymentDeadlineToNow($account->creditCard->cut_off_date, $account->creditCard->payment_deadline);
		// $this->activity->payment_method_id = 37;
		// dd($this->activity->amount, (int) $this->activity->payment_method->description);

		return [
			'activity_id' => $this->activity->id,
		];
	}
}
