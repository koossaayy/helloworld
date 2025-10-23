{{-- Raw Text Stress Test — No nested directives --}}
@extends('layouts.base')

@section('title', 'Raw Content Localization Test')

@section('content')
    <!-- Simple heading -->
    <h1>{{ __('Welcome to the platform') }}</h1>

    <!-- Mixed text with Blade echo -->
    <p>{{ __('Hello,') }} {{ $user->name }}{{ __('! You have') }} <strong>{{ __('3 unread messages') }}</strong>.</p>

    <!-- Text with quotes and apostrophes -->
    <p>{{ __('She said: “Don’t touch that button!” — but he clicked it anyway.') }}</p>
    <p>{{ __('L’année dernière, nous avons lancé l’application.') }}</p>
    <p>{{ __("He replied: 'It\'s working… maybe?'") }}</p>

    <!-- Punctuation-heavy -->
    <p>{{ __('Wait—what?! 😲 Did you really just do that… again??') }}</p>
    <p>{{ __('Price: $19.99 (€18,50) — 100% money-back guarantee!') }}</p>

    <!-- Numbers & units (should NOT be extracted) -->
    <ul>
        <li>{{ __('File size: 2.4 MB') }}</li>
        <li>{{ __('Version: 3.14.159') }}</li>
        <li>{{ __('ID: 9876543210') }}</li>
        <li>{{ __('Coordinates: 40.7128° N, 74.0060° W') }}</li>
        <li>{{ __('Discount: 25%') }}</li>
        <li>{{ __('Temperature: -5°C to 32°F') }}</li>
    </ul>

    <!-- URLs, emails, paths (should NOT be extracted) -->
    <p>{{ __('Contact us at support@example.com or visit https://help.example.com/v2/docs') }}</p>
    <p>{{ __('Config path: /etc/app/config.yaml') }}</p>
    <p>{{ __('Windows path: C:\Users\John\AppData\Local\MyApp') }}</p>
    <p>{{ __('API token: sk_live_a1b2c3d4e5f6g7h8i9j0') }}</p>
    <p>{{ __('Session UUID: f47ac10b-58cc-4372-a567-0e02b2c3d479') }}</p>

    <!-- Placeholders that look like text but aren’t -->
    <p>{{ __('User: {username}') }}</p>
    <p>{{ __('Log: [ERROR] Failed to load module') }}</p>
    <p>{{ __("Code: return $value ?? 'default';") }}</p>

    <!-- HTML entities and symbols -->
    <p>{{ __('Copyright &copy; 2025 Acme Inc. &reg; All rights reserved.') }}</p>
    <p>{{ __('Math: 2') }} < 5 &amp;&amp; 10>= 7</p>

    <!-- Translatable text with HTML inside -->

    <!-- Existing translations — must remain untouched -->
    <p>{{ __('You have :count notifications', ['count' => 5]) }}</p>
    <p>@lang('Your account is active')</p>

    <!-- Text with emojis and multilingual mix -->
    <p>{{ __('🎉 Gracias! Merci! Danke! 谢谢！شكراً!') }}</p>
    <p>{{ __('🚀 Launching in 3… 2… 1… 🌍') }}</p>

    <!-- Text adjacent to Blade without spaces -->
    <label for="email">{{ __('Email:') }}</label><input type="email" id="email" value="{{ $user->email }}">
    <p>{{ __('Status:') }}<span class="status">{{ $user->status_label }}</span></p>

    <!-- Whitespace-sensitive cases -->
    <pre>
This is a preformatted block.
It contains:
- Code-like lines
-   Indented content
- And raw strings like 'debug_mode = true'
Do NOT extract anything from {{ __('here') }}.
    </pre>

    <!-- Attribute-like text in content (should be extracted) -->
    <p>{{ __('The word "class" appears in this sentence — it’s just a word.') }}</p>
    <p>{{ __('We use the term "id" frequently in documentation.') }}</p>

    <!-- False positive traps -->
    <p>{{ __('File: .env.backup') }}</p>
    <p>{{ __('Command: npm install --save-dev') }}</p>
    <p>@Regex: /^[a-z0-9._%+-]+[a-z0-9.-]+\.[a-z]{2,}$/</p>
    <p>{{ __('JSON: {"status":"active","count":42}') }}</p>

    <!-- Real translatable content -->
    <button type="submit">{{ __('Save Changes') }}</button>
    <a href="#" class="btn-{{ __('Cancel') }}">{{ __('Cancel') }}</a>
    <p>{{ __('Are you sure you want to delete this item?') }}</p>
    <p>{{ __('Your changes have been saved successfully.') }}</p>

    <!-- Edge: text that starts/ends with punctuation -->
    <p>{{ __('“Yes!”') }}</p>
    <p>{{ __('(Optional)') }}</p>
    <p>{{ __('…Loading') }}</p>
    <p>{{ __('!!! Warning !!!') }}</p>

    <!-- Mixed case and spacing -->
    <p> {{ __('This has extra spaces') }} </p>
    <p>{{ __('LINE BREAKS INSIDE') }}</p>

    <!-- Final sanity check -->
    <footer>
        <small>{{ __('© :year :company. All rights reserved.', ['year' => date('Y'), 'company' => 'GlobalSoft Ltd']) }}</small>
    </footer>

    <p>{{ __('Hello World how are you ?') }}</p>


    <p>{{ __('PLEASE WORK') }}</p>



@endsection
