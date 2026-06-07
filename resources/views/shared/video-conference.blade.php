<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meeting->judul }} - LPK Seishin Video Conference</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://meet.jit.si/external_api.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            background-color: #000;
        }
        #jitsi-container {
            width: 100%;
            height: calc(100vh - 64px);
        }
        .conference-header {
            height: 64px;
            background-color: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            color: white;
            border-bottom: 1px solid #333;
        }
        .header-title {
            font-family: 'IBM Plex Sans', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .status-badge {
            background-color: #dc2626;
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: pulse 2s infinite;
        }
        .back-btn {
            background-color: #333;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .back-btn:hover {
            background-color: #444;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="conference-header">
        <div class="header-title">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            {{ $meeting->judul }}
            <span class="status-badge">Live</span>
        </div>
        <div>
            @if(Auth::user()->role_id == 3)
                <a href="{{ route('teacher.meetings.index') }}" class="back-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Keluar Kelas
                </a>
            @else
                <a href="{{ route('students.meetings.index') }}" class="back-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Keluar Kelas
                </a>
            @endif
        </div>
    </div>
    
    <div id="jitsi-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Extract the room name from the generated link (e.g., https://meet.jit.si/LPKSeishin-12345)
            const meetLink = "{{ $meeting->meet_link }}";
            const roomName = meetLink.split('/').pop();
            const userName = "{{ Auth::user()->name }}";
            const isTeacher = {{ Auth::user()->role_id == 3 ? 'true' : 'false' }};

            const domain = 'meet.jit.si';
            const options = {
                roomName: roomName,
                width: '100%',
                height: '100%',
                parentNode: document.querySelector('#jitsi-container'),
                userInfo: {
                    displayName: (isTeacher ? 'Sensei ' : '') + userName
                },
                configOverwrite: {
                    prejoinPageEnabled: false,
                    startWithAudioMuted: !isTeacher,
                    startWithVideoMuted: !isTeacher,
                },
                interfaceConfigOverwrite: {
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_WATERMARK_FOR_GUESTS: false,
                    TOOLBAR_BUTTONS: [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                        'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                        'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                        'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone',
                        'security'
                    ],
                }
            };
            
            const api = new JitsiMeetExternalAPI(domain, options);
            
            // Auto update status to ongoing if teacher joins
            if (isTeacher) {
                api.addEventListener('videoConferenceJoined', () => {
                    console.log('Teacher joined the conference');
                    // In a real scenario, you could send an ajax request here to update status to 'ongoing'
                });
            }
        });
    </script>
</body>
</html>
