@extends('layout.app')

@section('content')
<div class="main-area">
    <div class="page-scroll" style="background: var(--bg); padding: 20px !important;">
        
        {{-- Header Section --}}
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
            <a href="{{ route('admin.coupons.index') }}" class="btn-outline"
                style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: var(--card); border: 1px solid var(--border); color: var(--text);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="title" style="margin: 0; font-size: 20px; letter-spacing: -0.5px;">Create Coupon Code</h1>
                <p style="margin: 0; color: var(--text3); font-size: 11px;">Assign a new coupon code to a user.</p>
            </div>
        </div>

        @if ($errors->any())
            <div style="margin-bottom: 20px; background: var(--red-bg); border: 1px solid var(--red); color: var(--red); padding: 15px 20px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card" style="padding: 25px; border: 1px solid var(--border); display: flex; flex-direction: column; max-width: 1200px; background: var(--card); border-radius: var(--radius);">
            <form action="{{ route('admin.coupons.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    <!-- User Selection -->
                    <div>
                        <label for="user_id" style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 6px;">Select User <span style="color: var(--red);">*</span></label>
                        <select id="user_id" name="user_id" required style="width: 100%; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 12px 15px; outline: none; font-size: 13px;">
                            <option value="">-- Select a User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" data-name="{{ $user->name }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Coupon Code -->
                    <div>
                        <label for="code" style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 6px;">Coupon Code <span style="color: var(--red);">*</span></label>
                        <div style="display: flex;">
                            <input type="text" name="code" id="code" value="{{ old('code') }}" required style="flex: 1; background: var(--card2); border: 1px solid var(--border); color: var(--blue); border-right: none; border-radius: 10px 0 0 10px; padding: 12px 15px; outline: none; font-size: 13px; font-weight: 800; letter-spacing: 1px;" placeholder="e.g. USER2023X">
                            <button type="button" id="generate_code" style="padding: 0 15px; background: var(--text); color: var(--bg); border: none; border-radius: 0 10px 10px 0; font-size: 11px; font-weight: 800; text-transform: uppercase; cursor: pointer;">
                                Generate
                            </button>
                        </div>
                    </div>

                    <!-- Discount Type -->
                    <div>
                        <label for="discount_type" style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 6px;">Discount Type <span style="color: var(--red);">*</span></label>
                        <select id="discount_type" name="discount_type" style="width: 100%; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 12px 15px; outline: none; font-size: 13px;">
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                            <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        </select>
                    </div>

                    <!-- Discount Amount -->
                    <div>
                        <label for="discount_amount" style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 6px;">Discount Value <span style="color: var(--red);">*</span></label>
                        <input type="number" name="discount_amount" id="discount_amount" step="0.01" min="0" value="{{ old('discount_amount') }}" required style="width: 100%; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 12px 15px; outline: none; font-size: 13px;" placeholder="Enter amount or percentage">
                    </div>

                    <!-- Expires At -->
                    <div>
                        <label for="expires_at" style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 6px;">Expires On</label>
                        <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}" style="width: 100%; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 12px 15px; outline: none; font-size: 13px;">
                        <p style="margin: 4px 0 0 0; color: var(--text3); font-size: 10px;">Leave blank for lifetime validity.</p>
                    </div>

                    <!-- Status -->
                    <div style="display: flex; align-items: center; margin-top: 25px;">
                        <label class="toggle-pill {{ old('is_active', true) ? 'on' : '' }}" id="status_toggle">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="display: none;">
                            <div class="knob"></div>
                        </label>
                        <span style="margin-left: 10px; font-size: 13px; font-weight: 700; color: var(--text);">Active Profile</span>
                    </div>
                </div>

                <div style="padding-top: 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                    <a href="{{ route('admin.coupons.index') }}" style="padding: 10px 20px; font-size: 12px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; border-radius: 10px; background: var(--card2); color: var(--text); text-decoration: none; border: 1px solid var(--border);">
                        Cancel
                    </a>
                    <button type="submit" style="padding: 10px 20px; font-size: 12px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; border-radius: 10px; background: var(--blue); color: #fff; border: none; cursor: pointer;">
                        Save Coupon
                    </button>
                </div>
            </form>
        </div>
        <div style="height: 40px;"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate Code Logic
    const generateBtn = document.getElementById('generate_code');
    const userSelect = document.getElementById('user_id');
    const codeInput = document.getElementById('code');

    generateBtn.addEventListener('click', function() {
        const selectedOption = userSelect.options[userSelect.selectedIndex];
        
        if (!selectedOption.value) {
            alert('Please select a user first!');
            return;
        }

        const fullName = selectedOption.getAttribute('data-name');
        
        // Split name into words, take first letter of each or use whole first name if single word
        let prefix = '';
        const nameParts = fullName.trim().split(/\s+/);
        
        if (nameParts.length > 1) {
            // Take first letter of first name and whole last name
            prefix = nameParts[0][0] + nameParts[nameParts.length - 1];
        } else {
            // Take first 4 characters of name
            prefix = nameParts[0].substring(0, 4);
        }
        
        // Format: CLEAN PREFIX + RANDOM ALPHANUMERIC
        prefix = prefix.replace(/[^a-zA-Z]/g, '').toUpperCase();
        
        // Generate random 4 character alphanumeric string
        const randomString = Math.random().toString(36).substring(2, 6).toUpperCase();
        
        codeInput.value = `${prefix}${randomString}`;
    });

    // Custom Toggle Switch Logic
    const togglePill = document.getElementById('status_toggle');
    const toggleInput = document.getElementById('is_active');
    
    togglePill.addEventListener('click', function() {
        if(toggleInput.checked) {
            toggleInput.checked = false;
            togglePill.classList.remove('on');
        } else {
            toggleInput.checked = true;
            togglePill.classList.add('on');
        }
    });
});
</script>
@endsection
