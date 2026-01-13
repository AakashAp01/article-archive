@extends('layout.app')
@section('title', 'Privacy Protocol')

@section('content')
<div class="bg-[#0a0a0f] min-h-screen pt-32 pb-20 relative overflow-hidden">
    
    {{-- Background Grid --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        
        {{-- Header --}}
        <div class="mb-12 border-b border-white/10 pb-8">
            <div class="flex items-center gap-3 mb-4 text-[#00ff88]">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span class=" text-xs uppercase tracking-[0.2em]">Legal Protocol // 001</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-light text-white mb-4">Privacy Policy</h1>
            <p class="text-[#666]  text-xs">LAST UPDATED: {{ date('F d, Y') }}</p>
        </div>

        {{-- Content --}}
        <div class="prose prose-invert prose-lg max-w-none text-[#a0a0a0]">
            <p>
                At <strong>AkashAp.dev</strong> ("we", "our", or "us"), we are committed to protecting your personal data and your right to privacy. This policy outlines our protocols regarding the collection, use, and disclosure of your information when you use our digital services.
            </p>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">1. Data Collection Protocols</h3>
            <p>We collect minimal data necessary to maintain system integrity and user experience:</p>
            <ul class="list-disc pl-6 space-y-2 text-sm ">
                <li><strong>Identity Data:</strong> Name, username, or similar identifiers (if you register).</li>
                <li><strong>Contact Data:</strong> Email address (for newsletters or account recovery).</li>
                <li><strong>Technical Data:</strong> IP address, browser type, time zone setting, and operating system.</li>
                <li><strong>Usage Data:</strong> Information about how you navigate the Infinite Canvas.</li>
            </ul>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">2. Usage of Information</h3>
            <p>Your data is processed for the following purposes:</p>
            <ul class="list-disc pl-6 space-y-2 text-sm ">
                <li>To operate and maintain the Service.</li>
                <li>To notify you about changes to our system architecture.</li>
                <li>To provide customer support.</li>
                <li>To gather analysis so that we can improve the Service.</li>
                <li>To monitor the usage of the Service.</li>
            </ul>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">3. Data Retention</h3>
            <p>
                We will retain your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.
            </p>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">4. Security of Data</h3>
            <p>
                The security of your data is important to us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, we cannot guarantee its absolute security.
            </p>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">5. Third-Party Services</h3>
            <p>
                We may employ third-party companies and individuals to facilitate our Service ("Service Providers"), to provide the Service on our behalf, to perform Service-related services, or to assist us in analyzing how our Service is used. These third parties have access to your Personal Data only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.
            </p>
        </div>
    </div>
</div>
@endsection