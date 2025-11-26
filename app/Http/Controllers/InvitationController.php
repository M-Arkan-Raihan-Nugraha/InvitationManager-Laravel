<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Invitation;
use App\Models\Attendance;
use App\Models\Guest;
use App\Models\Location;
use App\Models\Category;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::with(['location', 'category'])->get();
        $locations = Location::all();
        $categories = Category::all();
        $guests = Guest::all();

        return view('invitation.index', compact('invitations', 'locations', 'categories', 'guests'));
    }

    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        $guests = Guest::all();

        return view('invitation.form', compact('categories', 'locations', 'guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location_id' => 'required|exists:locations,id',
            'category_id' => 'required|exists:categories,id',
            'guest_ids' => 'required|array',
            'guest_ids.*' => 'exists:guests,id',
        ]);

        DB::beginTransaction();
        try {
            $invitation = Invitation::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'date' => $validated['date'],
                'location_id' => $validated['location_id'],
                'category_id' => $validated['category_id'],
                'user_id' => Auth::id() ?? 1,
            ]);

            foreach ($validated['guest_ids'] as $guestId) {
                Attendance::create([
                    'invitation_id' => $invitation->id,
                    'guest_id' => $guestId,
                    'status' => 'pending',
                ]);
            }

            DB::commit();
            return redirect()->route('invitation.index')
                             ->with('success', 'Invitation berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save invitation: ' . $e->getMessage());
        }
    }

    public function destroy(Invitation $invitation)
    {
        try {
            $invitation->delete();
            return redirect()->route('invitation.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('invitation.index')->with('error', $e->getMessage());
        }
    }

    public function edit(Invitation $invitation)
    {
        $categories = Category::all();
        $locations = Location::all();
        $guests = Guest::all();

        return view('invitation.form_edit', compact('invitation', 'categories', 'locations', 'guests'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'guest_ids' => 'nullable|array',
            'guest_ids.*' => 'exists:guests,id',
        ]);

        $invitation = Invitation::findOrFail($id);

        DB::beginTransaction();
        try {
            $invitation->update($request->only(['title','description','date','category_id','location_id']));

            Attendance::where('invitation_id', $invitation->id)->delete();

            if ($request->filled('guest_ids')) {
                foreach ($request->guest_ids as $guestId) {
                    Attendance::create([
                        'invitation_id' => $invitation->id,
                        'guest_id' => $guestId,
                        'status' => 'pending',
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('invitation.index')
                             ->with('success', 'Data undangan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Update gagal: ' . $e->getMessage());
        }
    }
}
