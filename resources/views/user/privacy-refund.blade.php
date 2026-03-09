@extends('user_layout.user')

@section('content')
    <div class="px-4 pt-6 pb-24 max-w-md mx-auto min-h-screen" style="background-color: #F0F0FA;">

        {{-- REFUND & CANCELLATION POLICY CARD --}}
        <div class="rounded-2xl p-6 mb-8 shadow-xl border"
            style="background-color: #ffffff; border-color: #A3A3C2; box-shadow: 0 8px 20px rgba(26, 26, 62, 0.08);">

            {{-- Title --}}
            <h1 class="font-display font-bold text-2xl mb-2" style="color: #1A1A3E; line-height: 1.2;">
                Refund & Cancellation Policy
            </h1>

            <hr style="border: 0; border-top: 1px solid #E8E8F5; margin-bottom: 20px;">

            {{-- Dynamic Content --}}
            <div class="policy-content" style="color: #4A4A6A; line-height: 1.7; font-size: 14px; font-weight: 500;">
                <p>At QwickReach, we strive to ensure customer satisfaction with every purchase.</p>

                <h2>Order Cancellation</h2>
                <p>Orders can be cancelled before they are shipped.Once the product has been shipped or activated,
                    cancellation may not be possible.</p>

                <h2>Refunds</h2>
                <p>Refund requests may be considered in case of damaged products or incorrect items delivered.Customers
                    should report such issues as soon as possible after receiving the product.</p>

                <h2>Refund Processing</h2>
                <p>Refunded amount will be credited in 5-7 working days in original payment mode.</p>

                <h2>Contact for Refund Requests</h2>
                <ul>
                    <li><strong>Business Name:</strong> Silvershark Technologies</li>
                    <li><strong>Mobile Number:</strong> 8452012408</li>
                    <li><strong>Email:</strong> qwickreach74@gmail.com</li>
                </ul>
            </div>
        </div>

        {{-- TERMS & CONDITIONS CARD --}}
        <div class="rounded-2xl p-6 mb-10 shadow-xl border"
            style="background-color: #ffffff; border-color: #A3A3C2; box-shadow: 0 8px 20px rgba(26, 26, 62, 0.08);">

            {{-- Title --}}
            <h1 class="font-display font-bold text-2xl mb-2" style="color: #1A1A3E; line-height: 1.2;">
                Terms & Conditions
            </h1>

            <hr style="border: 0; border-top: 1px solid #E8E8F5; margin-bottom: 20px;">

            {{-- Dynamic Content --}}
            <div class="policy-content" style="color: #4A4A6A; line-height: 1.7; font-size: 14px; font-weight: 500;">
                <p>Welcome to QwickReach. By accessing or using our website and services, you agree to comply with and be
                    bound by the following terms and conditions.</p>

                <h2>1. Service Description</h2>
                <p>QwickReach provides QR-based communication tags that allow individuals to securely contact the owner of
                    an asset (such as vehicles, pets, bags, or other belongings) without revealing the owner's personal
                    phone number.</p>

                <h2>2. Proper Use</h2>
                <p>Users agree to use QwickReach services only for legitimate purposes such as contacting an owner in
                    situations including wrong parking, emergencies, or when an item or pet is found. Misuse of the
                    platform, including harassment, spam calls, fraudulent activity, or any unlawful behavior, is strictly
                    prohibited.</p>

                <h2>3. Privacy Protection</h2>
                <p>QwickReach is designed to protect user privacy. Personal contact numbers are not directly shared between
                    users. Communication may occur through secure relay systems or call-masking technology.</p>

                <h2>4. User Responsibility</h2>
                <p>The owner of the QR tag is responsible for maintaining accurate contact information linked to their tag.
                    QwickReach is not responsible for failed communication caused by incorrect or outdated information.</p>

                <h2>5. Service Availability</h2>
                <p>While we aim to provide uninterrupted service, QwickReach does not guarantee continuous availability of
                    the platform or communication systems.</p>

                <h2>6. Limitation of Liability</h2>
                <p>QwickReach is a communication platform only. We do not guarantee recovery of lost items, vehicles, pets,
                    or belongings, and we are not responsible for actions taken by individuals contacting the owner.</p>

                <h2>7. Product Usage</h2>
                <p>QR tags sold by QwickReach are intended to facilitate communication between parties. Users must ensure
                    the tags are used responsibly and in accordance with local laws.</p>

                <h2>8. Changes to Terms</h2>
                <p>QwickReach reserves the right to update or modify these Terms & Conditions at any time.Continued use of
                    the service after changes indicates acceptance of the updated terms.</p>

                <h2>9. Contact</h2>
                <p>For any questions regarding these Terms & Conditions, please contact us:</p>
                <ul>
                    <li><strong>QwickReach</strong></li>
                    <li><strong>Website:</strong> www.qwickreach.in</li>
                    <li><strong>Email:</strong> qwickreach74@gmail.com</li>
                </ul>
            </div>
        </div>

        {{-- Small Branding at bottom --}}
        <div class="text-center opacity-40">
            <p class="text-[10px] font-black uppercase tracking-[0.3em]" style="color:#9B9BB4;">
                Qwick<span style="color:#5B5BDB;">Reach</span>
            </p>
        </div>
    </div>

    <style>
        /* CSS content styling to match your theme */
        .policy-content h2 {
            color: #1A1A3E;
            margin-top: 24px;
            margin-bottom: 10px;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .policy-content p {
            margin-bottom: 15px;
        }

        .policy-content ul,
        .policy-content ol {
            padding-left: 20px;
            margin-bottom: 20px;
            color: #5B5BDB;
            /* Bullet points color match */
        }

        .policy-content li {
            margin-bottom: 10px;
            color: #4A4A6A;
            /* Text color inside list */
        }

        .policy-content strong {
            color: #1A1A3E;
            font-weight: 700;
        }
    </style>
@endsection
