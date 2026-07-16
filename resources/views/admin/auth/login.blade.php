<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - MyTrips Admin</title>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-background text-foreground antialiased min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="flex flex-col items-center mb-6">
            <div class="w-12 h-12 bg-nepal-blue rounded-xl flex items-center justify-center mb-3">
                <span class="iconify w-6 h-6 text-white" data-icon="lucide:map"></span>
            </div>
            <h1 class="text-lg font-semibold">MyTrips Admin</h1>
            <p class="text-sm text-muted-foreground mt-1">Sign in to the super admin dashboard</p>
        </div>

        <div class="bg-card border border-border rounded-xl p-6">
            @if ($errors->any())
                <div class="mb-4 px-3 py-2 bg-destructive/10 text-destructive text-sm rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1.5" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5" for="password">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-3 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40">
                </div>
                <label class="flex items-center gap-2 text-sm text-muted-foreground">
                    <input type="checkbox" name="remember" class="rounded border-input">
                    Remember me
                </label>
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-medium bg-primary text-primary-foreground rounded-lg hover:opacity-90 transition-opacity">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</body>

</html>
