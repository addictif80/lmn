<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{Quote, Appointment, AppointmentType};
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function demandeDevis()
    {
        return view('front.pages.devis');
    }

    public function soumettreDevis(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'description' => 'required|string',
            'nail_shape' => 'nullable|string',
            'nail_size' => 'nullable|string',
            'nail_length' => 'nullable|string',
            'design_ideas' => 'nullable|string',
        ]);

        Quote::create(array_merge($validated, [
            'quote_number' => 'DEV-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'status' => 'pending',
        ]));

        return redirect()->route('devis.confirmation')
            ->with('success', 'Votre demande de devis a bien été envoyée !');
    }

    public function devisConfirmation()
    {
        return view('front.pages.devis-confirmation');
    }

    public function reservation()
    {
        $appointmentTypes = AppointmentType::active()->get();
        return view('front.pages.reservation', compact('appointmentTypes'));
    }

    public function reserver(Request $request)
    {
        $validated = $request->validate([
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'notes' => 'nullable|string',
        ]);

        Appointment::create(array_merge($validated, [
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]));

        return redirect()->route('reservation.confirmation')
            ->with('success', 'Votre réservation a bien été prise en compte !');
    }

    public function reservationConfirmation()
    {
        return view('front.pages.reservation-confirmation');
    }
}
