@extends('layouts.app')

@section('seo_title', 'Contact - GameCodesHub')
@section('seo_description', 'Contact GameCodesHub.')
@section('seo_keywords', 'Contact,GameCodesHub')
@section('seo_canonical', url('/contact'))

@section('structured_data')
    @verbatim
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "ContactPage",
          "name": "Contact GameCodesHub",
          "description": "Have a question, suggestion, or business inquiry? Contact GameCodesHub.",
          "url": "{{ url('/contact') }}",
          "publisher": {
            "@type": "Organization",
            "name": "GameCodesHub",
            "url": "https://amecodeshub.com/"
          },
          "mainEntity": {
            "@type": "Organization",
            "name": "GameCodesHub",
            "url": "https://gamecodeshub.com/",
            "contactPoint": {
              "@type": "ContactPoint",
              "contactType": "customer service",
              "email": "support@gamecodeshub.com"
            }
          }
        }
        </script>
    @endverbatim
@endsection

@section('content')
<div class="max-w-3xl w-full mx-auto px-4 py-8">
    <!-- Hero Section -->
    <section class="text-center mb-10">
        <div class="inline-block bg-gray-900 rounded-full p-4 mb-4 shadow">
            <span class="text-4xl text-yellow-400">✉️</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-200 mb-3">Contact Us</h1>
        <p class="text-base text-gray-400 max-w-lg mx-auto">
            Have a question, suggestion, or business inquiry? Fill out the form below or email us at
            <a href="mailto:support@gamecodeshub.com" class="text-yellow-400 underline hover:text-yellow-300">support@gamecodeshub.com</a>
        </p>
    </section>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-900 border border-green-700 text-green-200 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Contact Form Section -->
    <section class="">
        <div class="bg-gray-900 rounded-2xl shadow-lg p-6 md:p-10 border border-gray-700">
            <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-gray-200 font-semibold mb-2">Your Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 rounded border border-gray-700 bg-gray-800 text-gray-100 focus:border-yellow-400 focus:bg-gray-900 focus:outline-none transition @error('name') border-red-500 @enderror" required />
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-200 font-semibold mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 rounded border border-gray-700 bg-gray-800 text-gray-100 focus:border-yellow-400 focus:bg-gray-900 focus:outline-none transition @error('email') border-red-500 @enderror" required />
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-200 font-semibold mb-2">Subject *</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="w-full px-4 py-2 rounded border border-gray-700 bg-gray-800 text-gray-100 focus:border-yellow-400 focus:bg-gray-900 focus:outline-none transition @error('subject') border-red-500 @enderror" required />
                    @error('subject')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-200 font-semibold mb-2">Message *</label>
                    <textarea name="message" rows="5" class="w-full px-4 py-2 rounded border border-gray-700 bg-gray-800 text-gray-100 focus:border-yellow-400 focus:bg-gray-900 focus:outline-none transition @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-yellow-400 text-gray-900 px-6 py-2 rounded font-semibold hover:bg-yellow-500 transition">
                    Send Message
                </button>
            </form>
        </div>
    </section>
</div>
@endsection
