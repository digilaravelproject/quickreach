@extends('user_layout.user')

@section('content')
    <div class="p-6 space-y-10 pb-32 anim-fade-up">

        <div class="text-center space-y-3">
            <h1 class="font-display text-4xl font-black text-indigo-900 leading-tight">
                Contact <span class="text-indigo-600">Us</span>
            </h1>
            <p class="text-gray-500 text-sm max-w-xs mx-auto leading-relaxed">
                Have a question or need help with your QwickReach tag? Send us a message and we'll respond as soon as
                possible.
            </p>
        </div>

        <div class="bg-white p-8 rounded-[40px] shadow-2xl shadow-indigo-100 border border-indigo-50">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-500 text-white rounded-2xl text-[11px] font-bold text-center animate-pulse">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('user.contact.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2 mb-1 block">Full
                        Name</label>
                    <input type="text" name="name" required placeholder="Enter your name"
                        class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-bold">
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2 mb-1 block">Email
                        Address</label>
                    <input type="email" name="email" required placeholder="email@example.com"
                        class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-bold">
                </div>

                <div>
                    <label
                        class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2 mb-1 block">Message</label>
                    <textarea name="message" rows="5" required placeholder="How can we help you?"
                        class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-bold"></textarea>
                </div>

                <button type="submit"
                    class="w-full py-5 bg-indigo-600 text-white font-black rounded-3xl shadow-xl shadow-indigo-200 active:scale-95 transition-all uppercase text-xs tracking-widest">
                    Submit Inquiry
                </button>
            </form>
        </div>

        <div class="space-y-4">
            <div class="flex items-center gap-4 bg-white p-5 rounded-[30px] border border-gray-100">
                <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-xl">
                    <i class="ri-mail-line"></i>
                </div>
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase">Official Support</h4>
                    <p class="text-sm font-bold text-indigo-900">support@qwickreach.com</p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-white p-5 rounded-[30px] border border-gray-100">
                <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 text-xl">
                    <i class="ri-whatsapp-line"></i>
                </div>
                <div>
                    <h4 class="text-[10px] font-black text-gray-400 uppercase">WhatsApp Chat</h4>
                    <p class="text-sm font-bold text-green-900">+91 0000000000</p>
                </div>
            </div>
        </div>

    </div>
@endsection
