<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;



#[Title('الملف الشخصي')]

class Profile extends Component
{
    use WithFileUploads;

    public $user;
    public string $name;
    public string $username;
    public string $email;
    public string $phone = '';
    public string $country = '';
    public string $city = '';
    public string $address = '';
    public string $bio = '';
    public $avatar = '';
    public string $avatar_url = '';
    public $avatarFile; // For file uploads
    public string $role_label = 'user';
    public bool $is_active = true;
    public bool $is_verified = false;
    // Password change properties
    public string $password = '';
    public string $password_confirmation = '';
    // Current password for validation
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';


    // toast
    public bool $showToast = false;
    public string $message = '';
    public string $type = 'success'; // success, danger, info, warning

    protected function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email'    => 'required|email|unique:users,email,' . Auth::id(),
            'phone'    => 'nullable|string|max:20',
            'country'  => 'nullable|string|max:100',
            'city'     => 'nullable|string|max:100',
            'address'  => 'nullable|string|max:255',
            'bio'      => 'nullable|string|max:1000',
            'current_password' => 'required|string',
            'new_password'  => [
                'required',
                'min:8',
                'confirmed', // هذا يتحقق من password_confirmation
                'regex:/[0-9]/',         // رقم
                'regex:/[@$!%*#?&]/',    // رمز خاص
            ],
        ];
    }

    protected array $messages = [
        'name.required' => 'الاسم مطلوب.',
        'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفًا.',

        'username.required' => 'اسم المستخدم مطلوب.',
        'username.max' => 'اسم المستخدم يجب ألا يتجاوز 255 حرفًا.',
        'username.unique' => 'اسم المستخدم هذا مسجل مسبقًا.',

        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
        'email.unique' => 'هذا البريد الإلكتروني مسجل مسبقًا.',

        'phone.max' => 'رقم الهاتف يجب ألا يتجاوز 20 حرفًا.',

        'country.max' => 'الدولة يجب ألا تتجاوز 100 حرفًا.',
        'city.max' => 'المدينة يجب ألا تتجاوز 100 حرفًا.',
        'address.max' => 'العنوان يجب ألا يتجاوز 255 حرفًا.',
        'bio.max' => 'السيرة الذاتية يجب ألا تتجاوز 1000 حرفًا.',

        'current_password.required' => 'كلمة المرور الحالية مطلوبة.',

        'new_password.required' => 'كلمة المرور الجديدة مطلوبة.',
        'new_password.min' => 'كلمة المرور الجديدة يجب أن تكون 8 أحرف على الأقل.',
        'new_password.confirmed' => 'تأكيد كلمة المرور الجديدة غير مطابق.',
        'new_password.regex' => 'كلمة المرور الجديدة يجب أن تحتوي على رقم ورمز خاص.',
    ];


    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->username = $user->username ?? '';
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->country = $user->country ?? '';
        $this->city = $user->city ?? '';
        $this->address = $user->address ?? '';
        $this->bio = $user->bio ?? '';
        $this->avatar = $user->avatar ?? '';
        $this->avatar_url = $user->avatar ? asset('storage/' . $user->avatar) : '';
        $this->role_label = $user->role_label;
        $this->is_active = $user->is_active;
        $this->is_verified = $user->is_verified;
    }

    public function save()
    {
        $validated = $this->validate([
            'name'     => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . Auth::id(),
            'email'    => 'required|email|unique:users,email,' . Auth::id(),
            'phone'    => 'nullable|string|max:20',
            'country'  => 'nullable|string|max:100',
            'city'     => 'nullable|string|max:100',
            'address'  => 'nullable|string|max:255',
            'bio'      => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // تحقق إذا لم يتغير شيء
        $noChanges = true;
        foreach ($validated as $key => $value) {
            if ($user->$key !== $value) {
                $noChanges = false;
                break;
            }
        }

        if ($noChanges) {
            // لا حاجة للتحديث ولا لعرض إشعار
            return;
        }

        $user->update($validated);

        // أظهر التوست فقط إذا حدث تعديل فعلي
        $this->showToast('تم حفظ التغييرات بنجاح', 'success');
    }


    public function updatePassword()
    {
        $this->validate();


        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->showToast('كلمة المرور الحالية غير صحيحة', 'danger');
            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->showToast('تم تغيير كلمة المرور بنجاح', 'success');

        // إعادة تعيين الحقول
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function updatedAvatar()
    {
        $user = Auth::user();
        $this->validate([
            'avatar' => 'required|image|max:1024', // 1MB max
        ]);


        // حذف الصورة القديمة إن وجدت
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // توليد اسم ملف مخصص: الاسم + التاريخ + الوقت
        $extension = $this->avatar->getClientOriginalExtension();
        $timestamp = now()->format('Y-m-d_His');
        $cleanName = preg_replace('/\s+/', '_', $user->name); // مثال: Ahmed Ali → Ahmed_Ali
        $filename = "{$cleanName}_{$timestamp}.{$extension}";

        // حفظ الصورة في مجلد المستخدم
        $path = $this->avatar->storeAs("avatars/{$user->id}", $filename, 'public');

        // تحديث المستخدم
        $user->update(['avatar' => $path]);

        // تحديث رابط العرض
        $this->avatar_url = asset('storage/' . $path);
        $this->showToast('تم تحديث الصورة الشخصية بنجاح', 'success');
    }

    public function showToast(string $message, string $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->showToast = true;

        // سيختفي بعد 3 ثواني باستخدام wire:poll في الواجهة
    }

    public function hideToast()
    {
        $this->showToast = false;
    }
    public function render()
    {
        return view('livewire.user.profile');
    }
}
