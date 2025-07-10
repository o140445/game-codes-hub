@extends('layouts.app')

@section('seo_title', 'Terms of Service - GameCodesHub')
@section('seo_description', 'Read the terms of service for using GameCodes Hub. Learn about your rights and responsibilities when using our platform.')
@section('seo_keywords', '')

{{--@section('seo_openGraph', 'Terms of Service | GameCodes Hub')--}}
{{--@section('seo_openGraph_description', 'Read the terms of service for GameCodes Hub. Learn about your rights and responsibilities when using our platform.')--}}
{{--@section('seo_openGraph_image', '/og/gag.jpeg')--}}
@section('seo_canonical', url('/terms-of-service'))

@section('structured_data')
<script type="application/ld+json">
    @verbatim
        {
          "@context": "https://schema.org",
          "@type": "WebPage",
          "name": "Terms of Service",
          "description": "Read the terms of service for using GameCodes Hub. Learn about your rights and responsibilities when using our platform.",
          "url": "{{ url('/terms-of-service') }}",
          "publisher": {
            "@type": "Organization",
            "name": "GameCodesHub",
            "url": "https://gamecodeshub.com/"
          },
          "dateModified": "{{ date('Y-m-d\TH:i:s\Z') }}",
          "mainEntity": {
            "@type": "WebPage",
            "name": "Terms of Service",
            "description": "Terms of service for GameCodesHub website"
          }
        }
    @endverbatim
</script>
@endsection

@section('content')
<div class="max-w-3xl w-full mx-auto px-4 py-12">
    <!-- Hero Section -->
    <section class="text-center mb-12">
        <div class="inline-block bg-gray-900 rounded-full p-4 mb-4 shadow">
            <span class="text-4xl text-yellow-400">📜</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-200 mb-3">Terms of Service</h1>
        <p class="text-lg text-gray-400 max-w-xl mx-auto">
            Last updated: {{ date('F d, Y') }}
        </p>
    </section>
    <!-- Terms Content -->
    <section>
        <div class="bg-gray-900 rounded-2xl shadow-lg p-6 md:p-10 border border-gray-700">
            <div class="space-y-10">
                <!-- 1. Acceptance of Terms -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">1. Acceptance of Terms</h2>
                    <p class="text-gray-200 leading-relaxed">
                        By accessing and using GameCodesHub ("the Service"), you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.
                    </p>
                </div>
                <!-- 2. Description of Service -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">2. Description of Service</h2>
                    <p class="text-gray-200 leading-relaxed mb-3">
                        GameCodesHub provides a platform for sharing and discovering game codes, rewards, and gaming-related content. Our service includes:
                    </p>
                    <ul class="list-disc list-inside text-gray-400 space-y-1 ml-4">
                        <li>Game code listings and updates</li>
                        <li>Gaming articles and guides</li>
                        <li>Community features and discussions</li>
                        <li>Email notifications and updates</li>
                    </ul>
                </div>
                <!-- 3. User Responsibilities -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">3. User Responsibilities</h2>
                    <p class="text-gray-200 leading-relaxed mb-3">
                        As a user of our service, you agree to:
                    </p>
                    <ul class="list-disc list-inside text-gray-400 space-y-1 ml-4">
                        <li>Provide accurate and truthful information</li>
                        <li>Respect the intellectual property rights of others</li>
                        <li>Not engage in any illegal or harmful activities</li>
                        <li>Not attempt to gain unauthorized access to our systems</li>
                        <li>Not use the service for spam or malicious purposes</li>
                        <li>Report any bugs or security issues you discover</li>
                    </ul>
                </div>
                <!-- 4. Intellectual Property Rights -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">4. Intellectual Property Rights</h2>
                    <p class="text-gray-200 leading-relaxed mb-3">
                        The Service and its original content, features, and functionality are and will remain the exclusive property of GameCodesHub and its licensors. The Service is protected by copyright, trademark, and other laws.
                    </p>
                    <p class="text-gray-200 leading-relaxed">
                        Game codes and related content are provided for informational purposes only. We do not claim ownership of game codes, which belong to their respective game developers and publishers.
                    </p>
                </div>
                <!-- 5. Privacy and Data Protection -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">5. Privacy and Data Protection</h2>
                    <p class="text-gray-200 leading-relaxed">
                        Your privacy is important to us. Please review our Privacy Policy, which also governs your use of the Service, to understand our practices regarding the collection and use of your information.
                    </p>
                </div>
                <!-- 6. Disclaimers -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">6. Disclaimers</h2>
                    <p class="text-gray-200 leading-relaxed mb-3">
                        The information on this website is provided on an "as is" basis. To the fullest extent permitted by law, GameCodesHub excludes all representations, warranties, conditions and terms whether express or implied.
                    </p>
                    <p class="text-gray-200 leading-relaxed">
                        We do not guarantee that game codes will always work or be available. Codes may expire or become invalid at any time without notice.
                    </p>
                </div>
                <!-- 7. Limitation of Liability -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">7. Limitation of Liability</h2>
                    <p class="text-gray-200 leading-relaxed">
                        In no event shall GameCodesHub, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential, or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your use of the Service.
                    </p>
                </div>
                <!-- 8. Termination -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">8. Termination</h2>
                    <p class="text-gray-200 leading-relaxed">
                        We may terminate or suspend your access immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms. Upon termination, your right to use the Service will cease immediately.
                    </p>
                </div>
                <!-- 9. Changes to Terms -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">9. Changes to Terms</h2>
                    <p class="text-gray-200 leading-relaxed">
                        We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.
                    </p>
                </div>
                <!-- 10. Governing Law -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">10. Governing Law</h2>
                    <p class="text-gray-200 leading-relaxed">
                        These Terms shall be interpreted and governed by the laws of the jurisdiction in which GameCodesHub operates, without regard to its conflict of law provisions.
                    </p>
                </div>
                <!-- 11. Contact Information -->
                <div>
                    <h2 class="text-2xl font-bold text-yellow-400 mb-3">11. Contact Information</h2>
                    <p class="text-gray-200 leading-relaxed">
                        If you have any questions about these Terms of Service, please contact us at:
                        <a href="mailto:support@gamecodeshub.com" class="text-yellow-400 underline hover:text-yellow-300">
                            support@gamecodeshub.com
                        </a>
                    </p>
                </div>
                <!-- Acknowledgment -->
                <div class="bg-gray-800 rounded-lg p-6 mt-8">
                    <p class="text-gray-300 text-center font-medium">
                        By using GameCodesHub, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
