<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Owner - QwickReach</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen"
    style="background: linear-gradient(135deg, #e6e6fa 0%, #d8b5ff 50%, #fff5f7 100%);">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">

            <!-- Main Card -->
            <div class="bg-white/90 backdrop-blur-lg rounded-[2.5rem] shadow-2xl overflow-hidden">

                <!-- Header -->
                <div class="bg-gradient-to-r from-purple-100 to-purple-50 px-8 py-10 text-center border-b border-purple-100">
                    <!-- Language Toggle -->
                    <div class="flex justify-end mb-6">
                        <div class="inline-flex rounded-full bg-white/80 p-1 shadow-sm">
                            <button class="px-4 py-2 rounded-full bg-white shadow-sm text-sm font-medium text-gray-900">
                                EN
                            </button>
                            <button
                                class="px-4 py-2 rounded-full text-sm font-medium text-gray-600 hover:text-gray-900">
                                हिंदी
                            </button>
                        </div>
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-black text-purple-900 mb-3">QwickReach</h1>
                    <p class="text-gray-600 text-lg font-medium">Instantly connect with the owner</p>
                </div>

                <!-- Contact Options -->
                <div class="p-8 lg:p-12 space-y-4">

                    <!-- Contact Owner Button -->
                    <button onclick="handleContactOwner()"
                        class="w-full flex items-center justify-center gap-4 py-6 px-8 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-3xl font-bold text-xl shadow-xl shadow-purple-200 hover:from-purple-600 hover:to-purple-700 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" />
                        </svg>
                        <span>Contact Owner</span>
                    </button>

                    <!-- WhatsApp Button -->
                    <button onclick="handleWhatsApp()"
                        class="w-full flex items-center justify-center gap-4 py-6 px-8 bg-white border-2 border-gray-200 text-gray-800 rounded-3xl font-bold text-xl shadow-lg hover:border-green-400 hover:bg-green-50 transition-all transform hover:scale-[1.02] active:scale-[0.98] group">
                        <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        <span class="group-hover:text-green-600 transition-colors">WhatsApp Owner</span>
                    </button>

                    <!-- Emergency Button -->
                    <button onclick="handleEmergency()"
                        class="w-full flex items-center justify-center gap-4 py-6 px-8 bg-gradient-to-r from-red-400 to-red-500 text-white rounded-3xl font-bold text-xl shadow-xl shadow-red-200 hover:from-red-500 hover:to-red-600 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                        </svg>
                        <span>Emergency</span>
                    </button>

                    <!-- Help Text -->
                    <p class="text-center text-gray-500 text-sm mt-8 px-4">
                        Reach the rightful owner quickly if something is ever lost.
                    </p>
                </div>

                <!-- Footer -->
                <div class="px-8 py-6 bg-gray-50 text-center border-t border-gray-100">
                    <p class="text-sm text-gray-500">
                        Powered by <span class="font-bold text-purple-600">QwickReach</span> © 2026
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Phone Number Modal -->
    <div id="phoneModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl transform transition-all">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Enter Your Phone Number</h3>
            <div class="space-y-4">
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">+91</span>
                    <input type="tel" id="scannerPhone" placeholder="Mobile Number" maxlength="10"
                        pattern="[0-9]{10}"
                        class="w-full pl-16 pr-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:border-purple-400 focus:bg-white outline-none transition-all">
                </div>
                <div class="flex gap-3">
                    <button onclick="closePhoneModal()"
                        class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                        Cancel
                    </button>
                    <button id="confirmCallBtn" onclick="confirmCall()"
                        class="flex-1 py-3 bg-purple-600 text-white rounded-xl font-semibold hover:bg-purple-700 transition-all">
                        Call Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Emergency Contacts Modal -->
    <div id="emergencyModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl transform transition-all">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Emergency Contacts</h3>
            <p class="text-gray-500 mb-6">Choose a contact to call</p>
            <div id="emergencyContactsList" class="space-y-3 mb-6">
                <!-- Will be populated dynamically -->
            </div>
            <button onclick="closeEmergencyModal()"
                class="w-full py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                Cancel
            </button>
        </div>
    </div>

    <script>
        const qrCodeId = {{ $qrCode->id }};
        let currentAction = null;

        function handleContactOwner() {
            currentAction = 'owner';
            document.getElementById('phoneModal').classList.remove('hidden');
            document.getElementById('scannerPhone').focus();
        }

        function handleWhatsApp() {
            fetch(`/api/qr/${qrCodeId}/whatsapp`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.open(data.whatsapp_link, '_blank');
                    } else {
                        alert(data.message || 'Failed to create WhatsApp link');
                    }
                })
                .catch(err => alert('Error: ' + err.message));
        }

        function handleEmergency() {
            fetch(`/api/qr/${qrCodeId}/emergency`)
                .then(res => res.json())
                .then(data => {
                    if (data.success && data.emergency_contacts && data.emergency_contacts.length > 0) {
                        showEmergencyContacts(data.emergency_contacts);
                    } else {
                        alert('No emergency contacts available');
                    }
                })
                .catch(err => alert('Error: ' + err.message));
        }

        function showEmergencyContacts(contacts) {
            const list = document.getElementById('emergencyContactsList');
            list.innerHTML = '';

            contacts.forEach((contact, index) => {
                const div = document.createElement('div');
                div.className =
                    'p-4 bg-red-50 rounded-xl cursor-pointer hover:bg-red-100 transition-all border-2 border-transparent hover:border-red-300';
                div.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">${contact.name || 'Emergency Contact ' + (index + 1)}</p>
                            <p class="text-sm text-gray-600">${contact.number}</p>
                        </div>
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                        </svg>
                    </div>
                `;
                div.onclick = () => initiateEmergencyCall(contact.number);
                list.appendChild(div);
            });

            document.getElementById('emergencyModal').classList.remove('hidden');
        }

        function initiateEmergencyCall(emergencyNumber) {
            const scannerNumber = prompt('Enter your phone number to connect:');
            if (!scannerNumber || scannerNumber.length !== 10) {
                alert('Please enter a valid 10-digit phone number');
                return;
            }

            fetch(`/api/qr/${qrCodeId}/emergency-call`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        scanner_number: scannerNumber,
                        emergency_number: emergencyNumber
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Call initiated! You will receive a call shortly.');
                        closeEmergencyModal();
                    } else {
                        alert(data.message || 'Failed to initiate call');
                    }
                })
                .catch(err => alert('Error: ' + err.message));
        }

        function confirmCall() {
            const phone = document.getElementById('scannerPhone').value;
            if (!phone || phone.length !== 10) {
                alert('Please enter a valid 10-digit phone number');
                return;
            }

            fetch(`/api/qr/${qrCodeId}/call`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        scanner_number: phone
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Call initiated! You will receive a call shortly.');
                        closePhoneModal();
                    } else {
                        alert(data.message || 'Failed to initiate call');
                    }
                })
                .catch(err => alert('Error: ' + err.message));
        }

        function closePhoneModal() {
            document.getElementById('phoneModal').classList.add('hidden');
            document.getElementById('scannerPhone').value = '';
        }

        function closeEmergencyModal() {
            document.getElementById('emergencyModal').classList.add('hidden');
        }

        // Allow Enter key to submit phone number
        document.getElementById('scannerPhone').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                confirmCall();
            }
        });
    </script>
</body>

</html>
