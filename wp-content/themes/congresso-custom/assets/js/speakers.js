(function () {
  const el = document.getElementById('speakersCarousel');
  if (!el) return;

  let startX = 0;

  el.addEventListener('mousedown',  e => { startX = e.clientX; });
  el.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });

  el.addEventListener('mouseup', e => {
    const diff = startX - e.clientX;
    if (Math.abs(diff) < 50) return;
    const carousel = bootstrap.Carousel.getOrCreateInstance(el);
    diff > 0 ? carousel.next() : carousel.prev();
  });

  el.addEventListener('touchend', e => {
    const diff = startX - e.changedTouches[0].clientX;
    if (Math.abs(diff) < 50) return;
    const carousel = bootstrap.Carousel.getOrCreateInstance(el);
    diff > 0 ? carousel.next() : carousel.prev();
  });
})();
