<?php

namespace App\Http\Controllers;

use App\Models\StudentRegistration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // Page 1: Personal Data
    public function step1()
    {
        $registration = session('registration', []);
        $currentStep = 1;
        return view('registration.step1', compact('registration', 'currentStep'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'regex:#^(\+62|0)[0-9]{8,12}$#'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'ktp_number' => ['required', 'string', 'size:16', 'regex:#^[0-9]{16}$#'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'full_address' => ['required', 'string'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_relationship' => ['required', 'string', 'max:255'],
            'contact_whatsapp' => ['required', 'string', 'regex:#^(\+62|0)[0-9]{8,12}$#'],
            'requirement_one' => ['required', 'accepted'],
            'requirement_two' => ['required', 'accepted'],
        ], [
            'full_name.required' => 'Nama lengkap harus diisi',
            'whatsapp_number.regex' => 'Format nomor WhatsApp tidak valid (gunakan 08 atau +62)',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'ktp_number.regex' => 'Nomor KTP harus 16 digit',
            'birth_place.required' => 'Tempat lahir harus diisi',
            'birth_date.required' => 'Tanggal lahir harus diisi',
            'birth_date.before' => 'Tanggal lahir tidak valid',
            'full_address.required' => 'Alamat lengkap harus diisi',
            'contact_name.required' => 'Nama kontak darurat harus diisi',
            'contact_relationship.required' => 'Hubungan kontak harus diisi',
            'contact_whatsapp.regex' => 'Format nomor WhatsApp kontak tidak valid (gunakan 08 atau +62)',
            'requirement_one.required' => 'Anda harus menyetujui persyaratan pertama',
            'requirement_two.required' => 'Anda harus menyetujui persyaratan kedua',
        ]);

        session(['registration' => array_merge(session('registration', []), $validated)]);
        
        return redirect()->route('registration.step2');
    }

    // Page 2: Education & Language
    public function step2()
    {
        $registration = session('registration', []);
        $currentStep = 2;
        return view('registration.step2', compact('registration', 'currentStep'));
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'education_level' => 'required|in:SMK,SMA,SMP,Kuliah',
            'school_name' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'graduation_year' => 'required|numeric|min:1950|max:' . date('Y'),
            'gpa' => 'nullable|numeric|min:0|max:4',
            'organization_experience' => 'nullable|string',
            'japanese_ability' => 'required|in:yes,no',
            'japanese_level' => 'required_if:japanese_ability,yes|in:N1,N2,N3,N4,N5',
        ], [
            'education_level.required' => 'Tingkat pendidikan harus dipilih',
            'school_name.required' => 'Nama sekolah/kampus harus diisi',
            'major.required' => 'Jurusan harus diisi',
            'graduation_year.required' => 'Tahun lulus harus diisi',
            'graduation_year.numeric' => 'Tahun lulus harus berupa angka',
            'japanese_ability.required' => 'Kemampuan bahasa Jepang harus dipilih',
            'japanese_level.required_if' => 'Level bahasa harus dipilih jika memilih bisa bahasa Jepang',
        ]);

        session(['registration' => array_merge(session('registration', []), $validated)]);
        
        return redirect()->route('registration.step3');
    }

    // Page 3: Documents
    public function step3()
    {
        $registration = session('registration', []);
        $currentStep = 3;
        return view('registration.step3', compact('registration', 'currentStep'));
    }

    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'family_card_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'birth_certificate_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'passport_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'ktp_photo.required' => 'Foto KTP harus diunggah',
            'family_card_photo.required' => 'Foto kartu keluarga harus diunggah',
            'birth_certificate_photo.required' => 'Foto akte lahir harus diunggah',
            'passport_photo.required' => 'Pas foto terbaru harus diunggah',
            '*.image' => 'File harus berupa gambar',
            '*.mimes' => 'Format gambar harus JPEG atau PNG',
            '*.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Store uploaded files
        $files = [];
        foreach (['ktp_photo', 'family_card_photo', 'birth_certificate_photo', 'passport_photo'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('registrations/' . date('Y/m/d'), 'public');
                $files[$field] = $path;
            }
        }

        session(['registration' => array_merge(session('registration', []), $files)]);
        
        return redirect()->route('registration.step4');
    }

    // Page 4: Payment (for later)
    public function step4()
    {
        $registration = session('registration', []);
        $currentStep = 4;
        return view('registration.step4', compact('registration', 'currentStep'));
    }

    public function storeStep4(Request $request)
    {
        $validated = $request->validate([
            'payment_proof' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diunggah',
            'payment_proof.image' => 'File harus berupa gambar',
            'payment_proof.mimes' => 'Format gambar harus JPEG atau PNG',
            'payment_proof.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Store payment proof
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('registrations/payments/' . date('Y/m/d'), 'public');
            $validated['payment_proof'] = $path;
        }

        session(['registration' => array_merge(session('registration', []), $validated)]);
        
        return redirect()->route('registration.complete');
    }

    // Complete Registration
    public function complete(Request $request)
    {
        $registration = session('registration', []);
        
        if (empty($registration)) {
            return redirect()->route('registration.step1')->with('error', 'Data registrasi tidak ditemukan');
        }

        $student = StudentRegistration::create([
            ...$registration,
            'status' => 'pending',
            'current_step' => 4,
        ]);

        session()->forget('registration');
        
        return redirect()->route('registration.success', ['id' => $student->id]);
    }

    public function success($id)
    {
        $registration = StudentRegistration::findOrFail($id);
        $currentStep = 5; // Completed all steps
        return view('registration.success', compact('registration', 'currentStep'));
    }

    public function clearSession()
    {
        session()->forget('registration');
        return redirect()->route('registration.step1');
    }
}
