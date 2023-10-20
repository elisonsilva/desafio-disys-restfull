<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Notification;
use App\Models\Customer;
use App\Models\Order;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\NotificationFake;
use Tests\TestCase;

class OrderCreatedNotificationTest extends TestCase
{
    public function testOrderNotificationIsQueued()
    {
        // Crie um pedido e um cliente de exemplo (ajuste de acordo com sua estrutura)
        $order = Order::factory()->create();
        $customer = Customer::factory()->create();
        $order->customer_id = $customer->id;
        $order->save();

        // Use a classe NotificationFake para interceptar a notificação
        Notification::fake();

        // Enfileire a notificação
        Notification::send($customer, new OrderCreatedNotification($order));

        // Verifique se a notificação foi enfileirada (neste caso, 1 vez)
        Notification::assertSentTo(
            $customer,
            OrderCreatedNotification::class,
            function ($notification, $channels, $notifiable) use ($order) {
                return $notification->order->id === $order->id;
            }
        );
    }
}
