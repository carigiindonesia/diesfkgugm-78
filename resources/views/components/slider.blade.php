  @if($sliders->count())
  <!-- ==================== SLIDER ==================== -->
  <section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="relative overflow-hidden" id="slider-container">
        <div class="flex transition-transform duration-500 ease-in-out" id="slider-track">
          @foreach($sliders as $slider)
          <div class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
            <a href="{{ $slider->url ?? '#' }}" target="_blank" rel="noreferrer" class="block">
              <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-lg border border-slate-100 hover:shadow-2xl transition-all hover:-translate-y-1">
                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
              </div>
              @if($slider->title)
              <p class="mt-3 text-center text-sm font-bold text-slate-700">{{ $slider->title }}</p>
              @endif
            </a>
          </div>
          @endforeach
        </div>

        <!-- Prev/Next buttons -->
        <button onclick="slideCarousel(-1)" class="absolute left-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 backdrop-blur-md rounded-full shadow-lg flex items-center justify-center text-slate-700 hover:bg-white transition-colors z-10">
          <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </button>
        <button onclick="slideCarousel(1)" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/90 backdrop-blur-md rounded-full shadow-lg flex items-center justify-center text-slate-700 hover:bg-white transition-colors z-10">
          <i data-lucide="chevron-right" class="w-5 h-5"></i>
        </button>
      </div>
    </div>
  </section>

  <script>
    (function() {
      let currentSlide = 0;
      const track = document.getElementById('slider-track');
      if (!track) return;
      const slides = track.children;
      const totalSlides = slides.length;
      let slidesPerView = 3;

      function updateSlidesPerView() {
        if (window.innerWidth < 640) slidesPerView = 1;
        else if (window.innerWidth < 1024) slidesPerView = 2;
        else slidesPerView = 3;
      }

      function moveToSlide() {
        const maxSlide = Math.max(0, totalSlides - slidesPerView);
        if (currentSlide > maxSlide) currentSlide = 0;
        if (currentSlide < 0) currentSlide = maxSlide;
        const percentage = -(currentSlide * (100 / slidesPerView));
        track.style.transform = 'translateX(' + percentage + '%)';
      }

      window.slideCarousel = function(direction) {
        currentSlide += direction;
        moveToSlide();
      };

      updateSlidesPerView();
      window.addEventListener('resize', function() {
        updateSlidesPerView();
        moveToSlide();
      });

      // Auto-play
      setInterval(function() {
        currentSlide++;
        moveToSlide();
      }, 4000);
    })();
  </script>
  @endif