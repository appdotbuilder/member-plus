<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDentalAppointmentRequest;
use App\Models\DentalAppointment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DentalAppointmentController extends Controller
{
    /**
     * Display a listing of the user's dental appointments.
     */
    public function index(Request $request)
    {
        $appointments = $request->user()->dentalAppointments()
            ->latest('appointment_datetime')
            ->paginate(10);

        return Inertia::render('dental/appointments/index', [
            'appointments' => $appointments
        ]);
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        return Inertia::render('dental/appointments/create');
    }

    /**
     * Store a newly created appointment.
     */
    public function store(StoreDentalAppointmentRequest $request)
    {
        $appointmentNumber = 'DENT-' . now()->format('Ymd') . '-' . str_pad((string)random_int(1, 999), 3, '0', STR_PAD_LEFT);

        $appointment = DentalAppointment::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'appointment_number' => $appointmentNumber,
        ]);

        return redirect()->route('dental.appointments.show', $appointment)
            ->with('success', 'Dental appointment booked successfully.');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Request $request, DentalAppointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated user
        if ($appointment->user_id !== $request->user()->id) {
            abort(404);
        }

        return Inertia::render('dental/appointments/show', [
            'appointment' => $appointment
        ]);
    }

    /**
     * Update the specified appointment.
     */
    public function update(Request $request, DentalAppointment $appointment)
    {
        // Ensure the appointment belongs to the authenticated user
        if ($appointment->user_id !== $request->user()->id) {
            abort(404);
        }

        $validatedData = $request->validate([
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
        ]);

        $appointment->update($validatedData);

        return redirect()->route('dental.appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }
}