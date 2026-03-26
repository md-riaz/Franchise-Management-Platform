<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In | Franchise Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-50 antialiased">
    <div class="min-h-screen flex">
        {{-- Left panel - branding --}}
        <div class="hidden lg:flex lg:w-1/2 bg-indigo-600 flex-col justify-between p-12">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-white/20 text-white shrink-0">
                    <x-heroicon-m-building-storefront class="w-5 h-5" />
                </div>
                <span class="text-white font-bold text-lg">Franchise Platform</span>
            </div>
            <div class="space-y-6">
                <h1 class="text-4xl font-bold text-white leading-tight">
                    Manage every<br>franchise location<br>in one place.
                </h1>
                <p class="text-indigo-200 text-lg leading-relaxed">
                    Real-time inventory, automated royalties, compliance tracking,
                    and rich analytics — all built for franchise networks.
                </p>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white/10 rounded-xl p-4">
                        <p class="text-2xl font-bold text-white">24</p>
                        <p class="text-xs text-indigo-200 mt-1">Active locations</p>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <p class="text-2xl font-bold text-white">$2.4M</p>
                        <p class="text-xs text-indigo-200 mt-1">Monthly revenue</p>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <p class="text-2xl font-bold text-white">98%</p>
                        <p class="text-xs text-indigo-200 mt-1">Compliance rate</p>
                    </div>
                </div>
            </div>
            <p class="text-indigo-300 text-sm">© {{ date('Y') }} Franchise Management Platform</p>
        </div>

        {{-- Right panel - form --}}
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md space-y-8">
                {{-- Mobile logo --}}
                <div class="flex items-center gap-3 lg:hidden">
                    <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-indigo-600 text-white shrink-0">
                        <x-heroicon-m-building-storefront class="w-5 h-5" />
                    </div>
                    <span class="text-neutral-900 font-bold text-lg">Franchise Platform</span>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-neutral-900">Welcome back</h2>
                    <p class="mt-1 text-sm text-neutral-500">Sign in to your account to continue</p>
                </div>

                @if ($errors->any())
                    <div class="flex gap-3 rounded-lg bg-red-50 border border-red-200 p-4">
                        <x-heroicon-m-exclamation-triangle class="w-5 h-5 text-red-500 shrink-0 mt-0.5" />
                        <div>
                            <p class="text-sm font-semibold text-red-800">Authentication failed</p>
                            <ul class="mt-1 text-sm text-red-700 list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-neutral-700" for="email">Email address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="you@example.com"
                            class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm text-neutral-900 placeholder-neutral-400 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none"
                        >
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-neutral-700" for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm text-neutral-900 placeholder-neutral-400 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none"
                        >
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                class="h-4 w-4 rounded border-neutral-300 text-indigo-600 focus:ring-indigo-500"
                            >
                            <span class="text-sm text-neutral-700">Remember me</span>
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
                    >
                        <x-heroicon-m-arrow-right-end-on-rectangle class="w-4 h-4" />
                        Sign in
                    </button>
                </form>

                <div class="rounded-lg border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-xs font-semibold text-neutral-600 mb-2">Demo credentials</p>
                    <div class="space-y-1 text-xs text-neutral-500">
                        <p><span class="font-medium text-neutral-700">Admin:</span> admin@franchise.com</p>
                        <p><span class="font-medium text-neutral-700">Franchisor:</span> franchisor@franchise.com</p>
                        <p><span class="font-medium text-neutral-700">Franchisee:</span> franchisee@franchise.com</p>
                        <p class="pt-1 text-neutral-400">Password: <span class="font-medium">password</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
