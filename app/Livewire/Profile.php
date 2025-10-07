<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;
    public $currency = 'IDR';
    public $notification_enabled = true;
    public $avatar;
    public $current_avatar;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'current_password' => 'nullable|required_with:password',
        'password' => 'nullable|min:8|confirmed',
        'currency' => 'required|string|max:10',
        'notification_enabled' => 'boolean',
        'avatar' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->currency = $user->currency;
        $this->notification_enabled = $user->notification_enabled;
        $this->current_avatar = $user->avatar;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'currency' => 'required|string|max:10',
            'notification_enabled' => 'boolean',
            'avatar' => 'nullable|image|max:1024',
        ]);

        $user = Auth::user();
        $avatarPath = $user->avatar;

        if ($this->avatar) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $this->avatar->store('avatars', 'public');
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'currency' => $this->currency,
            'notification_enabled' => $this->notification_enabled,
            'avatar' => $avatarPath,
        ]);

        // Perbarui current_avatar dengan nilai baru
        $this->current_avatar = $avatarPath;

        // Reset properti avatar
        $this->reset('avatar');

        session()->flash('message', 'Profil berhasil diperbarui.');
    }

    public function updateProfileAvatar()
    {
        // Debug lebih detail
        if ($this->avatar) {
            session()->flash('message', 'File terdeteksi: ' .
                'Nama: ' . $this->avatar->getClientOriginalName() . ', ' .
                'Tipe: ' . $this->avatar->getMimeType() . ', ' .
                'Ukuran: ' . $this->avatar->getSize() . ' bytes');

            try {
                $this->validate([
                    'avatar' => 'image|max:1024',
                ]);

                $user = Auth::user();
                $avatarPath = $user->avatar;

                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $avatarPath = $this->avatar->store('avatars', 'public');

                if ($avatarPath) {
                    $user->update([
                        'avatar' => $avatarPath,
                    ]);

                    // Perbarui current_avatar dengan nilai baru
                    $this->current_avatar = $avatarPath;

                    // Reset properti avatar
                    $this->reset('avatar');

                    session()->flash('message', 'Foto profil berhasil diperbarui. Path: ' . $avatarPath);
                } else {
                    session()->flash('message', 'Gagal menyimpan file ke storage');
                }
            } catch (\Exception $e) {
                session()->flash('message', 'Error: ' . $e->getMessage());
            }
        } else {
            session()->flash('message', 'Tidak ada file yang dipilih');
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak sesuai.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('message', 'Password berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
