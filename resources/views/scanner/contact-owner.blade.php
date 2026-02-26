@extends('user_layout.user')

@section('content')
    <div x-data="contactOwner()"
        class="h-[calc(100vh-64px)] bg-gray-50 flex items-center justify-center px-4 overflow-hidden"> {{-- Fixed height and hidden overflow --}}
        <div class="max-w-md w-full">

            {{-- Main Card --}}
            <div class="bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-2xl">

                {{-- Header: Reduced padding from 10 to 6 --}}
                <div class="bg-gradient-to-br from-[#86D657] to-[#77c24a] px-6 py-6 text-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/5 opacity-10"></div>
                    <div class="relative z-10">
                        {{-- Language Toggle: Smaller margin --}}
                        <div class="flex justify-end mb-2">
                            <div
                                class="bg-white/90 backdrop-blur-xl rounded-full p-0.5 border border-white shadow-sm flex gap-1">
                                <button @click="lang = 'en'"
                                    :class="lang === 'en' ? 'bg-gray-900 text-white shadow-md' : 'text-gray-500'"
                                    class="px-3 py-1 rounded-full font-bold text-[9px] uppercase tracking-wider transition-all">EN</button>
                                <button @click="lang = 'hi'"
                                    :class="lang === 'hi' ? 'bg-gray-900 text-white shadow-md' : 'text-gray-500'"
                                    class="px-3 py-1 rounded-full font-bold text-[9px] uppercase tracking-wider transition-all">हिंदी</button>
                            </div>
                        </div>

                        <h1 class="text-3xl font-black text-gray-900 mb-1 tracking-tighter">QwickReach</h1>
                        <p class="text-gray-800/80 text-xs font-bold">
                            <span
                                x-text="lang === 'en' ? 'Instantly connect with the owner' : 'मालिक से तुरंत संपर्क करें'"></span>
                        </p>
                    </div>
                </div>

                {{-- Content Options: Reduced padding and spacing --}}
                <div class="p-5 sm:p-6 space-y-3">

                    {{-- 1. Contact Owner Button --}}
                    <a href="tel:{{ $ownerDetails->mobile_number }}"
                        class="w-full bg-gray-900 hover:bg-black text-white py-4 rounded-2xl font-black text-base shadow-xl transition-all active:scale-[0.98] flex items-center justify-center gap-3 group border-b-4 border-[#86D657]">
                        <svg class="w-5 h-5 text-[#86D657]" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        <span x-text="lang === 'en' ? 'Call Owner' : 'मालिक को कॉल करें'">Call Owner</span>
                    </a>

                    {{-- 2. WhatsApp Owner Button --}}
                    <a href="{{ route('qr.whatsapp', $qrCode->id) }}" target="_blank"
                        class="w-full bg-white hover:bg-gray-50 border-2 border-gray-100 text-gray-800 py-4 rounded-2xl font-black text-base transition-all active:scale-[0.98] flex items-center justify-center gap-3 group shadow-sm">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        <span x-text="lang === 'en' ? 'WhatsApp' : 'व्हाट्सएप'">WhatsApp</span>
                    </a>

                    {{-- 3. Emergency Button --}}
                    <button @click="showEmergency = true"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-4 rounded-2xl font-black text-base shadow-lg transition-all active:scale-[0.98] flex items-center justify-center gap-3 group">
                        <svg class="w-6 h-6 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span x-text="lang === 'en' ? 'Emergency Call' : 'आपातकालीन कॉल'">Emergency</span>
                    </button>

                    {{-- Compact Help Text --}}
                    <p
                        class="text-center text-gray-400 text-[10px] font-bold mt-4 px-4 leading-tight uppercase tracking-tighter">
                        <span
                            x-text="lang === 'en' ? 'Reach the rightful owner quickly if lost.' : 'खो जाने पर मालिक तक जल्दी पहुंचें।'"></span>
                    </p>
                </div>

                {{-- Footer: Compacted --}}
                <div class="px-10 pb-5 text-center border-t border-gray-50 pt-3">
                    <p class="text-gray-300 text-[9px] font-black uppercase tracking-[0.1em]">
                        Powered by <span class="text-gray-900">Qwick<span class="text-[#86D657]">Reach</span></span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Emergency Modal: Remains functional but fits mobile screens --}}
        <div x-show="showEmergency" x-transition.opacity
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
            style="display: none;">
            <div @click.away="showEmergency = false"
                class="bg-white rounded-[2.5rem] p-6 max-w-xs w-full shadow-2xl border border-red-50">
                <div class="text-center mb-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-red-50 rounded-2xl mb-2 shadow-inner">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 leading-tight">Emergency Contacts</h3>
                </div>

                <div class="space-y-2 mb-6">
                    @if (!empty($ownerDetails->emergency_contacts))
                        @foreach ($ownerDetails->emergency_contacts as $contact)
                            <a href="tel:{{ $contact['number'] }}"
                                class="block w-full p-3 bg-gray-50 hover:bg-red-50 border-2 border-transparent hover:border-red-100 rounded-xl flex items-center justify-between group transition-all active:scale-[0.97]">
                                <div>
                                    <p class="font-black text-gray-800 text-xs tracking-tight">{{ $contact['name'] }}</p>
                                    <p class="text-[10px] font-bold text-red-500">{{ $contact['number'] }}</p>
                                </div>
                                <div class="w-7 h-7 bg-white rounded-full flex items-center justify-center shadow-sm">
                                    <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center py-4 bg-gray-50 rounded-2xl">
                            <p class="text-gray-400 text-xs font-bold uppercase">No contacts available.</p>
                        </div>
                    @endif
                </div>

                <button @click="showEmergency = false"
                    class="w-full py-3 bg-gray-900 text-white rounded-xl font-black text-xs hover:bg-black transition-all active:scale-95 shadow-lg">
                    CLOSE
                </button>
            </div>
        </div>
    </div>

    <script>
        function contactOwner() {
            return {
                lang: 'en',
                showEmergency: false
            }
        }
    </script>
@endsection
