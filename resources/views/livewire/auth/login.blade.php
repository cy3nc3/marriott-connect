<div class="min-h-screen flex flex-col md:flex-row font-sans">
    <!-- Left Panel: Branding (60%) -->
    <div class="w-full md:w-[60%] bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white flex flex-col justify-center items-center p-12 relative overflow-hidden order-first min-h-[40vh] md:min-h-screen">
        <!-- Background Pattern/Image Overlay -->
        <div class="absolute inset-0 opacity-20">
            <!-- Using a pattern or potentially an image if available. For now, a CSS pattern. -->
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <!-- Large School Icon/Logo -->
        <div class="relative z-10 mb-8 transform hover:scale-105 transition-transform duration-500">
             <i class='bx bxs-graduation text-9xl text-white opacity-90 drop-shadow-2xl'></i>
        </div>

        <!-- Typography -->
        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight mb-4 drop-shadow-lg">
                Marriott<span class="text-blue-200">Connect</span>
            </h1>
            <p class="text-2xl md:text-3xl font-light text-blue-100 tracking-wide italic">
                "Excellence in every step."
            </p>
        </div>

        <!-- Footer/Copyright on Left Panel -->
        <div class="absolute bottom-8 text-blue-200/60 text-sm font-medium tracking-widest uppercase">
            © 2024 Marriott School System
        </div>
    </div>

    <!-- Right Panel: Login Form (40%) -->
    <div class="w-full md:w-[40%] bg-white flex items-center justify-center p-8 md:p-12 order-last min-h-[60vh] md:min-h-screen">
        <div class="w-full max-w-md space-y-8">
            <!-- Header -->
            <div class="text-center">
                <!-- Small Logo -->
                <div class="mx-auto h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class='bx bxs-school text-2xl text-white'></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                <p class="mt-2 text-gray-500 text-sm">Please enter your details to sign in.</p>
            </div>

            <!-- Form -->
            <form wire:submit="login" class="mt-8 space-y-6">
                <div class="space-y-5">
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-envelope text-gray-400 text-lg'></i>
                            </div>
                            <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required
                                class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-3 transition-colors duration-200"
                                placeholder="name@marriott.edu">
                        </div>
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <div class="relative">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-lock-alt text-gray-400 text-lg'></i>
                            </div>
                            <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required
                                class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-3 transition-colors duration-200"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                            Forgot Password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class='bx bx-log-in text-blue-300 group-hover:text-blue-100 transition-colors'></i>
                        </span>
                        Sign In
                    </button>
                </div>
            </form>

             <div class="pt-4 text-center">
                 <p class="text-xs text-gray-400">Restricted Access. Authorized Personnel Only.</p>
            </div>
        </div>
    </div>
</div>
