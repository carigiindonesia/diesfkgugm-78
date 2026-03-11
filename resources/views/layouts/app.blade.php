<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dies Natalis FKG UGM ke-78 | Annual Symposium 2026</title>
  <meta name="description" content="Empowering Dental Sociopreneurs: Education and Technology for Oral Health Transformation. 17-19 April 2026, Yogyakarta." />
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

  @yield('content')

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