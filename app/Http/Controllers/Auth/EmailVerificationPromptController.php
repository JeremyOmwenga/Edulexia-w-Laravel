<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    protected function buildMailMessage($url)
{
    return (new MailMessage)
        ->subject(Lang::get('Verify Email Address'))
        ->line(Lang::get('Please click the button below to verify your email address.'))
        ->action(Lang::get('Verify Email Address'), $url)
        ->line(Lang::get('If you did not create an account, no further action is required.'));
}

    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-email');
    }
}
