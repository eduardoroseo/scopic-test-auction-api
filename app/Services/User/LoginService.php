<?php


namespace App\Services\User;


use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginService
{
    /**
     * @param array $request
     * @return array
     * @throws ValidationException
     */
    public function login(array $request): array
    {
        $user = User::where('email', $request['email'])
            ->firstOrFail();

        if (!\Hash::check($request['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return ['token' => $user->createToken(Str::slug($user->name))->plainTextToken];
    }
}
