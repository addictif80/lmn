<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\{Quote, Appointment, AppointmentType};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'required|string|max:5000',
            'nail_shape' => 'nullable|string|max:100',
            'nail_size' => 'nullable|string|max:100',
            'nail_length' => 'nullable|string|max:100',
            'design_ideas' => 'nullable|string|max:2000',
        ]);

        Quote::create(array_merge($validated, [
            'quote_number' => 'DEV-' . strtoupper(Str::uuid()),
            'user_id' => auth()->id(),
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
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date|after:today',
            'time' => ['required', 'regex:/^\d{2}:\d{2}$/'],
            'notes' => 'nullable|string|max:2000',
        ]);

        // Check for appointment slot conflicts
        $conflict = Appointment::where('appointment_type_id', $validated['appointment_type_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->whereNotIn('status', ['cancelled'])
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors(['time' => 'Ce créneau est déjà réservé. Veuillez choisir un autre horaire.']);
        }

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
