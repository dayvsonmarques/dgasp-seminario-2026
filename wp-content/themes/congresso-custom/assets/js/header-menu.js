(function(){
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
})();
