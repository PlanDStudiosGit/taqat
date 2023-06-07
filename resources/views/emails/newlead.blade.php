@component('mail::message')

    <h2 style="margin: 0 0 24px;">New Lead From {{ ucwords($details['leadData']->type) }}</h2>
    <p style="margin: 0 0 24px;">
        <span style="font-weight: 600;">Name: </span> {{ $details['leadData']->name }}
    </p>
    <p style="margin: 0 0 24px;">
        <span style="font-weight: 600;">Phone: </span> {{ $details['leadData']->phone }}
    </p>
    @if(isset($details['leadData']->email))
        <p style="margin: 0 0 24px;">
            <span style="font-weight: 600;">Email: </span> {{ $details['leadData']->email }}
        </p>
    @endif
    @if(isset($details['leadData']->service))
        <p style="margin: 0 0 24px;">
            <span style="font-weight: 600;">Service: </span> {{ $details['leadData']->service }}
        </p>
    @endif
    @if(isset($details['leadData']->message))
        <p style="margin: 0 0 24px;">
            <span style="font-weight: 600;">Message: </span> {{ $details['leadData']->message }}
        </p>
    @endif

    Thanks,
    {{ config('app.name') }}
@endcomponent
