<x-guest-layout>
    <x-application-logo/>
    <x-auth-card>
        <form method="POST" action="{{ route('password.update') }}" class="wow fadeInRight" ata-wow-duration="1s" data-wow-delay="1s">
        @csrf
        <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>
                        <p class="label-txt label-active">Email Address</p>
                        <img class="img-fluid log-icon" src="{{ asset('img/Account.svg') }}" alt="">
                        <input id="emailfield" type="email" class="input input-active" name="email" required autofocus value="{{ old('email', $request->email) }}">
                    </label>
                </div>
                <div class="form-group col-md-12">
                    <label>
                        <p class="label-txt label-active">Password</p>
                        <img class="img-fluid log-icon" src="{{ asset('img/Account.svg') }}" alt="">
                        <input id="password" type="password" class="input input-active" name="password" required>
                    </label>
                </div>
                <div class="form-group col-md-12">
                    <label>
                        <p class="label-txt label-active">Password</p>
                        <img class="img-fluid log-icon" src="{{ asset('img/Account.svg') }}" alt="">
                        <input id="password_confirmation" type="password" class="input input-active" name="password_confirmation" required>
                    </label>
                </div>
            </div>
            <button type="submit" class="send-btn">{{ __('Reset Password') }}</button>
        </form>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
    </x-auth-card>
</x-guest-layout>
