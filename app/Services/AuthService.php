<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'type' => 'donor', // Default type for API registrations
            'status' => 'active',
        ]);

        // Assign the donor role to the user
        $user->assignRole('donor');

        return $user;
    }

    /**
     * Attempt to authenticate a user.
     *
     * @param array $credentials
     * @param bool $remember
     * @return array
     * @throws AuthenticationException
     */
    public function login(array $credentials, bool $remember = false): array
    {
        if (!Auth::attempt($credentials, $remember)) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        $user = Auth::user();

        // Create a new token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Log the user out (revoke access token).
     *
     * @param User $user
     * @return bool
     */
    public function logout(User $user): bool
    {
        return $user->currentAccessToken()->delete();
    }

    /**
     * Send a password reset link to the user.
     *
     * @param string $email
     * @return string
     */
    public function forgotPassword(string $email): string
    {
        $status = Password::sendResetLink(['email' => $email]);

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return __($status);
    }

    /**
     * Reset the user's password.
     *
     * @param array $data
     * @return string
     */
    public function resetPassword(array $data): string
    {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return __($status);
    }

    /**
     * Change the user's password.
     *
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function changePassword(User $user, string $password): bool
    {
        return $user->update([
            'password' => Hash::make($password),
        ]);
    }

    /**
     * Get OAuth URL for the specified provider.
     *
     * @param string $provider
     * @return string
     */
    public function getOAuthRedirectUrl(string $provider): string
    {
        return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
    }

    /**
     * Handle social login callback.
     *
     * @param string $provider
     * @param string $accessToken
     * @param string|null $tokenSecret
     * @return array
     */
    public function handleSocialLogin(string $provider, string $accessToken, ?string $tokenSecret = null): array
    {
        try {
            // Get user info from provider
            $socialDriver = Socialite::driver($provider)->stateless();
            
            if ($tokenSecret) {
                $socialUser = $socialDriver->userFromTokenAndSecret($accessToken, $tokenSecret);
            } else {
                $socialUser = $socialDriver->userFromToken($accessToken);
            }

            // Check if user exists with this social id
            $user = User::where('social_id', $socialUser->getId())
                ->where('social_type', $provider)
                ->first();

            // If user doesn't exist, check by email
            if (!$user) {
                $user = User::where('email', $socialUser->getEmail())->first();

                // If user with email exists, update social info
                if ($user) {
                    $user->update([
                        'social_id' => $socialUser->getId(),
                        'social_type' => $provider,
                        'social_avatar' => $socialUser->getAvatar(),
                    ]);
                } else {
                    // Create a new user
                    $user = User::create([
                        'name' => $socialUser->getName(),
                        'email' => $socialUser->getEmail(),
                        'phone' => $socialUser->phone ?? '',
                        'social_id' => $socialUser->getId(),
                        'social_type' => $provider,
                        'social_avatar' => $socialUser->getAvatar(),
                        'type' => 'donor',
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]);

                    // Assign the donor role to the user
                    $user->assignRole('donor');
                }
            }

            // Create a new token
            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'error' => ['Failed to authenticate with ' . $provider . ': ' . $e->getMessage()],
            ]);
        }
    }
}
