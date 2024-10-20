document.querySelectorAll('.has-dropdown').forEach(item => {
  item.addEventListener('click', function () {
      const allMenus = document.querySelectorAll('.sidebar-dropdown');
      allMenus.forEach(menu => {
          if (menu.id !== item.getAttribute('aria-controls')) {
              const collapse = new bootstrap.Collapse(menu, {
                  toggle: false
              });
              collapse.hide();
          }
      });
  });
});
