<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\PaymentService;
use App\Models\Order;

class CheckPaymentStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payment_id;
    protected $payment_client;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $payment_id,  $payment_client)
    {
        $this->payment_client = $payment_client;
        $this->payment_id = $payment_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentService $service)
    {
        $client = $service->getClient($this->payment_client);

        if ($client->paymentSucceeded($this->payment_id)) {
            $order = Order::wherePayment($this->payment_id)->first();

            $order->setAttribute('status', $order::SUCCEEDED);
            $order->save();
        } else {
            sleep(2);
            static::dispatch($this->payment_id, $this->payment_client)
                ->delay(now()->addSeconds(5));
        }

    }
}
