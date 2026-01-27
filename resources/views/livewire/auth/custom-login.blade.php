<div class="min-h-screen flex flex-col md:flex-row font-sans">
    <!-- Left Panel: Branding -->
    <!-- Mobile: Order 1 (Top), Desktop: Order 1 (Left) -->
    <div class="w-full md:w-1/2 bg-blue-900 text-white flex flex-col justify-center items-center p-8 relative order-first min-h-[30vh] md:min-h-screen">
        <div class="flex flex-col items-center z-10 text-center">
            <!-- Icon -->
            <i class='bx bxs-graduation text-7xl md:text-8xl mb-4 md:mb-6 text-white opacity-90'></i>
            <!-- Typography -->
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight mb-2">MarriottConnect</h1>
            <p class="text-lg md:text-xl text-blue-100 font-light tracking-wide">School Management System</p>
        </div>

        <div class="absolute bottom-4 md:bottom-6 text-[10px] md:text-xs text-blue-300/60 uppercase tracking-widest text-center w-full">
            Powered by Marriott School | Quezon City
        </div>

        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10 pointer-events-none">
             <i class='bx bxs-school absolute -bottom-10 -left-10 text-[10rem] md:text-[20rem]'></i>
        </div>
    </div>

    <!-- Right Panel: Login Form -->
    <!-- Mobile: Order 2 (Bottom), Desktop: Order 2 (Right) -->
    <div class="w-full md:w-1/2 bg-white flex items-center justify-center p-8 order-last min-h-[70vh] md:min-h-screen">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                <p class="mt-2 text-sm text-gray-600">Please sign in to access your portal.</p>
            </div>

            <form wire:submit="login" class="mt-8 space-y-6">
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-envelope text-gray-400'></i>
                            </div>
                            <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required
                                class="pl-10 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-3"
                                placeholder="name@marriott.edu.ph">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-lock-alt text-gray-400'></i>
                            </div>
                            <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required
                                class="pl-10 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-3"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Forgot Password?
                        </a>
                    </div>
                     <span class="text-xs text-gray-400">Contact the Registrar</span>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class='bx bx-log-in-circle text-blue-300 group-hover:text-blue-100'></i>
                        </span>
                        Sign In to Portal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
