<x-guest-layout>
    <x-application-logo/>
    <x-auth-card>
        <form action="{{ route('password.email') }}" method="POST" class="wow fadeInRight" ata-wow-duration="1s" data-wow-delay="1s">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-12">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>
                <div class="form-group col-md-12">
                    <label>
                        <p class="label-txt label-active">Email Address</p>
                        <img class="img-fluid log-icon" src="{{ asset('img/Account.svg') }}" alt="">
                        <input id="emailfield" type="email" class="input input-active" name="email" required autofocus>
                    </label>
                </div>
            </div>
            <button type="submit" class="send-btn">{{__('Email Password Reset Link')}}</button>
            @if (Route::has('password.request'))
                <a class="forgot" href="{{ route('login') }}">
                    {{ __('Go back to Login?') }}
                </a>
            @endif
        </form>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />


    </x-auth-card>
</x-guest-layout>
