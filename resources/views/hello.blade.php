@php
    /**
     * localized_test.blade.php
     * Complex Blade view (PLAIN TEXT strings) to stress-test localization parsing.
     * Expected variables: $user (object with name, email), $items (collection/array), $count (int)
     */
@endphp

<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MyApp — Test Page</title>
    <meta name="description" content="This is a plain-text Blade view used to test localization extraction and parsing.">

    <style>
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        .rtl {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            background: #efefef
        }
    </style>
</head>

<body>

    <header>
        <h1>Welcome, {{ $user->name ?? 'Guest' }}!</h1>
        <p>You have {{ $user->unread ?? 0 }} unread messages.</p>

        <nav>
            <a href="/en/">EN</a>
            <a href="/fr/">FR</a>
            <a href="/ar/">AR</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Introduction</h2>
            <p>This section contains plain text strings intended to appear verbatim in the view so you can test
                extraction tools.</p>
        </section>

        <section>
            <h3>Items ({{ count($items ?? []) }})</h3>
            <p>There are {{ count($items ?? []) }} items in your list.</p>

            <ul>
                @forelse($items ?? [] as $i => $item)
                    <li>
                        <strong>Item {{ $i + 1 }}: {{ $item['name'] ?? 'Unknown item' }}</strong>
                        <span> — Price: {{ $item['price'] ?? 'N/A' }}</span>
                        <div class="badge">In stock: {{ $item['stock'] ?? 0 }}</div>
                        @if (!empty($item['tags']))
                            <div>Tags: {{ implode(', ', $item['tags']) }}</div>
                        @endif
                    </li>
                @empty
                    <li>No items found.</li>
                @endforelse
            </ul>
        </section>

        <section>
            <h3>Actions</h3>
            <form method="POST" action="/items/add">
                @csrf
                <label for="name">Item name</label>
                <input id="name" name="name" placeholder="Enter item name" />

                <label for="price">Price</label>
                <input id="price" name="price" placeholder="0.00" />

                <button type="submit">Add item</button>
            </form>
        </section>

        <section>
            <h3>Notifications</h3>
            @if (isset($user->settings) && $user->settings->email_notifications)
                <p>Email notifications are enabled for your account.</p>
            @else
                <p>Email notifications are disabled for your account.</p>
            @endif
        </section>

        <section>
            <h3>Dates & Formatting</h3>
            <p>Account created at: {{ optional($user)->created_at ? $user->created_at->toDateTimeString() : 'unknown' }}
            </p>
            <p>Next billing date: {{ $user->next_billing_date ?? 'not scheduled' }}</p>
        </section>

        <section>
            <h3>Complex expressions</h3>
            <p>Discount eligible:
                {{ (isset($user->is_premium) && $user->is_premium) || count($items ?? []) > 10 ? 'Yes' : 'No' }}</p>
            <p>Summary: Subtotal {{ '$' . number_format(collect($items ?? [])->sum('price'), 2) }}, Tax
                {{ '$' .number_format(collect($items ?? [])->sum(function ($i) {return ($i['price'] ?? 0) * 0.2;}),2) }}
            </p>
        </section>

        <footer>
            <p>Contact support at support@example.com or visit our help center.</p>
            <p>© {{ date('Y') }} MyApp. All rights reserved.</p>
        </footer>
    </main>

</body>

</html>
