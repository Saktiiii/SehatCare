<div>
    <head>
        <meta charset="utf-8">
        <link href="{{asset('midone')}}/dist/images/logo.svg" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Midone admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="LEFT4CODE">
        <title>Dashboard - Midone - Tailwind HTML Admin Template</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{asset('midone')}}/dist/css/app.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

        <style>
            /* Bubble chat WA-like */
            .chat-bubble {
              border-radius: 1.5rem; /* bulat besar */
              max-width: 80vw;       /* lebar max 80% viewport */
              padding: 1rem 1.25rem; /* padding nyaman */
              box-shadow: 0 2px 8px rgba(0,0,0,0.1);
              transition: box-shadow 0.3s ease;
              word-wrap: break-word;
              overflow-wrap: break-word;
            }
          
            /* Bubble sender (kamu) */
            .chat-bubble.sender {
              background-color: #2563eb; /* biru */
              color: white;
              border-bottom-right-radius: 0.25rem; /* sudut kanan bawah agak lancip */
            }
          
            /* Bubble penerima */
            .chat-bubble.receiver {
              background-color: #f3f4f6; /* abu terang */
              color: #374151; /* abu gelap */
              border-bottom-left-radius: 0.25rem; /* sudut kiri bawah agak lancip */
            }
          
            /* Responsif */
            @media (min-width: 640px) {
              .chat-bubble {
                max-width: 480px; /* desktop medium */
              }
            }
            @media (min-width: 1024px) {
              .chat-bubble {
                max-width: 600px; /* desktop besar */
              }
            }
          
            /* Hover efek halus */
            .chat-bubble:hover {
              box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
          </style>
          
        <!-- END: CSS Assets-->
    </head>
</div>
