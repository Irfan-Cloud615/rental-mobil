<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CarController extends Controller
{
    /**
     * Daftar seluruh unit mobil dengan filter sederhana.
     */
    public function index(Request $request)
    {
        $cars = Car::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%' . $request->input('q') . '%';
                $q->where(function ($qq) use ($term) {
                    $qq->where('name', 'like', $term)
                        ->orWhere('brand', 'like', $term)
                        ->orWhere('license_plate', 'like', $term);
                });
            })
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->input('status')))
            ->when($request->filled('featured'), fn($q) => $q->where('is_featured', $request->boolean('featured')))
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('content.admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('content.admin.cars.create', ['car' => new Car()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data = $this->handleImage($request, $data);

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function edit(Car $car)
    {
        return view('content.admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $data = $this->validated($request, $car);
        $data = $this->handleImage($request, $data, $car);

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    public function destroy(Car $car)
    {
        // Jangan hapus bila masih ada pesanan aktif yang memakai mobil ini.
        if ($car->activeBookings()->exists()) {
            return back()->with('error', 'Mobil tidak dapat dihapus karena masih memiliki pesanan aktif.');
        }

        if ($car->image_path && !preg_match('#^https?://#', $car->image_path)) {
            Storage::disk('public')->delete($car->image_path);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Mobil berhasil dihapus.');
    }

    /**
     * Toggle is_featured untuk memunculkan/hilangkan mobil di halaman utama.
     */
    public function toggleFeatured(Car $car)
    {
        $car->is_featured = !$car->is_featured;
        $car->save();

        return back()->with('success', 'Status unggulan berhasil diubah.');
    }

    /**
     * Toggle status active <-> maintenance.
     */
    public function toggleStatus(Car $car)
    {
        $car->status = $car->status === 'active' ? 'maintenance' : 'active';
        $car->save();

        return back()->with('success', 'Status mobil berhasil diubah menjadi ' . $car->status . '.');
    }

    /**
     * Aturan validasi bersama untuk create & update.
     */
    private function validated(Request $request, ?Car $car = null): array
    {
        $carId = $car?->id ?? 0;

        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:60'],
            'license_plate' => ['required', 'string', 'max:20', Rule::unique('cars', 'license_plate')->ignore($carId)],
            'transmission' => ['required', Rule::in(['manual', 'automatic'])],
            'fuel_type' => ['required', Rule::in(['pertalite', 'pertamax', 'pertamax_turbo', 'diesel', 'hybrid'])],
            'seat_capacity' => ['required', 'integer', 'min:2', 'max:60'],
            'luggage_capacity' => ['nullable', 'integer', 'min:0', 'max:20'],
            'mileage_km' => ['nullable', 'integer', 'min:0'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:5000'],
            'features' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:2048'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', Rule::in(['active', 'maintenance'])],
            'is_featured' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama mobil wajib diisi.',
            'license_plate.required' => 'Plat nomor wajib diisi.',
            'license_plate.unique' => 'Plat nomor sudah digunakan mobil lain.',
            'price_per_day.required' => 'Harga sewa per hari wajib diisi.',
            'price_per_day.numeric' => 'Harga sewa harus berupa angka.',
            'image.image' => 'Berkas gambar harus berupa file image.',
        ]);
    }

    /**
     * Prioritaskan upload file, lalu URL eksternal, selain itu pertahankan nilai lama.
     */
    private function handleImage(Request $request, array $data, ?Car $car = null): array
    {
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('cars', 'public');
        } elseif (!blank($request->input('image_url'))) {
            $data['image_path'] = $request->input('image_url');
        }
        // Bila tidak ada upload maupun URL, image_path dibiarkan tidak diubah.

        // Ubah teks fitur (per baris / koma) menjadi array.
        $features = array_values(array_filter(array_map('trim', preg_split('/[,\n]/', (string) ($data['features'] ?? '')))));
        $data['features'] = $features ?: null;

        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
