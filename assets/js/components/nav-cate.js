/**
 * NKT Wine Categories – Mobile Scroll/Click Animation (jQuery + GSAP)
 * Version: sticky-toggle aware
 *
 * Core:
 *  - Không cache originalHeight (đo động bằng scrollHeight)
 *  - JIT minimizedHeight mỗi lần hide
 *  - Show: tween tới scrollHeight rồi clearProps('height')
 *  - Tôn trọng prefers-reduced-motion
 *  - Recalc thông minh khi ảnh/DOM/resize thay đổi (ResizeObserver/MutationObserver)
 *  - Click scroll: unlock theo vị trí + fallback
 *
 * NEW (theo yêu cầu):
 *  - Dùng debounce + toggleClass('has-sticky', isSticky) như code của bạn
 *  - Ngay khoảnh khắc remove has-sticky khi cuộn lên (sticky -> non-sticky, hướng up) => show full cates
 */

(function ($) {
  'use strict';

  // ===== Debounce helper (nếu bạn đã có rồi thì có thể bỏ) =====
  function debounce(fn, wait) {
    let t;
    return function () {
      const ctx = this, args = arguments;
      clearTimeout(t);
      t = setTimeout(function () {
        fn.apply(ctx, args);
      }, wait);
    };
  }

  // ===== Runtime State =====
  let hasAnimatedHide = false;
  let hasAnimatedShow = true;
  let isAnimating = false;
  let minimizedHeight = 0;
  let isClickInteraction = false;
  let clickScrollTimeout = null;
  let unbindArriveHandler = null;

  // ===== Feature Detect =====
  const mqlReduced = window.matchMedia?.('(prefers-reduced-motion: reduce)');
  const isReducedMotion = () => !!(mqlReduced && mqlReduced.matches);
  const hasGSAP = () => typeof gsap !== 'undefined';

  // ===== Utils =====
  function isMobile() {
    return window.innerWidth <= 767.98;
  }

  function getEls() {
    const $section = $('.nkt-list-categories');
    const $list = $('.nkt-list-categories__list');
    const $thumbnails = $('.cate-item__thumbnail');
    const $cateItems = $('.cate-item');
    return { $section, $list, $thumbnails, $cateItems };
  }

  // ===== Measurements =====
  function calculateMinHeight($list, $thumbnails) {
    // backup inline style để restore chính xác
    const restore = [];
    $thumbnails.each(function () {
      const el = this;
      restore.push([el, el.getAttribute('style')]);
    });

    // collapse thumbnails để đo list height khi gọn
    gsap.set($thumbnails.toArray(), {
      visibility: 'hidden',
      height: 0,
      marginBottom: 0,
      paddingTop: 0,
      paddingBottom: 0,
      overflow: 'hidden',
    });

    const h = $list.outerHeight();

    // restore inline styles
    restore.forEach(([el, style]) => {
      if (style === null) el.removeAttribute('style');
      else el.setAttribute('style', style);
    });

    return h;
  }

  // ===== Instant states (khi reduced motion hoặc cần reset nhanh) =====
  function instantHide($list, $thumbnails) {
    minimizedHeight = calculateMinHeight($list, $thumbnails);
    $thumbnails.css({ opacity: 0, height: 0, marginBottom: 0 });
    $list[0].style.height = minimizedHeight + 'px';
    hasAnimatedHide = true;
    hasAnimatedShow = false;
  }

  function instantShow($list, $thumbnails) {
    $thumbnails.css({ opacity: 1, height: 'auto', marginBottom: 0, transform: '' });
    $list[0].style.height = '';
    hasAnimatedShow = true;
    hasAnimatedHide = false;
  }

  // ===== Animations =====
  function hideThumbnails($list, $thumbnails) {
    if (isClickInteraction || isAnimating) return;

    if (isReducedMotion()) {
      instantHide($list, $thumbnails);
      return;
    }

    isAnimating = true;
    minimizedHeight = calculateMinHeight($list, $thumbnails);

    const tl = gsap.timeline({
      onComplete: () => {
        hasAnimatedHide = true;
        hasAnimatedShow = false;
        isAnimating = false;
      },
    });

    tl.to($list[0], {
      height: minimizedHeight,
      duration: 0.6,
      ease: 'power2.inOut',
      force3D: true,
    }).to(
      $thumbnails.toArray(),
      {
        opacity: 0,
        scale: 0.8,
        height: 0,
        marginBottom: 0,
        duration: 0.4,
        stagger: 0.1,
      },
      '-=0.3'
    );
  }

  function showThumbnails($list, $thumbnails) {
    if (isClickInteraction || isAnimating) return;

    if (isReducedMotion()) {
      instantShow($list, $thumbnails);
      return;
    }

    isAnimating = true;

    const tl = gsap.timeline({
      onComplete: () => {
        gsap.set($list[0], { clearProps: 'height' });
        hasAnimatedShow = true;
        hasAnimatedHide = false;
        isAnimating = false;
      },
    });

    tl.to($thumbnails.toArray(), {
      opacity: 1,
      scale: 1,
      height: 'auto',
      marginBottom: 0,
      duration: 0.5,
      stagger: 0.08,
    });

    tl.add(() => {
      const currentH = $list.outerHeight();
      gsap.set($list[0], { height: currentH });
      const expanded = $list[0].scrollHeight;
      tl.to(
        $list[0],
        {
          height: expanded,
          duration: 0.7,
          ease: 'power2.inOut',
          force3D: true,
        },
        0
      );
    }, '-=0.2');
  }

  // ===== Public helper: show full ngay lập tức (dùng khi remove has-sticky) =====
  function showAllCatesNow() {
    const { $list, $thumbnails } = getEls();

    if (hasGSAP()) {
      try { gsap.killTweensOf([$list[0], ...$thumbnails.toArray()]); } catch (e) {}

      gsap.set($thumbnails.toArray(), {
        opacity: 1,
        height: 'auto',
        clearProps: 'scale,marginBottom,visibility,overflow',
      });
      gsap.set($list[0], { clearProps: 'height' });
    } else {
      $thumbnails.css({ opacity: 1, height: 'auto', marginBottom: '' });
      if ($list[0]) $list[0].style.height = '';
    }

    hasAnimatedShow = true;
    hasAnimatedHide = false;

    if (window.categoryScroll && typeof window.categoryScroll.enable === 'function') {
      window.categoryScroll.enable();
    }
  }

  // ===== Init: scroll + sticky toggle =====
  function initCategoryScroll() {
    if (!isMobile()) return;

    const { $section, $list, $thumbnails } = getEls();

    // Recalc khi ảnh trong thumbnails load xong (trường hợp lazy/cache)
    $thumbnails.find('img').each(function () {
      if (this.complete) return;
      $(this).one('load', () => {
        if (hasAnimatedShow) $list[0].style.height = '';
      });
    });

    // Observers: khi layout/DOM thay đổi, đảm bảo list ở auto-height nếu đang show
    let ro = null, mo = null;
    if ('ResizeObserver' in window) {
      ro = new ResizeObserver(() => {
        if (hasAnimatedShow) $list[0].style.height = '';
      });
      ro.observe($list[0]);
    }
    if ('MutationObserver' in window) {
      mo = new MutationObserver(() => {
        if (hasAnimatedShow) $list[0].style.height = '';
      });
      mo.observe($list[0], { childList: true, subtree: true });
    }

    // Load lần đầu: đo minimizedHeight tham khảo (khi hide sẽ đo JIT lại)
    $(window).on('load', () => {
      minimizedHeight = calculateMinHeight($list, $thumbnails);
    });

    // Resize/orientation: clear inline height để auto
    $(window).on('orientationchange resize', () => {
      if (!isMobile()) return;
      $list[0].style.height = '';
    });

    // ==== Sticky toggle logic (theo đúng snippet của bạn) ====
    // - Dùng debounce(…, 10)
    // - Toggle class .has-sticky cho .nkt-list-categories và body
    // - Detect chuyển sticky->non-sticky khi cuộn lên => showAllCatesNow()
    const THRESHOLD = 73; // khớp với top: -73px trong CSS trên desktop (đã thấy trong ví dụ của bạn)
    let lastScrollTop = $(window).scrollTop();
    let wasSticky = $(window).scrollTop() > $section.offset().top - THRESHOLD;

    $(window).on('scroll', debounce(function () {
      const scrollTop = $(window).scrollTop();
      const scrollingUp = scrollTop < lastScrollTop;
      lastScrollTop = scrollTop;

      const isSticky = scrollTop > $section.offset().top - THRESHOLD;

      // toggle class như code gốc của bạn
      $('.nkt-list-categories, body').toggleClass('has-sticky', isSticky);

      // === Animation rules trong sticky ===
      // Nếu đang sticky:
      if (isSticky) {
        // Cuộn xuống trong sticky -> hide (nếu chưa hide)
        if (!hasAnimatedHide && !isClickInteraction && !isReducedMotion()) {
          hideThumbnails($list, $thumbnails);
        }
      }

      // Ngay khoảnh khắc remove has-sticky (từ sticky -> non-sticky) và đang cuộn lên:
      if (wasSticky && !isSticky && scrollingUp) {
        // -> show full cates ngay lập tức theo yêu cầu của bạn
        showAllCatesNow();
      }

      // Nếu đã non-sticky (rời sticky) nhưng không rơi vào case trên (ví dụ cuộn xuống nhanh):
      if (!isSticky) {
        // đảm bảo ở trạng thái show & auto height (không kẹt số)
        hasAnimatedHide = false;
        hasAnimatedShow = true;
        $list[0].style.height = '';
      }

      // update state
      wasSticky = isSticky;
    }, 10));

    // Cleanup
    $(window).on('beforeunload', function () {
      if (clickScrollTimeout) clearTimeout(clickScrollTimeout);
      if (unbindArriveHandler) unbindArriveHandler();
      if (ro) ro.disconnect();
      if (mo) mo.disconnect();
    });

    // Nếu người dùng đổi setting reduced-motion, clear height để tránh kẹt
    if (mqlReduced && mqlReduced.addEventListener) {
      mqlReduced.addEventListener('change', () => {
        $list[0].style.height = '';
      });
    }
  }

  // ===== Click scroll đến section tương ứng =====
  function nktScrollWineItem() {
    $('.cate-item').on('click', function (e) {
      e.preventDefault();

      if (clickScrollTimeout) clearTimeout(clickScrollTimeout);
      if (unbindArriveHandler) unbindArriveHandler();

      isClickInteraction = true;

      const $this = $(this);
      const targetSection = $this.data('cate');
      const $targetElement = $('#' + targetSection);

      if (!$targetElement.length) {
        clickScrollTimeout = setTimeout(() => {
          isClickInteraction = false;
        }, 2000);
        return;
      }

      const headerHeight = $('header').outerHeight() || 80;
      const categoriesHeight = $('.nkt-list-categories__list').outerHeight() || 80;
      const targetPosition = $targetElement.offset().top - headerHeight - categoriesHeight - 90;

      $('.cate-item').removeClass('active');
      $this.addClass('active');

      if (isReducedMotion()) {
        window.scrollTo(0, targetPosition);
        isClickInteraction = false;
        return;
      }

      window.scrollTo({ top: targetPosition, behavior: 'smooth' });

      // unlock theo vị trí
      const arriveHandler = () => {
        const delta = Math.abs($(window).scrollTop() - targetPosition);
        if (delta < 8) {
          isClickInteraction = false;
          $(window).off('scroll', arriveHandler);
          unbindArriveHandler = null;
        }
      };
      $(window).on('scroll', arriveHandler);
      unbindArriveHandler = () => $(window).off('scroll', arriveHandler);

      // fallback 4s
      clickScrollTimeout = setTimeout(() => {
        isClickInteraction = false;
        if (unbindArriveHandler) {
          unbindArriveHandler();
          unbindArriveHandler = null;
        }
      }, 4000);
    });
  }

  // ===== Expose dev API (tùy chọn) =====
  window.categoryScroll = {
    disable(duration = 5000) {
      isClickInteraction = true;
      setTimeout(() => {
        isClickInteraction = false;
      }, duration);
    },
    enable() {
      isClickInteraction = false;
      if (clickScrollTimeout) clearTimeout(clickScrollTimeout);
      if (unbindArriveHandler) {
        unbindArriveHandler();
        unbindArriveHandler = null;
      }
    },
    forceHide() {
      if (!isMobile()) return;
      const { $list, $thumbnails } = getEls();
      if (isReducedMotion()) {
        instantHide($list, $thumbnails);
      } else {
        hideThumbnails($list, $thumbnails);
      }
    },
    getState() {
      return {
        isClickInteraction,
        hasAnimatedHide,
        hasAnimatedShow,
        isAnimating,
        reducedMotion: isReducedMotion(),
      };
    },
  };

  // ===== Entry =====
  $(document).ready(function () {
    console.log("zil check code now")
    if (!hasGSAP()) return;
    initCategoryScroll();
    nktScrollWineItem();
  });
})(jQuery);
