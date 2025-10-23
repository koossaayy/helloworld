<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Blade Template</title>
</head>

<body>
    <div class="container">
        <h1>Welcome to Our Application</h1>
        <p>This is a test paragraph with some text content.</p>

        <!-- Email Test Cases -->
        <div class="email-section">
            <h2>Contact Information</h2>
            <p>For support, email us at support@example.com or call our helpline.</p>

            <table class="user-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td>Active</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td class="px-4 py-3">jane@example.com</td>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <td>Bob Wilson</td>
                        <td>bob.wilson@company.co.uk</td>
                        <td>Inactive</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Regex Pattern Test -->
        <div class="validation-section">
            <h2>Email Validation Rules</h2>
            <p>Our system uses the following regex pattern for validation:</p>
            <p>Regex: /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/</p>
            <p>Alternative pattern: /^[\w\.-]+@[\w\.-]+\.\w{2,4}$/</p>
        </div>

        <!-- Mixed Content -->
        <div class="mixed-content">
            <h2>User Profile</h2>
            <p>Please verify your email address admin@site.com before proceeding.</p>
            <p>Contact:reach.us@support-center.com | Phone: +1-555-0123</p>
        </div>

        <!-- Blade Directives Test -->
        @if ($user)
            <p>Hello {{ $user->name }}, your email is {{ $user->email }}</p>
        @endif

        @foreach ($emails as $email)
            <div class="email-item">
                <span>{{ $email }}</span>
            </div>
        @endforeach

        <!-- URLs and Websites -->
        <div class="links">
            <h2>Useful Links</h2>
            <p>Visit our website at https://www.example.com for more information.</p>
            <p>You can also check www.documentation.com or http://blog.example.com</p>
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
            <h2>About Us</h2>
            <p>We are a company dedicated to providing excellent service.</p>
            <p>Our mission is to help businesses grow and succeed.</p>
            <p>For inquiries, reach out to hello@ourcompany.com anytime.</p>
        </div>

        <!-- Edge Cases -->
        <div class="edge-cases">
            <p>Email with text: Send your resume to careers@company.com and we'll review it.</p>
            <p>Multiple emails: Contact alice@example.com or bob@example.com for assistance.</p>
            <p>Pattern: user@domain.co.uk is a valid UK email format.</p>
            <p>Pattern: koussay@gmail.com is a valid freaking email.</p>
        </div>

        <div>
            also we can do this @@{{ $user - > name }}
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
