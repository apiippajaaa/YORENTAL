<?php

namespace App\Http\Controllers\Backend;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CarPhotoController extends Controller
{
    public function updatePhoto(Request $request, Car $car, $photoId)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $photo = $car->photos()->findOrFail($photoId);

        if (Storage::exists($photo->photo_path)) {
            Storage::delete($photo->photo_path);
        }

        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $filename = 'car_' . $car->id . '_' . time() . '_' . uniqid() . '.' . $photoFile->getClientOriginalExtension();
            $path = $photoFile->storeAs('cars', $filename, 'public');

            $photo->update(['photo_path' => $path]);
        }

        return back()->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroyPhoto(Car $car, $photoId)
    {
        $photo = $car->photos()->findOrFail($photoId);

        if (Storage::exists($photo->photo_path)) {
            Storage::delete($photo->photo_path);
        }

        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
