@extends('layouts.app')

@section('seo_title', 'Privacy Policy - GameCodesHub')
@section('seo_description', 'Read the privacy policy for GameCodes Hub. Learn how we protect your data and privacy.')
@section('seo_keywords', 'privacy policy, data protection, GameCodesHub, user privacy')
{{--@section('seo_openGraph', 'Privacy Policy | GameCodes Hub')--}}
{{--@section('seo_openGraph_description', 'Read the privacy policy for GameCodes Hub. Learn how we protect your data and privacy.')--}}
{{--@section('seo_openGraph_image', '/og/gag.jpeg')--}}
@section('seo_canonical', url('/privacy-policy'))

@section('structured_data')
    @verbatim
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebPage",
          "name": "Privacy Policy",
          "description": "Read the privacy policy for GameCodes Hub. Learn how we protect your data and privacy.",
          "url": "{{ url('/privacy-policy') }}",
          "publisher": {
            "@type": "Organization",
            "name": "GameCodesHub",
            "url": "https://gamecodeshub.com/"
          },
          "dateModified": "{{ date('Y-m-d\TH:i:s\Z') }}",
          "mainEntity": {
            "@type": "WebPage",
            "name": "Privacy Policy",
            "description": "Privacy policy for GameCodesHub website"
          }
        }
        </script>
    @endverbatim
@endsection

@section('content')
<div class="max-w-3xl w-full mx-auto px-4 py-12">
    <!-- Hero Section -->
    <section class="text-center mb-12">
        <div class="inline-block bg-gray-100 rounded-full p-4 mb-4 shadow">
            <span class="text-4xl text-gray-600">🔒</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-3">Privacy Policy</h1>
        <p class="text-lg text-gray-600 max-w-xl mx-auto">
            Last updated: {{ date('F d, Y') }}
        </p>
    </section>

    <!-- Policy Content -->
    <section>
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-10 border border-gray-200">
            <div class="space-y-10">
                <!-- 1. Introduction -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">1. Introduction</h2>
                    <p class="text-gray-700 leading-relaxed">
                        At GameCodesHub, we respect your privacy and are committed to protecting your personal data.
                        This privacy policy explains how we collect, use, and safeguard your information when you visit our website.
                    </p>
                </div>
                <!-- 2. Information We Collect -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">2. Information We Collect</h2>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        We may collect the following types of information:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li><b>Personal Information:</b> Email address, name, and any information you provide in communications with us.</li>
                        <li><b>Usage Information:</b> IP address, browser type, pages visited, time spent, referring website, device info, etc.</li>
                    </ul>
                </div>
                <!-- 3. How We Use Your Information -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">3. How We Use Your Information</h2>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li>To provide and maintain our service</li>
                        <li>To send you updates about new game codes and features</li>
                        <li>To respond to your inquiries and provide customer support</li>
                        <li>To analyze website usage and improve our platform</li>
                        <li>To detect and prevent fraud or abuse</li>
                        <li>To comply with legal obligations</li>
                    </ul>
                </div>
                <!-- 4. Information Sharing and Disclosure -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">4. Information Sharing and Disclosure</h2>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        We do not sell, trade, or otherwise transfer your personal information to third parties, except in the following circumstances:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li>With your explicit consent</li>
                        <li>To comply with legal requirements or court orders</li>
                        <li>To protect our rights, property, or safety</li>
                        <li>With trusted service providers who assist us in operating our website (under strict confidentiality agreements)</li>
                    </ul>
                </div>
                <!-- 5. Cookies and Tracking Technologies -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">5. Cookies and Tracking Technologies</h2>
                    <p class="text-gray-700 leading-relaxed mb-3">
                        We use cookies and similar tracking technologies to enhance your experience on our website:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li><b>Essential Cookies:</b> Required for the website to function properly. These cannot be disabled.</li>
                        <li><b>Analytics Cookies:</b> Help us understand how visitors interact with our website to improve user experience.</li>
                        <li><b>Preference Cookies:</b> Remember your settings and preferences for a better browsing experience.</li>
                    </ul>
                </div>
                <!-- 6. Data Security -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">6. Data Security</h2>
                    <p class="text-gray-700 leading-relaxed">
                        We implement appropriate security measures to protect your personal information against unauthorized access,
                        alteration, disclosure, or destruction. However, no method of transmission over the internet is 100% secure,
                        and we cannot guarantee absolute security.
                    </p>
                </div>
                <!-- 7. Your Rights -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">7. Your Rights</h2>
                    <ul class="list-disc list-inside text-gray-600 space-y-1 ml-4">
                        <li><b>Access:</b> Request a copy of the personal data we hold about you</li>
                        <li><b>Correction:</b> Request correction of inaccurate or incomplete data</li>
                        <li><b>Deletion:</b> Request deletion of your personal data</li>
                        <li><b>Portability:</b> Request transfer of your data to another service</li>
                        <li><b>Objection:</b> Object to processing of your personal data</li>
                        <li><b>Withdrawal:</b> Withdraw consent for data processing</li>
                    </ul>
                </div>
                <!-- 8. Children's Privacy -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">8. Children's Privacy</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Our service is not intended for children under 13 years of age. We do not knowingly collect personal information
                        from children under 13. If you are a parent or guardian and believe your child has provided us with personal information,
                        please contact us immediately.
                    </p>
                </div>
                <!-- 9. Third-Party Links -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">9. Third-Party Links</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Our website may contain links to third-party websites. We are not responsible for the privacy practices or content
                        of these external sites. We encourage you to review their privacy policies before providing any personal information.
                    </p>
                </div>
                <!-- 10. Changes to This Privacy Policy -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">10. Changes to This Privacy Policy</h2>
                    <p class="text-gray-700 leading-relaxed">
                        We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy
                        on this page and updating the "Last updated" date. We encourage you to review this policy periodically.
                    </p>
                </div>
                <!-- 11. Contact Us -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">11. Contact Us</h2>
                    <p class="text-gray-700 leading-relaxed">
                        If you have any questions about this Privacy Policy or our data practices, please contact us at:
                        <a href="mailto:support@gamecodeshub.com" class="text-gray-800 underline hover:text-gray-600">
                            support@gamecodeshub.com
                        </a>
                    </p>
                </div>
                <!-- Acknowledgment -->
                <div class="bg-gray-50 rounded-lg p-6 mt-8">
                    <p class="text-gray-700 text-center font-medium">
                        By using GameCodesHub, you acknowledge that you have read and understood this Privacy Policy.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
