<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label(__('filament.email'))
                    ->email()
                    ->required()
                    ->autocomplete()
                    ->autofocus()
                    ->extraInputAttributes(['dir' => 'ltr']), // Force LTR for email
                TextInput::make('password')
                    ->label(__('filament.password'))
                    ->password()
                    ->required()
                    ->extraInputAttributes(['dir' => 'ltr']), // Force LTR for password
            ])
            ->statePath('data');
    }

    public function authenticate(): LoginResponse
    {
        $data = $this->form->getState();

        if (! auth()->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], true)) {
            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        // Check if user is admin or association manager
        $user = auth()->user();
        if (!in_array($user->type, ['admin', 'association_manager'])) {
            auth()->logout();
            throw ValidationException::withMessages([
                'data.email' => __('Unauthorized access'),
            ]);
        }

        return app(LoginResponse::class);
    }

    public function getTitle(): string
    {
        return __('تسجيل الدخول');
    }

    public function getHeading(): string
    {
        return __('تسجيل الدخول للوحة التحكم');
    }
}
