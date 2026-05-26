<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Quote, Appointment, AppointmentType};
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    // Quotes
    public function quotes()
    {
        $quotes = Quote::when(request('status'), fn($q) => $q->where('status', request('status')))
            ->latest()
            ->paginate(20);

        return view('admin.quotes.index', compact('quotes'));
    }

    public function showQuote(Quote $quote)
    {
        return view('admin.quotes.show', compact('quote'));
    }

    public function updateQuote(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,contacted,quoted,accepted,declined',
            'quoted_price' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        $quote->update($validated);

        return redirect()->route('admin.quotes.show', $quote)
            ->with('success', 'Devis mis à jour');
    }

    public function deleteQuote(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('admin.quotes')
            ->with('success', 'Devis supprimé');
    }

    // Appointments
    public function appointments()
    {
        $appointments = Appointment::with('type')
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->when(request('date'), fn($q) => $q->whereDate('date', request('date')))
            ->latest()
            ->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function showAppointment(Appointment $appointment)
    {
        $appointment->load('type');
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateAppointment(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('admin.appointments.show', $appointment)
            ->with('success', 'Rendez-vous mis à jour');
    }

    public function deleteAppointment(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments')
            ->with('success', 'Rendez-vous supprimé');
    }

    // Appointment types
    public function appointmentTypes()
    {
        $types = AppointmentType::orderBy('name')->get();
        return view('admin.appointments.types', compact('types'));
    }

    public function storeAppointmentType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'is_active' => 'boolean',
        ]);

        AppointmentType::create($validated);

        return redirect()->route('admin.appointments.types')
            ->with('success', 'Type de prestation créé');
    }

    public function updateAppointmentType(Request $request, AppointmentType $appointmentType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration_minutes' => 'required|integer|min:15',
            'is_active' => 'boolean',
        ]);

        $appointmentType->update($validated);

        return redirect()->route('admin.appointments.types')
            ->with('success', 'Type de prestation mis à jour');
    }

    public function deleteAppointmentType(AppointmentType $appointmentType)
    {
        $appointmentType->delete();
        return redirect()->route('admin.appointments.types')
            ->with('success', 'Type de prestation supprimé');
    }
}
