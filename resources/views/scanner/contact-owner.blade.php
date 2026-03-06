@extends('user_layout.user')

@section('content')
    <div x-data="contactOwner()"
        class="min-h-[calc(100vh-64px)] bg-[#F5F3FA] flex flex-col items-center px-4 py-6 font-sans pb-12">
        <div class="max-w-md w-full">

            <div class="space-y-4">

                {{-- 1. Call Owner Button (Dark Purple) --}}
                <button @click="openCallModal('{{ $ownerDetails->mobile_number }}', 'Owner')"
                    class="w-full bg-[#4B3D76] hover:bg-[#3c315e] text-white py-4 rounded-2xl font-black text-base shadow-lg shadow-indigo-900/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    <svg class="w-5 h-5 text-[#86D657]" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    Call Owner
                </button>

                {{-- 2. WhatsApp Button --}}
                <a href="{{ route('qr.whatsapp', $qrCode->id) }}" target="_blank"
                    class="w-full bg-[#25D366] hover:bg-[#20bd5a] text-white py-4 rounded-2xl font-black text-base shadow-lg shadow-green-600/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    WhatsApp Message
                </a>

                {{-- 3. Emergency Button (Red) --}}
                <button @click="showEmergency = true"
                    class="w-full bg-[#F05252] hover:bg-[#d94444] text-white py-4 rounded-2xl font-black text-base shadow-lg shadow-red-500/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Emergency Call
                </button>

                {{-- 4. SOS Card Section --}}
                <div
                    class="bg-white/90 backdrop-blur-xl rounded-[2.5rem] p-6 shadow-xl border border-white mt-4 relative overflow-hidden">

                    {{-- SOS Header --}}
                    <div class="text-center mb-5">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-[#EBE5F7] rounded-full text-[#4B3D76] mb-2 shadow-inner">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.642 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.358-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-black text-gray-900 leading-tight">SOS</h2>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Quick Access to
                            Emergency Services</p>
                    </div>

                    {{-- SOS Links (Direct tel: - ye government numbers hain, Bonvoice ki zaroorat nahi) --}}
                    <div class="space-y-3">
                        <a href="tel:100"
                            class="flex items-center justify-between w-full bg-[#4B3D76] text-white py-3.5 px-5 rounded-2xl font-black text-sm shadow-md transition-all active:scale-[0.98]">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                POLICE 100
                            </div>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                        <a href="tel:108"
                            class="flex items-center justify-between w-full bg-[#EBE5F7] text-[#4B3D76] py-3.5 px-5 rounded-2xl font-black text-sm shadow-sm transition-all active:scale-[0.98]">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                AMBULANCE 108
                            </div>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                        <a href="tel:101"
                            class="flex items-center justify-between w-full bg-white border-2 border-[#F05252] text-[#F05252] py-3.5 px-5 rounded-2xl font-black text-sm shadow-sm transition-all active:scale-[0.98]">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                                </svg>
                                FIRE BRIGADE 101
                            </div>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    {{-- Dynamic Emergency Note --}}
                    @if (!empty($ownerDetails->emergency_note))
                        <div class="mt-5 bg-[#FEF9E8] rounded-2xl p-4 border border-[#FDE89F]">
                            <p class="text-[10px] font-black text-[#D97706] uppercase tracking-wider mb-2">Emergency Note
                            </p>
                            <div class="flex gap-2 items-start">
                                <svg class="w-5 h-5 text-[#F59E0B] shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm font-semibold text-gray-800 leading-snug">
                                    {{ $ownerDetails->emergency_note }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="text-center pt-6 pb-2 flex justify-center">
                    <p
                        class="text-gray-400 text-[10px] font-black uppercase tracking-[0.15em] flex items-center gap-2 justify-center">
                        Powered by <img src="{{ asset('assets/images/logos/quickreach_logo.jpeg') }}" alt="QwickReach Logo"
                            class="qw_logo" style="height: 15px; width: auto; object-fit: contain;">
                    </p>
                </div>
            </div>
        </div>

        {{-- =============================================
             CALL MODAL - Caller ka number maango
             (Call Owner + Emergency dono iske liye)
             ============================================= --}}
        <div x-show="showCallModal" x-transition.opacity
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
            style="display: none;">
            <div @click.away="closeCallModal()"
                class="bg-white rounded-[2.5rem] p-6 max-w-xs w-full shadow-2xl border border-[#F5F3FA]">

                {{-- Modal Header --}}
                <div class="text-center mb-5">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 bg-[#EBE5F7] rounded-2xl mb-3 shadow-inner">
                        <svg class="w-6 h-6 text-[#4B3D76]" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-black text-gray-900">Connect Call</h3>
                    <p class="text-[11px] text-gray-500 font-semibold mt-1">
                        Calling: <span class="text-[#4B3D76]" x-text="callTargetName"></span>
                    </p>
                </div>

                {{-- Caller Number Input --}}
                <div class="mb-4">
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-wider mb-1 block">
                        Your Mobile Number
                    </label>
                    <input x-model="callerNumber" type="tel" maxlength="10" placeholder="Enter your 10-digit number"
                        class="w-full border-2 border-[#EBE5F7] focus:border-[#4B3D76] rounded-xl px-4 py-3 text-sm font-bold text-gray-800 focus:outline-none transition-all">
                    <p x-show="callError" x-text="callError" class="text-[10px] text-red-500 font-bold mt-1"></p>
                </div>

                {{-- Connect Button --}}
                <button @click="confirmCall()" :disabled="calling"
                    class="w-full py-3.5 bg-[#4B3D76] text-white rounded-xl font-black text-sm hover:bg-[#3c315e] transition-all active:scale-95 shadow-lg disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <svg x-show="!calling" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    {{-- Spinner --}}
                    <svg x-show="calling" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    <span x-text="calling ? 'Connecting...' : 'Connect Call'"></span>
                </button>

                {{-- Cancel --}}
                <button @click="closeCallModal()"
                    class="w-full py-3 mt-2 bg-gray-100 text-gray-500 rounded-xl font-black text-xs hover:bg-gray-200 transition-all">
                    Cancel
                </button>
            </div>
        </div>

        {{-- =============================================
             EMERGENCY CONTACTS MODAL
             ============================================= --}}
        <div x-show="showEmergency" x-transition.opacity
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
            style="display: none;">
            <div @click.away="showEmergency = false"
                class="bg-white rounded-[2.5rem] p-6 max-w-xs w-full shadow-2xl border border-[#F5F3FA]">

                <div class="text-center mb-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-red-50 rounded-2xl mb-2 shadow-inner">
                        <svg class="w-6 h-6 text-[#F05252]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 leading-tight">Personal Contacts</h3>
                </div>

                <div class="space-y-2 mb-6">
                    @if (!empty($ownerDetails->emergency_contacts))
                        @foreach ($ownerDetails->emergency_contacts as $contact)
                            {{-- Har contact pe click se Call Modal khulega --}}
                            <button
                                @click="
                                    showEmergency = false;
                                    openCallModal('{{ $contact['number'] }}', '{{ $contact['name'] }}')
                                "
                                class="block w-full p-3 bg-[#F5F3FA] hover:bg-[#EBE5F7] border-2 border-transparent hover:border-[#F05252]/20 rounded-xl flex items-center justify-between group transition-all active:scale-[0.97]">
                                <div class="text-left">
                                    <p class="font-black text-gray-800 text-xs tracking-tight">{{ $contact['name'] }}</p>
                                    <p class="text-[10px] font-bold text-[#4B3D76]">{{ $contact['number'] }}</p>
                                </div>
                                <div class="w-7 h-7 bg-white rounded-full flex items-center justify-center shadow-sm">
                                    <svg class="w-3 h-3 text-[#F05252]" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                            </button>
                        @endforeach
                    @else
                        <div class="text-center py-4 bg-gray-50 rounded-2xl">
                            <p class="text-gray-400 text-xs font-bold uppercase">No contacts available.</p>
                        </div>
                    @endif
                </div>

                <button @click="showEmergency = false"
                    class="w-full py-3 bg-[#4B3D76] text-white rounded-xl font-black text-xs hover:bg-[#3c315e] transition-all active:scale-95 shadow-lg">
                    CLOSE
                </button>
            </div>
        </div>

    </div>

    <script>
        function contactOwner() {
            return {
                // Emergency modal
                showEmergency: false,

                // Call modal
                showCallModal: false,
                callTargetNumber: '', // Jise call karni hai (owner ya emergency contact)
                callTargetName: '', // Display name
                callerNumber: '', // Jo call kar raha hai (user ka number)
                calling: false,
                callError: '',

                // Call modal open karo
                openCallModal(targetNumber, targetName) {
                    this.callTargetNumber = targetNumber;
                    this.callTargetName = targetName;
                    this.callerNumber = '';
                    this.callError = '';
                    this.calling = false;
                    this.showCallModal = true;
                },

                // Call modal close karo
                closeCallModal() {
                    this.showCallModal = false;
                    this.callTargetNumber = '';
                    this.callTargetName = '';
                    this.callerNumber = '';
                    this.callError = '';
                    this.calling = false;
                },

                // Call confirm karo aur API hit karo
                confirmCall() {
                    this.callError = '';

                    // Validation
                    const num = this.callerNumber.trim();
                    if (!num || num.length < 10) {
                        this.callError = 'Please enter a valid 10-digit mobile number';
                        return;
                    }

                    this.calling = true;

                    fetch('{{ route('call.owner', $qrCode->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                caller_number: num,
                                agent_number: this.callTargetNumber
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.calling = false;
                            if (data.success) {
                                this.closeCallModal();
                                // Success toast / alert
                                alert('✅ Call connecting to ' + this.callTargetName + '! Please wait...');
                            } else {
                                // Bonvoice fail hua toh direct call fallback
                                this.closeCallModal();
                                window.location.href = 'tel:' + this.callTargetNumber;
                            }
                        })
                        .catch(() => {
                            this.calling = false;
                            // Network error fallback - direct call
                            this.closeCallModal();
                            window.location.href = 'tel:' + this.callTargetNumber;
                        });
                }
            }
        }
    </script>
@endsection
