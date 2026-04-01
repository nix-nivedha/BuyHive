<?php
use Laravel\Socialite\Facades\Socialite;
use Webkul\Customer\Models\Customer;
use Illuminate\Support\Facades\Auth;

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();

        // Find or create the customer in your database
        $customer = Customer::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'first_name' => explode(' ', $googleUser->getName())[0],
                'last_name' => count(explode(' ', $googleUser->getName())) > 1 ? explode(' ', $googleUser->getName())[1] : '',
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]
        );

        // Log the customer in
        Auth::guard('customer')->login($customer);

        return redirect('/'); // Redirect to home page
    } catch (\Exception $e) {
        return redirect('/auth/login')->with('error', 'Failed to login with Google');
    }
})->name('google.callback');