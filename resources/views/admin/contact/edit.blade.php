@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll custom-scroll"
            style="background: var(--bg); padding: 15px !important; height: 100vh; overflow-y: auto; overflow-x: hidden;">

            <div class="header-card"
                style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h1 class="title"
                        style="margin: 0; font-size: 20px; font-weight: 800; color: var(--text); font-family: 'Syne', sans-serif;">
                        Manage Contact Page</h1>
                    <p
                        style="margin: 2px 0 0 0; color: var(--text3); font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        Contact Details & Social Links</p>
                </div>
            </div>

            @if (session('success'))
                <div
                    style="background: #22c55e; color: white; padding: 10px; border-radius: 10px; margin-bottom: 20px; font-size: 11px; font-weight: 800;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.contact.update') }}" method="POST">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 20px; padding-bottom: 150px;">

                    {{-- Section 1: Contact Info --}}
                    <div class="card"
                        style="background: var(--card2); border-radius: 15px; border: 1px solid var(--border); padding: 15px;">
                        <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                            <span
                                style="font-size: 11px; font-weight: 900; color: var(--brand-purple); text-transform: uppercase;">
                                Section 1: Contact Information
                            </span>
                        </div>
                        <div style="display: grid; gap: 12px;">

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">📧
                                    Email Address</label>
                                <input type="email" name="email" value="{{ $contact->email }}"
                                    placeholder="support@example.com"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">📞
                                    Contact Number</label>
                                <input type="text" name="phone" value="{{ $contact->phone }}"
                                    placeholder="+91 98765 43210"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">💬
                                    WhatsApp Number</label>
                                <input type="text" name="whatsapp" value="{{ $contact->whatsapp }}"
                                    placeholder="+91 98765 43210"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">📍
                                    Address</label>
                                <input type="text" name="address" value="{{ $contact->address }}"
                                    placeholder="123 Main Street, City, Country"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">🕐
                                    Support Hours</label>
                                <input type="text" name="support_hours" value="{{ $contact->support_hours }}"
                                    placeholder="Mon–Sat, 10am – 7pm"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                        </div>
                    </div>

                    {{-- Section 2: Social Links --}}
                    <div class="card"
                        style="background: var(--card2); border-radius: 15px; border: 1px solid var(--border); padding: 15px;">
                        <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                            <span style="font-size: 11px; font-weight: 900; color: #22c55e; text-transform: uppercase;">
                                Section 2: Social Media Links
                            </span>
                        </div>
                        <div style="display: grid; gap: 12px;">

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">📸
                                    Instagram URL</label>
                                <input type="url" name="instagram" value="{{ $contact->instagram }}"
                                    placeholder="https://instagram.com/yourpage"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">📘
                                    Facebook URL</label>
                                <input type="url" name="facebook" value="{{ $contact->facebook }}"
                                    placeholder="https://facebook.com/yourpage"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">🐦
                                    Twitter / X URL</label>
                                <input type="url" name="twitter" value="{{ $contact->twitter }}"
                                    placeholder="https://twitter.com/yourpage"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">▶️
                                    YouTube URL</label>
                                <input type="url" name="youtube" value="{{ $contact->youtube }}"
                                    placeholder="https://youtube.com/@yourchannel"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">💼
                                    LinkedIn URL</label>
                                <input type="url" name="linkedin" value="{{ $contact->linkedin }}"
                                    placeholder="https://linkedin.com/company/yourcompany"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                            <div>
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 4px;">🌐
                                    Website URL</label>
                                <input type="url" name="website" value="{{ $contact->website }}"
                                    placeholder="https://yourwebsite.com"
                                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                            </div>

                        </div>
                    </div>

                    {{-- Save Button --}}
                    <div class="mobile-button-wrapper"
                        style="position: fixed; bottom: 20px; left: 0; right: 0; padding: 0 15px; z-index: 1000; pointer-events: none;">
                        <button type="submit"
                            style="pointer-events: auto; width: 100%; max-width: 400px; margin: 0 auto; background: var(--text); color: var(--bg); padding: 16px; border-radius: 15px; font-weight: 900; border: none; cursor: pointer; text-transform: uppercase; box-shadow: 0 10px 25px rgba(0,0,0,0.4); display: block; font-size: 12px; letter-spacing: 1px;">
                            Save Changes
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <style>
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }
    </style>
@endsection
