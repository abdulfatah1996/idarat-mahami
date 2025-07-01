<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Layout('components.layouts.guest')]
#[Title('صفحة تسجيل الدخول')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public $showToast = false;
    public $message = '';
    public $type = 'success';
    public $timer = 0;


    protected function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'min:8',
            ],
        ];
    }

    protected $messages = [
        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
        'password.required' => 'كلمة المرور مطلوبة.',
        'password.min' => 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل.',
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function showToast($msg, $type = 'success')
    {
        $this->message = $msg;
        $this->type = $type;
        $this->showToast = true;
        $this->timer = now()->timestamp;
    }

    public function hideToast()
    {
        $this->showToast = false;
    }
    public function login()
    {
        $this->validate();

        if (!Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            $this->showToast('البريد الإلكتروني أو كلمة المرور غير صحيحة.', 'error');
            return;
        }

        session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
