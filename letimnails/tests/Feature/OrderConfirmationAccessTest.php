<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderConfirmationAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_order_confirmation(): void
    {
        $response = $this->get('/commande/CMD-FAKE123');
        $response->assertRedirect('/connexion');
    }

    public function test_user_cannot_see_another_users_order(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $order = Order::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)
            ->get('/commande/' . $order->order_number);

        $response->assertNotFound();
    }

    public function test_user_can_see_own_order(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get('/commande/' . $order->order_number);

        $response->assertOk();
    }
}
