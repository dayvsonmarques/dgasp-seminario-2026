(function(){
  document.addEventListener('DOMContentLoaded', function () {
    // Sticky header
    const siteHeader   = document.querySelector('.site-header');
    const headerBarTop = document.querySelector('.header-bar--top');
    const headerBarBot = document.querySelector('.header-bar--bottom');

    if (siteHeader) {
      const banner = document.querySelector('.banner-home');
      const getStickyThreshold = () => banner
        ? banner.getBoundingClientRect().bottom + window.scrollY
        : siteHeader.getBoundingClientRect().bottom;

      const onScroll = () => {
        if (window.scrollY >= getStickyThreshold()) {
          siteHeader.classList.add('site-header--sticky');
          if (headerBarTop) headerBarTop.classList.add('d-none');
          if (headerBarBot) headerBarBot.classList.add('d-none');
        } else {
          siteHeader.classList.remove('site-header--sticky');
          if (headerBarTop) headerBarTop.classList.remove('d-none');
          if (headerBarBot) headerBarBot.classList.remove('d-none');
        }
      };

      window.addEventListener('scroll', onScroll, { passive: true });
    }
  });

  const toggle = document.getElementById('menuToggle');
  const menu = document.getElementById('mainMenu');
  if (!toggle || !menu) return;

  const openMenu = () => {
    menu.classList.remove('d-none');
    menu.classList.add('show');
    toggle.setAttribute('aria-expanded', 'true');
  };

  const closeMenu = () => {
    menu.classList.remove('show');
    toggle.setAttribute('aria-expanded', 'false');
    menu.classList.add('d-none');
  };

  toggle.addEventListener('click', function(e){
    e.preventDefault();
    const isOpen = toggle.getAttribute('aria-expanded') === 'true';
    if (isOpen) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  document.addEventListener('click', function(e){
    if (!menu.classList.contains('show')) return;
    const clickInsideMenu = menu.contains(e.target) || toggle.contains(e.target);
    if (!clickInsideMenu) closeMenu();
  });

  // Smooth scroll for .js-scroll anchors
  document.addEventListener('click', function(e) {
    const link = e.target.closest('a.js-scroll');
    if (!link) return;
    const href = link.getAttribute('href');
    if (!href || !href.startsWith('#')) return;
    const target = document.querySelector(href);
    if (!target) return;
    e.preventDefault();
    const stickyHeader = document.querySelector('.site-header--sticky');
    const offset = stickyHeader ? stickyHeader.offsetHeight : 0;
    const top = target.getBoundingClientRect().top + window.scrollY - offset;
    window.scrollTo({ top, behavior: 'smooth' });
  });
})();
