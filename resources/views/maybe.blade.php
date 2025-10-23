<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Test Blade Template') }}</title>
</head>

<body>
    <div class="container">
        <h1>{{ __('Welcome to Our Application') }}</h1>
        <p>{{ __('This is a test paragraph with some text content.') }}</p>

        <!-- Email Test Cases -->
        <div class="email-section">
            <h2>{{ __('Contact Information') }}</h2>
            <p>{{ __('For support, email us at') }} support@example.com {{ __('or call our helpline.') }}</p>

            <table class="user-table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ __('John Doe') }}</td>
                        <td>john@example.com</td>
                        <td>{{ __('Active') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Jane Smith') }}</td>
                        <td class="px-4 py-3">jane@example.com</td>
                        <td>{{ __('Pending') }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Bob Wilson') }}</td>
                        <td>bob.wilson@company.co.uk</td>
                        <td>{{ __('Inactive') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Regex Pattern Test -->
        <div class="validation-section">
            <h2>{{ __('Email Validation Rules') }}</h2>
            <p>{{ __('Our system uses the following regex pattern for validation:') }}</p>
            <p>{{ __('Regex: /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/') }}</p>
            <p>{{ __('Alternative pattern: /^[\w\.-]+@[\w\.-]+\.\w{2,4}$/') }}</p>
        </div>

        <!-- Mixed Content -->
        <div class="mixed-content">
            <h2>{{ __('User Profile') }}</h2>
            <p>{{ __('Please verify your email address') }} admin@site.com {{ __('before proceeding.') }}</p>
            <p>{{ __('Contact:') }}reach.us@support-center.com {{ __('| Phone: +1-555-0123') }}</p>
        </div>

        <!-- Blade Directives Test -->
        @if ($user)
            <p>{{ __('Hello') }} {{ $user->name }}{{ __(', your email is') }} {{ $user->email }}</p>
        @endif

        @foreach ($emails as $email)
            <div class="email-item">
                <span>{{ $email }}</span>
            </div>
        @endforeach

        <!-- URLs and Websites -->
        <div class="links">
            <h2>{{ __('Useful Links') }}</h2>
            <p>{{ __('Visit our website at') }} https://www.example.com {{ __('for more information.') }}</p>
            <p>{{ __('You can also check') }} www.documentation.com {{ __('or') }} http://blog.example.com</p>
        </div>

        <!-- Code Examples -->
        <pre>
            <code>
                const email = "test@example.com";
                if (email.match(/^[a-z0-9]+@[a-z0-9]+\.[a-z]{2,}$/)) {
                    console.log("Valid email");
                }
            </code>
        </pre>

        <!-- Regular Translatable Content -->
        <div class="content">
            <h2>{{ __('About Us') }}</h2>
            <p>{{ __('We are a company dedicated to providing excellent service.') }}</p>
            <p>{{ __('Our mission is to help businesses grow and succeed.') }}</p>
            <p>{{ __('For inquiries, reach out to') }} hello@ourcompany.com {{ __('anytime.') }}</p>
        </div>

        <!-- Edge Cases -->
        <div class="edge-cases">
            <p>{{ __('Email with text: Send your resume to') }} careers@company.com {{ __("and we'll review it.") }}</p>
            <p>{{ __('Multiple emails: Contact') }} alice@example.com {{ __('or') }} bob@example.com {{ __('for assistance.') }}</p>
            <p>{{ __('Pattern:') }} user@domain.co.uk {{ __('is a valid UK email format.') }}</p>
            <p>{{ __('Pattern:') }} koussay@gmail.com {{ __('is a valid freaking email.') }}</p>
        </div>

        <div>
            {{ __("let's see this one and we'll go to sleep because fuck this shit") }} {{ '@' . $name }}
        </div>

        <!-- Already Translated Content -->
        <div class="existing">
            <p>{{ __('Welcome back!') }}</p>
            <p>{{ __('Your account is active') }}</p>
        </div>
        <div class="existing">
            <p>{{ __('Welcome back!') }}</p>
            <p>{{ __('Your account is active') }}</p>
        </div>
        <div class="existing">
            <p>{{ __('Welcome back!') }}</p>
            <p>{{ __('Your account is active') }}</p>
        </div>
        <div class="existing">
            <p>{{ __('Welcome back!') }}</p>
            <p>{{ __('Your account is active') }}</p>
        </div>
        <div class="existing">
            <p>{{ __('Welcome back!') }}</p>
            <p>{{ __('Your account is active') }}</p>
        </div>
    </div>
</body>

</html>
