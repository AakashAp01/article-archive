<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectLine }}</title>
    <style>
        /* --- CLIENT RESETS --- */
        body { margin: 0; padding: 0; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        img { border: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }

        /* --- MARKDOWN ELEMENT STYLING --- */
        .content h1 { 
            font-size: 24px; 
            color: #ffffff !important; 
            border-bottom: 1px solid {{ $themeColor }};
            padding-bottom: 12px; 
            margin-bottom: 24px; 
            font-weight: 300; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
        }
        .content h2 { 
            font-size: 18px; 
            color: #ffffff !important; 
            margin-top: 30px; 
            margin-bottom: 15px; 
            font-weight: 600; 
            text-transform: uppercase; 
            letter-spacing: 1px;
        }
        .content p { 
            font-size: 15px; 
            line-height: 1.7; 
            color: #cccccc !important; 
            margin-bottom: 20px; 
        }
        .content strong { color: #ffffff; font-weight: 700; }
        
        /* Links styled as neon text */
        .content a { 
            color: {{ $themeColor }} !important; 
            text-decoration: none; 
            border-bottom: 1px dashed {{ $themeColor }}; 
            transition: all 0.3s ease;
        }

        /* Blockquotes looking like terminal outputs */
        .content blockquote { 
            border-left: 3px solid {{ $themeColor }}; 
            background-color: #1a1a25; 
            margin: 25px 0; 
            padding: 15px 20px; 
            color: #999999; 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 13px;
        }
        
        /* Lists */
        .content ul { padding-left: 20px; margin-bottom: 20px; }
        .content li { color: #cccccc; margin-bottom: 8px; }

        /* Mobile Responsive */
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; }
            .content { padding: 25px !important; }
        }
    </style>
</head>
<body style="background-color: #0a0a0f; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    {{-- OUTER WRAPPER --}}
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #0a0a0f;">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                
                {{-- MAIN CARD --}}
                <table border="0" cellpadding="0" cellspacing="0" width="600" class="container" style="background-color: #13131f; border: 1px solid #2a2a35; border-radius: 4px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                    
                    {{-- Neon Top Border (Dynamic) --}}
                    <tr>
                        <td height="4" style="background-color: {{ $themeColor }};"></td>
                    </tr>

                    {{-- Header Area --}}
                    <tr>
                        <td align="left" style="padding: 30px 40px; border-bottom: 1px solid #2a2a35; background-color: #13131f;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <span style="color: {{ $themeColor }}; font-size: 10px; text-transform: uppercase; letter-spacing: 3px; font-family: 'Courier New', Courier, monospace; font-weight: bold;">
                                            SYSTEM NOTIFICATION
                                        </span>
                                    </td>
                                    <td align="right">
                                        <span style="height: 8px; width: 8px; background-color: {{ $themeColor }}; display: inline-block; border-radius: 50%;"></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Dynamic Content Area --}}
                    <tr>
                        <td class="content" style="padding: 40px; background-color: #13131f; color: #cccccc;">
                            {!! $markdownContent !!}
                        </td>
                    </tr>

                   {{-- FOOTER --}}
                    <tr>
                        <td style="padding: 30px; background-color: #08080c; border-top: 1px solid {{ $themeColor }}33; text-align: center;">
                            
                            {{-- 1. Main Navigation Links --}}
                            <p style="margin: 0 0 20px 0;">
                                <a href="{{ url('/') }}" style="color: #cccccc !important; text-decoration: none; font-size: 11px; font-weight: bold; font-family: 'Segoe UI', sans-serif; text-transform: uppercase; letter-spacing: 1px;">
                                    WEBSITE
                                </a>
                                
                                
                                <span style="color: {{ $themeColor }}; margin: 0 10px; opacity: 0.5;">|</span>

                                <a href="{{ url('/privacy-policy') }}" style="color: #cccccc !important; text-decoration: none; font-size: 11px; font-weight: bold; font-family: 'Segoe UI', sans-serif; text-transform: uppercase; letter-spacing: 1px;">
                                    LEGAL
                                </a>
                            </p>

                            {{-- 2. System Tagline --}}
                            <p style="margin: 0; font-size: 10px; color: #555555; font-family: 'Courier New', Courier, monospace; text-transform: uppercase; letter-spacing: 1px;">
                                SECURE TRANSMISSION // {{ strtoupper(config('app.name')) }} <br>
                                <span style="opacity: 0.7;">&copy; {{ date('Y') }} All Rights Reserved.</span>
                            </p>

                            {{-- 3. Unsubscribe (Subtle) --}}
                            <div style="margin-top: 15px;">
                                <a href="{{ route('newsletter.unsubscribe.confirm', ['email' => urlencode(base64_encode($email))]) }}"
                                style="color:#333333 !important;font-size:9px;text-decoration:none;font-family:sans-serif;border-bottom:1px solid #333333;">
                                    UNSUBSCRIBE
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
                {{-- END MAIN CARD --}}
            </td>
        </tr>
    </table>

</body>
</html>