<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Cabin;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Reservation::with('cabin')->latest()->get();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cabin = Cabin::findOrFail($request->cabin_id);

        if ($request->guests > $cabin->capacity) {
            return response()->json([
                'message' => 'La cantidad de huéspedes supera la capacidad de la cabaña.',
                'errors' => [
                    'guests' => ['La cantidad de huéspedes supera la capacidad de la cabaña.'],
                ],
            ], 422);
        }

        $data = $request->validate([
            'cabin_id' => 'required|exists:cabins,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required|string|max:50',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $overlap = Reservation::where('cabin_id', $request->cabin_id)
            ->where('check_in', '<', $request->check_out)
            ->where('check_out', '>', $request->check_in)
            ->exists();

        if ($overlap) {
            return response()->json([
                'message' => 'La cabaña ya está reservada en esas fechas.',
                'errors' => [
                    'check_in' => ['La cabaña ya está reservada en esas fechas.'],
                    'check_out' => ['La cabaña ya está reservada en esas fechas.'],
                ],
            ], 422);
        }

        return Reservation::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return $reservation->load('cabin');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'cabin_id' => 'required|exists:cabins,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required|string|max:50',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $cabin = Cabin::findOrFail($request->cabin_id);

        if ($request->guests > $cabin->capacity) {
            return response()->json([
                'message' => 'La cantidad de huéspedes supera la capacidad de la cabaña.',
                'errors' => [
                    'guests' => ['La cantidad de huéspedes supera la capacidad de la cabaña.'],
                ],
            ], 422);
        }

        $overlap = Reservation::where('cabin_id', $request->cabin_id)
            ->where('id', '!=', $reservation->id)
            ->where('check_in', '<', $request->check_out)
            ->where('check_out', '>', $request->check_in)
            ->exists();

        if ($overlap) {
            return response()->json([
                'message' => 'La cabaña ya está reservada en esas fechas.',
                'errors' => [
                    'check_in' => ['La cabaña ya está reservada en esas fechas.'],
                    'check_out' => ['La cabaña ya está reservada en esas fechas.'],
                ],
            ], 422);
        }

        $reservation->update($data);

        return $reservation;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        
        return response()->json([
            'message' => 'Reserva eliminada correctamente'
        ]);
    }
}
