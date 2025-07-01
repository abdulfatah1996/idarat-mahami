<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
#[Title('إنشاء حساب جديد')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    // toast
    public bool $showToast = false;
    public string $message = '';
    public string $type = 'success';
    public int $timer;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => [
                'required',
                'email',
                'ends_with:@gmail.com,@hotmail.com',
                'unique:users,email'
            ],

            'password' => [
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
        'name.min' => 'الاسم يجب أن يحتوي على 3 أحرف على الأقل.',

        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
        'email.dns' => 'البريد يجب أن يكون من نطاق صالح.',
        'email.ends_with' => 'يُسمح فقط ببريد Gmail أو Hotmail.',
        'email.unique' => 'هذا البريد مسجّل مسبقًا.',

        'password.required' => 'كلمة المرور مطلوبة.',
        'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
        'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        'password.regex' => 'كلمة المرور يجب أن تحتوي على رقم ورمز خاص.',
    ];


    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function register()
    {
        $validated = $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        $this->message = 'تم إنشاء الحساب بنجاح 🎉';
        $this->type = 'success';
        $this->showToast = true;
        $this->timer = now()->timestamp;
        return redirect()->to('/dashboard');
    }

    public function hideToast()
    {
        $this->showToast = false;
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
