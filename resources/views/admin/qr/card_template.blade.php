<!DOCTYPE html>
<html>

<head>
    <title>Download QR Card</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #eef0f8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
        }

        /* ===== CARD ===== */
        .qr-card {
            width: 420px;
            min-height: 620px;
            border-radius: 36px;
            position: relative;
            overflow: hidden;
            padding: 36px 32px 32px;
            box-shadow: 0 24px 60px rgba(100, 80, 200, 0.18);
            background: linear-gradient(145deg, #f0f0ff 0%, #e8e4ff 40%, #f5f0ff 70%, #ffffff 100%);
            text-align: center;
        }

        /* ===== GLOWING BLOBS ===== */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(45px);
            opacity: 0.55;
            pointer-events: none;
        }

        .blob-blue {
            width: 180px;
            height: 180px;
            background: radial-gradient(circle, #7b9fff, #4f6ef7);
            top: 55%;
            left: -50px;
        }

        .blob-purple {
            width: 160px;
            height: 160px;
            background: radial-gradient(circle, #c084fc, #9333ea);
            top: 50%;
            right: -40px;
        }

        .blob-pink {
            width: 130px;
            height: 130px;
            background: radial-gradient(circle, #f9a8d4, #ec4899);
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0.3;
        }

        /* ===== BRAND ===== */
        .brand {
            font-size: 40px;
            font-weight: 900;
            color: #1a1a2e;
            letter-spacing: -1px;
            position: relative;
            z-index: 2;
            margin-bottom: 4px;
        }

        .brand .reach {
            color: #7c3aed;
        }

        .tagline {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 4px;
            color: #8888aa;
            margin-bottom: 28px;
            position: relative;
            z-index: 2;
        }

        /* ===== QR WRAPPER ===== */
        .qr-outer {
            position: relative;
            display: inline-block;
            z-index: 2;
            margin-bottom: 24px;
        }

        /* Glowing border ring */
        .qr-glow-ring {
            position: absolute;
            inset: -8px;
            border-radius: 30px;
            background: linear-gradient(135deg, #60a5fa, #818cf8, #a855f7, #ec4899);
            opacity: 0.8;
            filter: blur(8px);
            z-index: -1;
        }

        .qr-wrapper {
            background: #ffffff;
            padding: 18px;
            border-radius: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border: 2px solid rgba(139, 92, 246, 0.25);
        }

        .qr-wrapper img {
            width: 230px;
            height: 230px;
            display: block;
        }

        /* Corner accent bracket bottom-right */
        .qr-corner {
            position: absolute;
            bottom: -12px;
            right: -12px;
            width: 28px;
            height: 28px;
            border-right: 3px solid #7c3aed;
            border-bottom: 3px solid #7c3aed;
            border-radius: 0 0 6px 0;
        }

        /* ===== SCAN TO BUTTON ===== */
        .scan-btn {
            position: relative;
            z-index: 2;
            display: block;
            margin: 0 auto 24px;
            width: 100%;
            background: linear-gradient(90deg, #2d1b6e 0%, #4c1d95 40%, #7c2d9e 75%, #9333ea 100%);
            border-radius: 50px;
            padding: 14px 24px 16px;
            border: none;
            color: white;
            cursor: default;
        }

        .scan-btn .scan-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 4px;
            color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 2px;
        }

        .scan-btn .scan-label::before,
        .scan-btn .scan-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.3);
        }

        .scan-btn .contact-text {
            font-size: 26px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 1px;
        }

        /* ===== FEATURES ===== */
        .features {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding-top: 8px;
            border-top: 1px solid rgba(120, 100, 200, 0.15);
        }

        .feature-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 700;
            color: #666688;
        }

        .feature-item svg {
            width: 22px;
            height: 22px;
            color: #7c3aed;
        }

        .feature-divider {
            width: 1px;
            height: 36px;
            background: rgba(120, 100, 200, 0.2);
        }

        /* ===== DOWNLOAD BUTTON ===== */
        .btn-download {
            margin-top: 32px;
            background: linear-gradient(45deg, #6366f1, #8b5cf6);
            color: #fff;
            padding: 16px 50px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 800;
            border: none;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 13px;
            font-family: 'Nunito', sans-serif;
        }

        .btn-download:hover {
            transform: scale(1.05);
        }

        .btn-download:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .print-tip {
            margin-top: 12px;
            font-size: 12px;
            color: #999;
            font-family: 'Nunito', sans-serif;
        }

        /* ===== PRINT ===== */
        @media print {
            @page {
                size: 420px 640px;
                margin: 0;
            }

            body {
                background: white;
            }

            .btn-download,
            .print-tip {
                display: none !important;
            }

            .qr-card {
                box-shadow: none !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="qr-card" id="captureCard">

        <!-- Glowing background blobs -->
        <div class="blob blob-blue"></div>
        <div class="blob blob-purple"></div>
        <div class="blob blob-pink"></div>

        <!-- Brand -->
        <div class="brand">Qwick<span class="reach">Reach</span></div>
        <div class="tagline">SCAN. CALL. CONNECT.</div>

        <!-- QR Code -->
        <div class="qr-outer">
            <div class="qr-glow-ring"></div>
            <div class="qr-wrapper">
                @if ($base64)
                    @if ($isSvg)
                        <img src="data:image/svg+xml;base64,{{ $base64 }}" alt="QR Code">
                    @else
                        <img src="{{ $base64 }}" alt="QR Code">
                    @endif
                @else
                    <p style="color:red;font-size:12px;">QR Not Found</p>
                @endif
            </div>
            <div class="qr-corner"></div>
        </div>

        <!-- Scan To Button -->
        <div class="scan-btn">
            <div class="scan-label">SCAN TO</div>
            <div class="contact-text">CONTACT OWNER</div>
        </div>

        <!-- Features -->
        <div class="features">
            <div class="feature-item">
                <!-- Phone icon -->
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span>No App<br>Needed</span>
            </div>

            <div class="feature-divider"></div>

            <div class="feature-item">
                <!-- Shield icon -->
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>100%<br>Secure</span>
            </div>

            <div class="feature-divider"></div>

            <div class="feature-item">
                <!-- Eye icon -->
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span>Private<br>& Safe</span>
            </div>
        </div>

    </div>

    <button class="btn-download" onclick="window.print()">🖨️ Print / Save as PDF</button>
    <div class="print-tip">💡 In print dialog → Destination: <strong>Save as PDF</strong></div>

</body>

</html>
