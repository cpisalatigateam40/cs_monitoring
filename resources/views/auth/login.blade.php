<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌡️ Pemantauan Suhu Gudang Berpendingin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            box-sizing: border-box;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="h-full bg-gradient-to-br from-blue-50 to-indigo-100 font-sans">
    <div id="loginPage" class="min-h-full relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900">
            <!-- Abstract Geometric Shapes -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
                <!-- Large Circle -->
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full blur-3xl animate-pulse"></div>
                <!-- Medium Circle -->
                <div class="absolute top-1/2 -left-20 w-60 h-60 bg-gradient-to-br from-purple-400/15 to-pink-500/15 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
                <!-- Small Circle -->
                <div class="absolute bottom-20 right-1/4 w-40 h-40 bg-gradient-to-br from-cyan-400/20 to-blue-500/20 rounded-full blur-xl animate-pulse" style="animation-delay: 2s;"></div>

                <!-- Floating Documents -->
                <div class="absolute top-1/4 left-1/4 opacity-10">
                    <svg class="w-16 h-16 text-white animate-bounce" style="animation-delay: 0.5s;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                    </svg>
                </div>
                <div class="absolute top-3/4 right-1/3 opacity-10">
                    <svg class="w-12 h-12 text-white animate-bounce" style="animation-delay: 1.5s;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19,3H5C3.9,3 3,3.9 3,5V19C3,20.1 3.9,21 5,21H19C20.1,21 21,20.1 21,19V5C21,3.9 20.1,3 19,3M19,19H5V5H19V19M17,12H7V10H17V12M15,16H7V14H15V16M17,8H7V6H17V8Z" />
                    </svg>
                </div>
                <div class="absolute bottom-1/3 left-1/3 opacity-10">
                    <svg class="w-14 h-14 text-white animate-bounce" style="animation-delay: 2.5s;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9,4V6H15V4H17V6H20A2,2 0 0,1 22,8V19A2,2 0 0,1 20,21H4A2,2 0 0,1 2,19V8A2,2 0 0,1 4,6H7V4H9M4,8V19H20V8H4M6,10H8V12H6V10M10,10H12V12H10V10M14,10H16V12H14V10M18,10H20V12H18V10M6,14H8V16H6V14M10,14H12V16H10V14M14,14H16V16H14V14M6,18H8V20H6V18M10,18H12V20H10V18Z" />
                    </svg>
                </div>

                <!-- Grid Pattern -->
                <div class="absolute inset-0 opacity-5">
                    <div class="grid grid-cols-12 gap-4 h-full">
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div class="border-r border-white/20"></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Content -->
        <div class="relative z-10 min-h-full flex items-center justify-center px-4 py-12">
            <div class="max-w-md w-full space-y-8">
                <!-- Logo and Title Section -->
                <div class="text-center">
                    <!-- Enhanced Logo -->
                    <div class="mx-auto w-24 h-24 relative mb-8">
                        <!-- Outer Ring -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600 rounded-3xl shadow-2xl transform rotate-6 animate-pulse"></div>
                        <!-- Inner Container -->
                        <div class="relative w-full h-full bg-gradient-to-br from-white to-gray-100 rounded-2xl flex items-center justify-center shadow-xl">
                            <!-- Document Stack Icon -->
                            <div class="relative">
                                <!-- Back Document -->
                                <div class="absolute -top-1 -right-1 w-8 h-10 bg-gradient-to-br from-blue-300 to-blue-400 rounded-sm transform rotate-12 opacity-60"></div>
                                <!-- Middle Document -->
                                <div class="absolute -top-0.5 -right-0.5 w-8 h-10 bg-gradient-to-br from-indigo-400 to-indigo-500 rounded-sm transform rotate-6 opacity-80"></div>
                                <!-- Front Document -->
                                <div class="w-8 h-10 bg-gradient-to-br from-slate-600 to-slate-700 rounded-sm flex flex-col items-center justify-center relative">
                                    <!-- Document Lines -->
                                    <div class="w-5 h-0.5 bg-white/80 rounded mb-1"></div>
                                    <div class="w-4 h-0.5 bg-white/60 rounded mb-1"></div>
                                    <div class="w-5 h-0.5 bg-white/80 rounded mb-1"></div>
                                    <div class="w-3 h-0.5 bg-white/60 rounded"></div>
                                    <!-- Checkmark -->
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Title -->
                    <div class="space-y-3">
                        <h1 class="text-4xl md:text-5xl font-black bg-gradient-to-r from-white via-blue-100 to-indigo-200 bg-clip-text text-transparent leading-tight">
                            Pemantauan Suhu Gudang Berpendingin
                        </h1>
                        <div class="flex items-center justify-center space-x-2 mt-4">
                            <div class="w-8 h-0.5 bg-gradient-to-r from-transparent to-blue-400 rounded"></div>
                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                            <div class="w-8 h-0.5 bg-gradient-to-l from-transparent to-blue-400 rounded"></div>
                        </div>
                        <p class="text-blue-300/80 text-sm">
                            Silakan masuk untuk mengakses sistem
                        </p>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 border border-white/20">
                    <form action="{{route('login')}}" method="post" class="space-y-6">
                        @csrf
                        <div>
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-3">Username</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input id="login" name="login" type="text" required
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 bg-white/80 backdrop-blur-sm"
                                    placeholder="Masukkan username">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-3">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" required
                                    class="w-full pl-12 pr-14 py-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 bg-white/80 backdrop-blur-sm"
                                    placeholder="Masukkan password">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <svg id="eyeIcon" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div id="loginError"
                            class="{{ session('loginError') ? '' : 'hidden' }} bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ session('loginError') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white py-4 px-6 rounded-xl hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 focus:ring-4 focus:ring-blue-500/50 focus:ring-offset-2 transition-all duration-300 font-bold text-lg shadow-xl hover:shadow-2xl transform hover:-translate-y-1 relative overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative flex items-center justify-center space-x-2">
                                <span>Masuk ke Sistem</span>
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </div>
                        </button>
                    </form>

                    <!-- Demo Accounts -->
                    <!-- <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            <div class="flex items-center space-x-2 mb-3">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="font-semibold text-gray-700">Demo Account:</p>
                            </div>
                            <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-4 rounded-xl space-y-2 text-xs border border-gray-200">
                                <div class="grid grid-cols-1 gap-2">
                                    <p class="flex justify-between"><span class="font-semibold text-red-600">Top Manager:</span><span class="font-mono bg-white px-2 py-1 rounded">topmanager / top123</span></p>
                                    <p class="flex justify-between"><span class="font-semibold text-green-600">Manager QC:</span><span class="font-mono bg-white px-2 py-1 rounded">managerqc / qc123</span></p>
                                    <p class="flex justify-between"><span class="font-semibold text-blue-600">Manager Dept:</span><span class="font-mono bg-white px-2 py-1 rounded">managerdept / dept123</span></p>
                                    <p class="flex justify-between"><span class="font-semibold text-yellow-600">Admin QC:</span><span class="font-mono bg-white px-2 py-1 rounded">adminqc / adminqc123</span></p>
                                    <p class="flex justify-between"><span class="font-semibold text-purple-600">Admin Breadcrumb:</span><span class="font-mono bg-white px-2 py-1 rounded">adminbread / bread123</span></p>
                                    <p class="flex justify-between"><span class="font-semibold text-indigo-600">Admin Warehouse:</span><span class="font-mono bg-white px-2 py-1 rounded">adminwarehouse / warehouse123</span></p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.974 9.974 0 013.08-4.419M15 12a3 3 0 11-6 0 3 3 0 016 0zM19.13 19.13L4.87 4.87" />
                `;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</body>