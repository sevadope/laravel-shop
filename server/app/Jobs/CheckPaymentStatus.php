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
    protected $widget_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $payment_id,  $widget_name)
    {
        $this->widget_name = $widget_name;
        $this->payment_id = $payment_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentService $service)
    {
        $client = $service->getWidget($this->widget_name);

        if ($client->paymentSucceeded($this->payment_id)) {
            $order = Order::wherePayment($this->payment_id)->first();

            $order->setAttribute('status', $order::SUCCEEDED);
            $order->save();
        } else {
            sleep(2);
            static::dispatch($this->payment_id, $this->widget_name)
                ->delay(now()->addSeconds(5));
        }

    }
}
