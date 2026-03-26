<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Franchise Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-b from-slate-50 via-sky-50 to-white">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="glass-card w-full max-w-md p-8 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-500 to-cyan-400 flex items-center justify-center text-white font-bold shadow-md">
                    FM
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Franchise Platform</h1>
                    <p class="text-sm text-slate-600">Sign in with your seeded credentials</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-rose-50 border border-rose-100 p-4 text-rose-700">
                    <div class="flex gap-2">
                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold">Authentication failed</h3>
                            <ul class="mt-2 text-sm list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="muted-label block mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                </div>
                <div>
                    <label class="muted-label block mb-2">Password</label>
                    <input type="password" name="password" required
                           class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-slate-800">Remember me</label>
                </div>
                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-md hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
                    Sign in
                </button>
            </form>

            <p class="mt-6 text-xs text-slate-500 text-center leading-relaxed">
                Admin: admin@franchise.com • Franchisor: franchisor@franchise.com • Franchisee: franchisee@franchise.com (password: password)
            </p>
        </div>
    </div>
</body>
</html>
