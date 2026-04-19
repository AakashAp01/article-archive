@extends('layout.app')
@section('title', 'Terms of Service')

@section('content')
<div class="bg-[#0a0a0f] min-h-screen pt-32 pb-20 relative overflow-hidden">
    
    {{-- Background Grid --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:40px_40px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        
        {{-- Header --}}
        <x-page-header 
            title="Terms of Service" 
            subtitle="Please read our terms and conditions carefully" 
        />

        {{-- Content --}}
        <article class="prose prose-invert prose-lg max-w-none text-[#a0a0a0]">
            <p>
                Please read these Terms of Service ("Terms", "Terms of Service") carefully before using the <strong>AkashAp.dev</strong> website (the "Service"). Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms.
            </p>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">1. Acceptance of Terms</h3>
            <p>
                By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.
            </p>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">2. Intellectual Property</h3>
            <p>
                The Service and its original content (including but not limited to the "Infinite Canvas" architecture, code snippets, visual design, and written articles), features, and functionality are and will remain the exclusive property of AkashAp and its licensors. The Service is protected by copyright, trademark, and other laws of both the India and foreign countries.
            </p>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">3. User Conduct</h3>
            <p>You agree not to engage in any of the following prohibited activities:</p>
            <ul class="list-disc pl-6 space-y-2 text-sm ">
                <li>Copying, distributing, or disclosing any part of the Service in any medium.</li>
                <li>Using any automated system, including without limitation "robots," "spiders," "offline readers," etc., to access the Service.</li>
                <li>Attempting to interfere with, compromise the system integrity or security, or decipher any transmissions to or from the servers running the Service.</li>
                <li>Taking any action that imposes, or may impose at our sole discretion an unreasonable or disproportionately large load on our infrastructure.</li>
            </ul>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">4. Links To Other Web Sites</h3>
            <p>
                Our Service may contain links to third-party web sites or services that are not owned or controlled by AkashAp. We have no control over, and assume no responsibility for, the content, privacy policies, or practices of any third party web sites or services.
            </p>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">5. Limitation of Liability</h3>
            <p>
                In no event shall AkashAp, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your access to or use of or inability to access or use the Service.
            </p>

            <h3 class="text-white mt-12 mb-4 text-xl font-light border-l-2 border-[#00ff88] pl-4">6. Governing Law</h3>
            <p>
                These Terms shall be governed and construed in accordance with the laws of India, without regard to its conflict of law provisions.
            </p>
        </div>

    </div>
</div>
@endsection