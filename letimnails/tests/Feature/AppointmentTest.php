<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\AppointmentType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_appointment_requires_valid_time_format(): void
    {
        $type = AppointmentType::factory()->create();

        $response = $this->post('/reservation-prestation', [
            'appointment_type_id' => $type->id,
            'first_name' => 'Marie',
            'last_name' => 'Dupont',
            'email' => 'marie@example.com',
            'phone' => '0600000000',
            'date' => now()->addDays(3)->format('Y-m-d'),
            'time' => 'invalid-time',
        ]);

        $response->assertSessionHasErrors('time');
    }

    public function test_appointment_prevents_slot_conflict(): void
    {
        $type = AppointmentType::factory()->create();
        $date = now()->addDays(3)->format('Y-m-d');

        Appointment::factory()->create([
            'appointment_type_id' => $type->id,
            'date' => $date,
            'time' => '10:00',
            'status' => 'confirmed',
        ]);

        $response = $this->post('/reservation-prestation', [
            'appointment_type_id' => $type->id,
            'first_name' => 'Marie',
            'last_name' => 'Dupont',
            'email' => 'marie@example.com',
            'phone' => '0600000000',
            'date' => $date,
            'time' => '10:00',
        ]);

        $response->assertSessionHasErrors('time');
    }
}
