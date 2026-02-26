@extends('user_layout.user')
@section('content')
    {{-- Main Container --}}
    <div class="min-h-screen bg-[#F5F5F3] py-8 px-5 max-w-md mx-auto">
        {{-- ── HEADER ── --}}
        <div class="flex items-center mb-8">
            <div>
                <p class="f-display"
                    style="font-size:10px;font-weight:600;color:#ADADAD;letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">
                    QwickReach</p>
                <h1 class="f-display" style="font-size:22px;font-weight:800;color:#0A0A0A;line-height:1.2">Register Your Tag
                </h1>
            </div>
        </div>

        {{-- ── QR INFO PILL ── --}}
        <div
            style="background:#fff;border-radius:20px;border:1px solid rgba(0,0,0,.07);padding:14px 18px;display:flex;align-items:center;gap:14px;margin-bottom:24px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.05)">
            <div
                style="width:44px;height:44px;background:#F5F5F3;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;border: 1px solid #eee;">
                🏷️</div>
            <div style="flex:1;min-width:0">
                <p class="f-display"
                    style="font-size:9px;color:#ADADAD;font-weight:700;text-transform:uppercase;letter-spacing:.12em;margin-bottom:2px">
                    Category</p>
                <p class="f-display" style="font-size:14px;font-weight:800;color:#0A0A0A">{{ $qrCode->category->name }}</p>
            </div>
            <div style="text-align:right;flex-shrink:0">
                <p class="f-display"
                    style="font-size:9px;color:#ADADAD;font-weight:700;text-transform:uppercase;letter-spacing:.12em;margin-bottom:2px">
                    QR Code</p>
                <p class="f-display"
                    style="font-size:12px;font-weight:800;color:#0A0A0A;background:#F5F5F3;padding:4px 10px;border-radius:8px; border: 1px solid rgba(134, 214, 87, 0.2)">
                    {{ $qrCode->qr_code }}</p>
            </div>
        </div>

        {{-- ── FORM CARD ── --}}
        <div
            style="background:#fff;border-radius:28px;border:1px solid rgba(0,0,0,.07);padding:24px 20px;box-shadow:0 20px 30px -10px rgba(0,0,0,0.07);margin-bottom:24px">
            <form action="{{ route('user.register-qr.store', $qrCode->id) }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div
                        style="margin-bottom:20px;background:#FFF1F2;border:1.5px solid #FECDD3;border-radius:16px;padding:14px 16px">
                        <p class="f-display"
                            style="font-size:11px;font-weight:700;color:#E11D48;margin-bottom:6px;text-transform:uppercase;letter-spacing:.08em">
                            Please fix these errors</p>
                        <ul style="list-style:none;padding:0;margin:0">
                            @foreach ($errors->all() as $error)
                                <li style="font-size:13px;color:#BE123C;font-weight:500;padding:2px 0">• {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <p class="f-display"
                    style="font-size:11px;font-weight:700;color:#ADADAD;text-transform:uppercase;letter-spacing:.12em;margin-bottom:14px">
                    Personal Info</p>
                <div style="margin-bottom:12px;position:relative">
                    <div style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#BDBDBD">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                        </svg>
                    </div>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required placeholder="Full Name"
                        style="width:100%;padding:14px 16px 14px 44px;background:#F5F5F3;border:1.5px solid transparent;border-radius:16px;font-size:14px;font-weight:500;color:#0A0A0A;outline:none;transition:all .2s ease"
                        onfocus="this.style.border='1.5px solid #86D657';this.style.background='#fff'"
                        onblur="this.style.border='1.5px solid transparent';this.style.background='#F5F5F3'">
                </div>

                <div style="margin-bottom:20px;position:relative">
                    <div
                        style="position:absolute;left:16px;top:50%;transform:translateY(-50%);font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:#BDBDBD">
                        +91</div>
                    <input type="tel" name="mobile_number" value="{{ old('mobile_number') }}" required
                        pattern="[0-9]{10}" placeholder="Mobile Number"
                        style="width:100%;padding:14px 16px 14px 52px;background:#F5F5F3;border:1.5px solid transparent;border-radius:16px;font-size:14px;font-weight:500;color:#0A0A0A;outline:none;transition:all .2s ease"
                        onfocus="this.style.border='1.5px solid #86D657';this.style.background='#fff'"
                        onblur="this.style.border='1.5px solid transparent';this.style.background='#F5F5F3'">
                </div>

                <div
                    style="height:1px;background:linear-gradient(to right,transparent,rgba(0,0,0,.07),transparent);margin-bottom:18px">
                </div>
                <p class="f-display"
                    style="font-size:11px;font-weight:700;color:#ADADAD;text-transform:uppercase;letter-spacing:.12em;margin-bottom:14px">
                    Emergency Contacts</p>

                <div style="margin-bottom:12px;position:relative">
                    <div style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#BDBDBD">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <input type="tel" name="friend_family_1" value="{{ old('friend_family_1') }}" pattern="[0-9]{10}"
                        placeholder="Friend / Family 1"
                        style="width:100%;padding:14px 16px 14px 44px;background:#F5F5F3;border:1.5px solid transparent;border-radius:16px;font-size:14px;font-weight:500;color:#0A0A0A;outline:none;transition:all .2s ease"
                        onfocus="this.style.border='1.5px solid #86D657';this.style.background='#fff'"
                        onblur="this.style.border='1.5px solid transparent';this.style.background='#F5F5F3'">
                </div>

                <div style="margin-bottom:20px;position:relative">
                    <div style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#BDBDBD">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <input type="tel" name="friend_family_2" value="{{ old('friend_family_2') }}" pattern="[0-9]{10}"
                        placeholder="Friend / Family 2"
                        style="width:100%;padding:14px 60px 14px 44px;background:#F5F5F3;border:1.5px solid transparent;border-radius:16px;font-size:14px;font-weight:500;color:#0A0A0A;outline:none;transition:all .2s ease"
                        onfocus="this.style.border='1.5px solid #86D657';this.style.background='#fff'"
                        onblur="this.style.border='1.5px solid transparent';this.style.background='#F5F5F3'">
                    <span class="f-display"
                        style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:9px;font-weight:700;color:#BDBDBD;text-transform:uppercase">Optional</span>
                </div>

                <div
                    style="height:1px;background:linear-gradient(to right,transparent,rgba(0,0,0,.07),transparent);margin-bottom:18px">
                </div>
                <p class="f-display"
                    style="font-size:11px;font-weight:700;color:#ADADAD;text-transform:uppercase;letter-spacing:.12em;margin-bottom:14px">
                    Address</p>
                <div style="margin-bottom:20px;position:relative">
                    <div style="position:absolute;left:16px;top:16px;color:#BDBDBD">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                    </div>
                    <textarea name="full_address" rows="3" placeholder="Full Address"
                        style="width:100%;padding:14px 16px 14px 44px;background:#F5F5F3;border:1.5px solid transparent;border-radius:16px;font-size:14px;font-weight:500;color:#0A0A0A;outline:none;transition:all .2s ease;resize:none"
                        onfocus="this.style.border='1.5px solid #86D657';this.style.background='#fff'"
                        onblur="this.style.border='1.5px solid transparent';this.style.background='#F5F5F3'">{{ old('full_address') }}</textarea>
                </div>

                @php
                    $categoryName = strtolower($qrCode->category->name);
                    $categoryTag = 'bag_tags';
                    if (str_contains($categoryName, 'car')) {
                        $categoryTag = 'car';
                    } elseif (str_contains($categoryName, 'bike') || str_contains($categoryName, 'motorcycle')) {
                        $categoryTag = 'bike';
                    } elseif (str_contains($categoryName, 'pet')) {
                        $categoryTag = 'pet';
                    } elseif (str_contains($categoryName, 'child')) {
                        $categoryTag = 'children';
                    } elseif (str_contains($categoryName, 'bag')) {
                        $categoryTag = 'bag_tags';
                    }
                @endphp

                <div
                    style="height:1px;background:linear-gradient(to right,transparent,rgba(0,0,0,.07),transparent);margin-bottom:18px">
                </div>
                <p class="f-display"
                    style="font-size:11px;font-weight:700;color:#ADADAD;text-transform:uppercase;letter-spacing:.12em;margin-bottom:14px">
                    Category <span style="color:#86D657">· Auto-selected</span></p>

                {{-- pointer-events-none on this div locks all interactions with categories --}}
                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:28px; pointer-events: none;">
                    @php
                        $tags = [
                            ['v' => 'car', 'l' => 'Car', 'e' => '🚗'],
                            ['v' => 'bike', 'l' => 'Bike', 'e' => '🏍️'],
                            ['v' => 'pet', 'l' => 'Pet', 'e' => '🐾'],
                            ['v' => 'children', 'l' => 'Children', 'e' => '👦'],
                            ['v' => 'bag_tags', 'l' => 'Bag Tags', 'e' => '🎒'],
                        ];
                    @endphp
                    @foreach ($tags as $t)
                        @php $isActive = $categoryTag === $t['v']; @endphp
                        <label
                            style="display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:18px;border:1.5px solid;transition:all .2s ease;
                            {{ $isActive ? 'background:#0A0A0A;border-color:#0A0A0A;' : 'background:#F5F5F3;border-color:transparent;opacity:.45;' }}">

                            <input type="checkbox" name="selected_tags[]" value="{{ $t['v'] }}"
                                {{ $isActive ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#86D657;">

                            <span class="f-display"
                                style="flex:1;font-size:14px;font-weight:700;{{ $isActive ? 'color:#fff' : 'color:#6B7280' }}">{{ $t['l'] }}</span>
                            <span style="font-size:22px">{{ $t['e'] }}</span>
                            @if ($isActive)
                                <span class="f-display"
                                    style="background:#86D657;color:#fff;font-size:9px;font-weight:800;padding:4px 10px;border-radius:100px;text-transform:uppercase">Selected</span>
                            @endif
                        </label>
                    @endforeach
                </div>

                <button type="submit"
                    style="width:100%;padding:17px;background:#0A0A0A;color:#fff;border:none;border-radius:20px;font-family:'Syne',sans-serif;font-size:15px;font-weight:800;cursor:pointer;box-shadow:0 12px 25px -5px rgba(0,0,0,0.2);transition:all .25s ease; border-bottom: 4px solid #86D657;"
                    onmousedown="this.style.transform='scale(.97)'" onmouseup="this.style.transform='scale(1)'">
                    Register →
                </button>
            </form>
        </div>

        <div style="display:flex;align-items:center;gap:14px;justify-content:center;padding:8px 0 4px">
            <div style="height:1px;flex:1;background:linear-gradient(to right,transparent,rgba(0,0,0,.09))"></div>
            <p class="f-display" style="font-size:11px;font-weight:800;letter-spacing:.04em;color:#ADADAD">Qwick<span
                    style="color:#86D657">Reach</span></p>
            <div style="height:1px;flex:1;background:linear-gradient(to left,transparent,rgba(0,0,0,.09))"></div>
        </div>
    </div>
@endsection
