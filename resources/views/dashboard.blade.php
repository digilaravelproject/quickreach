@extends('layout.app')
@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 lg:p-10">

        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
                <p class="text-gray-500 mt-1">Welcome back, here's what's happening with QwickReach today.</p>
            </div>
            <button
                class="bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-800 transition-colors shadow-lg">
                + Generate New QRs
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">12,450</h3>
                    <div class="flex items-center mt-2 text-sm">
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded-full font-medium flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            12%
                        </span>
                        <span class="text-gray-400 ml-2">vs last month</span>
                    </div>
                </div>
                <div
                    class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-brand-50 to-transparent opacity-50 group-hover:from-brand-100 transition-all">
                </div>
                <svg class="absolute right-4 bottom-4 w-16 h-16 text-brand-100 transform rotate-12 group-hover:scale-110 transition-transform duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>

            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-sm font-medium text-gray-500">Active QR Tags</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">8,200</h3>
                    <div class="flex items-center mt-2 text-sm">
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded-full font-medium flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            8.5%
                        </span>
                        <span class="text-gray-400 ml-2">vs last month</span>
                    </div>
                </div>
                <svg class="absolute right-4 bottom-4 w-16 h-16 text-blue-100 transform rotate-12 group-hover:scale-110 transition-transform duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                    </path>
                </svg>
            </div>

            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-sm font-medium text-gray-500">Revenue</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">₹4.2L</h3>
                    <div class="flex items-center mt-2 text-sm">
                        <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded-full font-medium flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            2.1%
                        </span>
                        <span class="text-gray-400 ml-2">vs last month</span>
                    </div>
                </div>
                <svg class="absolute right-4 bottom-4 w-16 h-16 text-yellow-100 transform rotate-12 group-hover:scale-110 transition-transform duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
            </div>

            <div
                class="bg-gradient-to-br from-brand-600 to-indigo-700 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden flex flex-col justify-between">
                <div>
                    <p class="text-white/80 font-medium">Pending Scans</p>
                    <h3 class="text-3xl font-bold mt-1">45</h3>
                    <p class="text-xs text-white/60 mt-2">Requires immediate attention</p>
                </div>
                <button
                    class="mt-4 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors w-fit">
                    View Reports →
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Scan Activity & Sales</h3>
                    <select
                        class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg px-3 py-1 focus:ring-brand-500 focus:border-brand-500 block">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>This Year</option>
                    </select>
                </div>
                <div class="h-80 w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-0 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Registrations</h3>
                    <a href="#" class="text-sm text-brand-600 hover:text-brand-800 font-medium">View
                        All</a>
                </div>
                <div class="overflow-y-auto max-h-[380px]">
                    <table class="w-full text-left border-collapse">
                        <tbody class="divide-y divide-gray-100">

                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                            AS</div>
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">Amit Sharma</p>
                                            <p class="text-xs text-gray-500">Car QR Tag</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">2 mins ago</p>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=Priya+V&background=f0fdf4&color=166534"
                                            alt="">
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">Priya Verma</p>
                                            <p class="text-xs text-gray-500">Pet Tag (Dog)</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">15 mins ago</p>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center font-bold text-sm">
                                            RK</div>
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">Rahul Kumar</p>
                                            <p class="text-xs text-gray-500">Bike QR Tag</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                                </td>
                            </tr>

                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=Sneha+G&background=fef2f2&color=991b1b"
                                            alt="">
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">Sneha Gupta</p>
                                            <p class="text-xs text-gray-500">Combo Pack</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
@endsection
