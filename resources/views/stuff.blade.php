<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dummy HTML</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <header class="sticky top-0 bg-white/80 backdrop-blur shadow-sm">
        <nav class="max-w-6xl mx-auto flex items-center justify-between p-4">
            <a href="#" class="text-xl font-semibold">Acme</a>
            <ul class="hidden md:flex items-center gap-6">
                <li><a href="#features" class="hover:text-gray-600">Features</a></li>
                <li><a href="#pricing" class="hover:text-gray-600">Pricing</a></li>
                <li><a href="#contact" class="hover:text-gray-600">Contact</a></li>
            </ul>
            <button class="md:hidden px-3 py-2 rounded border">Menu</button>
        </nav>
    </header>

    <!-- Hero -->
    <section class="max-w-6xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">Build something cool</h1>
            <p class="mt-4 text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio.
                Praesent libero. Sed cursus ante dapibus.</p>
            <div class="mt-6 flex gap-3">
                <a class="px-5 py-3 rounded-xl bg-black text-white" href="#">Get Started</a>
                <a class="px-5 py-3 rounded-xl border" href="#features">Learn More</a>
            </div>
        </div>
        <div class="aspect-video bg-white rounded-2xl shadow border grid place-items-center">Placeholder</div>
    </section>

    <!-- Feature Cards -->
    <section id="features" class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-semibold">Features</h2>
        <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <article class="bg-white rounded-2xl border shadow-sm p-5">
                <h3 class="font-medium">Fast</h3>
                <p class="text-sm text-gray-600 mt-2">Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue
                    semper porta.</p>
            </article>
            <article class="bg-white rounded-2xl border shadow-sm p-5">
                <h3 class="font-medium">Reliable</h3>
                <p class="text-sm text-gray-600 mt-2">Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent
                    taciti sociosqu.</p>
            </article>
            <article class="bg-white rounded-2xl border shadow-sm p-5">
                <h3 class="font-medium">Simple</h3>
                <p class="text-sm text-gray-600 mt-2">Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.
                    Curabitur tortor.</p>
            </article>
        </div>
    </section>

    <!-- Table -->
    <section class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-semibold">Users</h2>
        <div class="mt-4 overflow-x-auto bg-white border rounded-2xl">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3">Name</th>
                        <th class="text-left px-4 py-3">Email</th>
                        <th class="text-left px-4 py-3">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="px-4 py-3">Jane Doe</td>
                        <td class="px-4 py-3">jane@example.com</td>
                        <td class="px-4 py-3">Admin</td>
                    </tr>
                    <tr class="border-t">
                        <td class="px-4 py-3">John Smith</td>
                        <td class="px-4 py-3">john@example.com</td>
                        <td class="px-4 py-3">User</td>
                    </tr>
                    <tr class="border-t">
                        <td class="px-4 py-3">Alex Roe</td>
                        <td class="px-4 py-3">alex@example.com</td>
                        <td class="px-4 py-3">Editor</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Form -->
    <section id="contact" class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-semibold">Contact</h2>
        <form class="mt-6 grid gap-4 max-w-xl bg-white p-6 rounded-2xl border">
            <label class="grid gap-1">
                <span class="text-sm">Name</span>
                <input type="text" class="px-3 py-2 rounded border" placeholder="John Doe" />
            </label>
            <label class="grid gap-1">
                <span class="text-sm">Email</span>
                <input type="email" class="px-3 py-2 rounded border" placeholder="john@example.com" />
            </label>
            <label class="grid gap-1">
                <span class="text-sm">Message</span>
                <textarea class="px-3 py-2 rounded border" rows="4" placeholder="Your message..."></textarea>
            </label>
            <button type="button" id="openModal" class="px-4 py-2 rounded-xl bg-black text-white">Submit</button>
        </form>
    </section>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 hidden items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full">
            <h3 class="text-lg font-medium">Thanks!</h3>
            <p class="text-sm text-gray-600 mt-2">Your dummy submission has been received.</p>
            <div class="mt-4 flex justify-end gap-2">
                <button id="closeModal" class="px-4 py-2 rounded-xl border">Close</button>
                <a href="#" class="px-4 py-2 rounded-xl bg-black text-white">View</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t mt-16">
        <div
            class="max-w-6xl mx-auto px-4 py-8 text-sm text-gray-600 flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between">
            <p>© <span id="year"></span> Acme Inc.</p>
            <nav class="flex gap-4">
                <a href="#" class="hover:text-gray-800">Privacy</a>
                <a href="#" class="hover:text-gray-800">Terms</a>
                <a href="#" class="hover:text-gray-800">Support</a>
            </nav>
        </div>
    </footer>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
        const modal = document.getElementById('modal');
        document.getElementById('openModal').addEventListener('click', () => modal.classList.remove('hidden'));
        document.getElementById('closeModal').addEventListener('click', () => modal.classList.add('hidden'));
    </script>
</body>

</html>
