<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'Dies Natalis FKG UGM ke-78 | Simposium & Workshop Kedokteran Gigi 2026')</title>
  <meta name="description" content="@yield('meta_description', 'Dies Natalis FKG UGM ke-78 — Simposium, Hands-on Workshop, Fun Run & Pengabdian Masyarakat. Empowering Dental Sociopreneurs: Education and Technology for Oral Health Transformation. 17-20 April 2026, Yogyakarta.')" />
  <meta name="keywords" content="Dies Natalis FKG UGM, Dies Natalis FKG UGM ke-78, Fakultas Kedokteran Gigi UGM, Simposium Kedokteran Gigi, Hands-on Workshop UGM, Annual Symposium FKG UGM 2026, Dental Sociopreneurs, Oral Health Transformation, Fun Run FKG UGM, Universitas Gadjah Mada" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="{{ url()->current() }}" />

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:locale" content="id_ID" />
  <meta property="og:site_name" content="Dies Natalis FKG UGM ke-78" />
  <meta property="og:title" content="@yield('og_title', 'Dies Natalis FKG UGM ke-78 | Simposium & Workshop Kedokteran Gigi 2026')" />
  <meta property="og:description" content="@yield('og_description', 'Dies Natalis FKG UGM ke-78 — Simposium, Hands-on Workshop, Fun Run & Pengabdian Masyarakat. 17-20 April 2026, Gadjah Mada University Club Hotel, Yogyakarta.')" />
  <meta property="og:url" content="{{ url()->current() }}" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="@yield('twitter_title', 'Dies Natalis FKG UGM ke-78 | Annual Symposium 2026')" />
  <meta name="twitter:description" content="@yield('twitter_description', 'Simposium & Workshop Kedokteran Gigi — Empowering Dental Sociopreneurs. 17-20 April 2026, Yogyakarta.')" />

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Event",
    "name": "Dies Natalis FKG UGM ke-78 — Annual Symposium",
    "description": "Empowering Dental Sociopreneurs: Education and Technology for Oral Health Transformation",
    "startDate": "2026-04-17",
    "endDate": "2026-04-20",
    "eventStatus": "https://schema.org/EventScheduled",
    "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
    "location": {
      "@type": "Place",
      "name": "Gadjah Mada University Club Hotel",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Yogyakarta",
        "addressRegion": "DI Yogyakarta",
        "addressCountry": "ID"
      }
    },
    "organizer": {
      "@type": "Organization",
      "name": "Fakultas Kedokteran Gigi Universitas Gadjah Mada",
      "url": "{{ url('/') }}"
    },
    "subEvent": [
      {
        "@type": "Event",
        "name": "Simposium Kedokteran Gigi",
        "description": "Annual Symposium Dies Natalis FKG UGM ke-78"
      },
      {
        "@type": "Event",
        "name": "Hands-on Workshop",
        "description": "Workshop praktik kedokteran gigi"
      },
      {
        "@type": "Event",
        "name": "Fun Run 5K",
        "description": "Fun Run Dies Natalis FKG UGM ke-78"
      },
      {
        "@type": "Event",
        "name": "Pengabdian Masyarakat",
        "description": "Program pengabdian masyarakat FKG UGM"
      }
    ]
  }
  </script>

  @yield('structured_data')

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a',950:'#172554'},
            gold: {400:'#fbbf24',500:'#f59e0b',600:'#d97706'},
          },
          fontFamily: {
            sans: ['Inter','system-ui','sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    ::selection { background: #3b82f6; color: white; }
    .fade-in { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .fade-in.visible { opacity: 1; transform: translateY(0); }
    @keyframes float { 0%,100%{transform:translateY(0) rotate(-2deg)} 50%{transform:translateY(-12px) rotate(-2deg)} }
    .float-anim { animation: float 6s ease-in-out infinite; }
    @keyframes pulse-slow { 0%,100%{opacity:.15} 50%{opacity:.25} }
    .pulse-bg { animation: pulse-slow 4s ease-in-out infinite; }
  </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased overflow-x-hidden">

  <!-- Security Protections -->
  @include('components.security-protection')

  @yield('content')

  <!-- Cookie Consent -->
  @include('components.cookie-consent')

  <!-- ==================== WHATSAPP FLOATING BUTTON ==================== -->
  <a href="https://wa.me/6285147686127" target="_blank" rel="noopener noreferrer"
     class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white w-16 h-16 rounded-full flex items-center justify-center shadow-2xl hover:shadow-[0_10px_40px_-10px_rgba(34,197,94,0.5)] transition-all hover:scale-110 group"
     title="Event Registrations Support and Helpdesk Carigi Indonesia">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    <span class="absolute right-full mr-3 bg-white text-slate-800 text-xs font-bold px-4 py-2 rounded-xl shadow-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
      Helpdesk Carigi Indonesia
    </span>
  </a>

  <!-- ==================== SCRIPTS ==================== -->
  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Mobile menu toggle
    let menuOpen = false;
    function toggleMenu() {
      menuOpen = !menuOpen;
      document.getElementById('mobile-menu').classList.toggle('hidden', !menuOpen);
    }
    function closeMenu() {
      menuOpen = false;
      document.getElementById('mobile-menu').classList.add('hidden');
    }

    // Schedule tab switcher
    function switchDay(day) {
      document.querySelectorAll('[data-day]').forEach(el => el.classList.add('hidden'));
      document.querySelector('[data-day="' + day + '"]').classList.remove('hidden');
      document.querySelectorAll('[data-tab]').forEach(btn => {
        const isActive = btn.dataset.tab === day;
        btn.className = 'flex-1 min-w-[100px] py-3.5 rounded-xl font-black text-sm tracking-wider transition-all ' +
          (isActive ? 'bg-primary-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-700');
      });
    }

    // Scroll fade-in animation
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
  </script>
</body>
</html>