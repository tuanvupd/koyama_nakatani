(function ($) {
  'use strict';

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
        const $intro = $('.nkt-list-categories__intro');
        const $list = $('.nkt-list-categories__list');
        const $thumbnails = $('.cate-item__thumbnail');
        const $cateItems = $('.cate-item');
        return { $section, $intro, $list, $thumbnails, $cateItems };
    }

    /**
     * Set the top position for .nkt-list-categories on mobile:
     *   top = -(introHeight) + 30px
     * Returns the threshold (used for calculating sticky):
     *   threshold = -top = introHeight - 30
     */

    function setMobileTopFromIntro() {
        const { $section, $intro } = getEls();
        if (!$section.length) return 0;

        if (!isMobile()) {
        // Không can thiệp top ở non-mobile; trả 0 để caller tự chọn default
        return 0;
        }

        const introH = Math.round($intro.outerHeight() || 0);
        // top = -introH + 30
        const topPx = (30 - introH);
        $section[0].style.top = topPx + 'px';

        // threshold = -top = introH - 30 (dùng trong isSticky calc)
        const threshold = Math.max(0, introH - 30);
        return threshold;
    }

    /**
     * Get the current sticky threshold:
     *  - Mobile: introHeight - 30 (from setMobileTopFromIntro)
     *  - Non-mobile: use a fixed constant (matching old CSS: desktop -73, tablet -60)
    */
    function getStickyThreshold() {
        if (isMobile()) {
            // Ensure that the top has been set according to the intro before reading the threshold.
            return setMobileTopFromIntro();
        }

        const w = window.innerWidth;
        if (w <= 1023.98) {
            return 60; // tablet: top ~ -60px
        }
        return 73; // desktop: top ~ -73px
    }

    // ===== Measurements =====
    function calculateMinHeight($list, $thumbnails) {
        const restore = [];
        $thumbnails.each(function () {
            const el = this;
            restore.push([el, el.getAttribute('style')]);
        });

        gsap.set($thumbnails.toArray(), {
            visibility: 'hidden',
            height: 0,
            marginBottom: 0,
            paddingTop: 0,
            paddingBottom: 0,
            overflow: 'hidden',
        });

        const h = $list.outerHeight();

        restore.forEach(([el, style]) => {
            if (style === null) el.removeAttribute('style');
            else el.setAttribute('style', style);
        });

        return h;
    }

    // ===== Instant states =====
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
    if (!hasGSAP()) return;

    const { $section, $list, $thumbnails } = getEls();

    // Lần đầu & mọi lúc có thể đổi: set top động trên mobile
    setMobileTopFromIntro();

    // Recalc khi ảnh trong thumbnails load xong
    $thumbnails.find('img').each(function () {
      if (this.complete) return;
      $(this).one('load', () => {
        if (hasAnimatedShow) $list[0].style.height = '';
        // Intro cao có thể đổi do reflow -> set lại top ở mobile
        setMobileTopFromIntro();
      });
    });

    // Observers: khi layout/DOM thay đổi
    let ro = null, mo = null;
    if ('ResizeObserver' in window) {
      ro = new ResizeObserver(() => {
        if (hasAnimatedShow) $list[0].style.height = '';
        // viewport đổi -> tính lại top động ở mobile
        setMobileTopFromIntro();
      });
      // Observe cả list & section để nhạy hơn
      const { $intro } = getEls();
      if ($intro[0]) ro.observe($intro[0]);
      if ($list[0]) ro.observe($list[0]);
    }
    if ('MutationObserver' in window) {
      mo = new MutationObserver(() => {
        if (hasAnimatedShow) $list[0].style.height = '';
        setMobileTopFromIntro();
      });
      mo.observe(document.body, { childList: true, subtree: true });
    }

    // Load first time: measure minimizedHeight reference
    $(window).on('load', () => {
      minimizedHeight = calculateMinHeight($list, $thumbnails);
      setMobileTopFromIntro();
    });

    // Resize/orientation: clear height & set lại top động ở mobile
    $(window).on('orientationchange resize', debounce(() => {
      $list[0].style.height = '';
      setMobileTopFromIntro();
    }, 50));

    // ==== Sticky toggle logic (giống snippet của bạn, nhưng threshold động) ====
    let lastScrollTop = $(window).scrollTop();
    // threshold ban đầu
    let threshold = getStickyThreshold();
    // khởi tạo wasSticky
    let wasSticky = $(window).scrollTop() > $section.offset().top - threshold;

    $(window).on('scroll', debounce(function () {
      // Each time you scroll, calculate a new threshold (mobile may change according to intro height)
      threshold = getStickyThreshold();

      const scrollTop = $(window).scrollTop();
      const scrollingUp = scrollTop < lastScrollTop;
      lastScrollTop = scrollTop;

      const isSticky = scrollTop > $section.offset().top - threshold;

      // toggle class like the original code
      $('.nkt-list-categories, body').toggleClass('has-sticky', isSticky);

      // In sticky: scroll down -> hide
      if (isSticky) {
        if (!hasAnimatedHide && !isClickInteraction && !isReducedMotion()) {
          hideThumbnails($list, $thumbnails);
        }
      }

      // Remove has-sticky when scrolling up: show full immediately
      if (wasSticky && !isSticky && scrollingUp) {
        showAllCatesNow();
      }

      // remove sticky in general: ensure show state + auto height
      if (!isSticky) {
        hasAnimatedHide = false;
        hasAnimatedShow = true;
        $list[0].style.height = '';
      }

      wasSticky = isSticky;
    }, 10));

    // Cleanup
    $(window).on('beforeunload', function () {
      if (clickScrollTimeout) clearTimeout(clickScrollTimeout);
      if (unbindArriveHandler) unbindArriveHandler();
      if (ro) ro.disconnect();
      if (mo) mo.disconnect();
    });

    if (mqlReduced && mqlReduced.addEventListener) {
      mqlReduced.addEventListener('change', () => {
        $list[0].style.height = '';
        setMobileTopFromIntro();
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
        mobile: isMobile(),
      };
    },
   
    refreshMobileTop() {
      setMobileTopFromIntro();
    },
  };

  // ===== Entry =====
  $(document).ready(function () {
    if (!hasGSAP()) return;
    initCategoryScroll();
    nktScrollWineItem();
  });
})(jQuery);