(function ($) {
  "use strict";

  const nktMenuMobile = () => {
    const btnOpen = $('.header-main .btn-open-menu');
    const btnClose = $('.header-main .btn-close-menu');
    const menuMobile = $('.header-main .header-mobile');

    btnOpen.on('click', function (e) {
        e.preventDefault();
        menuMobile.addClass('has-show');
        $('body').addClass('menu-open');
    });

    btnClose.on('click', function (e) {
        e.preventDefault();
        menuMobile.removeClass('has-show');   
        $('body').removeClass('menu-open');
    });
  };

const nktAnchorMenu = () => {
    const $header = $('#site-header');
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const $idAnchor = urlParams.get('section');
    
    if (!$idAnchor || !$(`#${$idAnchor}`).length) return;

    const $target = $(`#${$idAnchor}`);
    const targetPosition = $target.offset().top - 30 - $header.outerHeight();

    window.scrollTo({
        top: targetPosition,
        behavior: 'smooth'
    });
};

  $(window).on("load", function () {
    nktAnchorMenu()
  })

  $(document).ready(function () {
    nktMenuMobile();
  });

})(jQuery);
