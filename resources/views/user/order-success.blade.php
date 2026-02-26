@extends('user_layout.user')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="glass-panel p-8 text-center w-full max-w-sm fade-in-up">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">🎉</div>
            <h1 class="text-2xl font-black text-[#2D2723] mb-2">Order Confirmed!</h1>
            <p class="text-sm text-[#9CA3AF] mb-6">Your smart tags are on the way.</p>

            <div class="bg-white/50 rounded-xl p-4 mb-6 text-left">
                <p class="text-xs font-bold text-[#9CA3AF] uppercase">Order ID</p>
                <p class="font-mono font-bold text-[#2D2723]">{{ $order->order_number }}</p>
            </div>

            <a href="{{ route('user.products') }}" class="btn-coffee w-full py-4 shadow-lg">Back to Store</a>
        </div>
    </div>
@endsection
