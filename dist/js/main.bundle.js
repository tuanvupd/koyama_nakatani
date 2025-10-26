/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/components/function.js":
/*!******************************************!*\
  !*** ./assets/js/components/function.js ***!
  \******************************************/
/***/ (() => {

eval("{(function ($) {\n  \"use strict\";\n\n  var nktLanguage = function nktLanguage() {\n    var $languageSwitchers = $('.language-switcher-desktop');\n    function initLanguageSwitcher() {\n      $languageSwitchers.each(function () {\n        var $switcher = $(this);\n        var $dropdown = $switcher.find('.language-dropdown');\n        var $languageItems = $switcher.find('.language-item');\n        $switcher.on('click', function (e) {\n          e.stopPropagation();\n          $(this).toggleClass('has-show');\n        });\n        $(document).on('click', function (e) {\n          if (!$switcher.is(e.target) && $switcher.has(e.target).length === 0) {\n            $switcher.removeClass('has-show');\n          }\n        });\n        $languageItems.on('click', function (e) {\n          e.preventDefault();\n          var newLangName = $(this).text();\n          $switcher.find('.current-language').text(newLangName);\n          window.location.href = $(this).attr('href');\n        });\n      });\n    }\n    initLanguageSwitcher();\n  };\n  var nktInfoFooter = function nktInfoFooter() {\n    var maxWidth = 0;\n    $('.info-item__title').each(function () {\n      var thisWidth = $(this).outerWidth();\n      if (thisWidth > maxWidth) {\n        maxWidth = thisWidth;\n      }\n    });\n    $('.info-item__title').css('min-width', maxWidth + 'px');\n  };\n  var nktHeroSlider = function nktHeroSlider() {\n    var swiper = new Swiper('.nkt-hero__slider', {\n      loop: true,\n      speed: 1000,\n      effect: 'fade',\n      fadeEffect: {\n        crossFade: true\n      },\n      autoplay: {\n        delay: 5000,\n        disableOnInteraction: false\n      }\n    });\n  };\n  var nktaboutCarousel = function nktaboutCarousel() {\n    var swiper = new Swiper('.nkt-about_carousel', {\n      loop: true,\n      speed: 8000,\n      effect: 'side',\n      fadeEffect: {\n        crossFade: true\n      },\n      autoplay: {\n        delay: 0,\n        disableOnInteraction: false\n      },\n      slidesPerView: 1,\n      spaceBetween: 20,\n      breakpoints: {\n        375: {\n          slidesPerView: 3,\n          spaceBetween: 20\n        },\n        768: {\n          slidesPerView: 4,\n          spaceBetween: 20\n        },\n        1024: {\n          slidesPerView: 4,\n          spaceBetween: 24\n        },\n        1200: {\n          slidesPerView: 5,\n          spaceBetween: 24\n        },\n        1600: {\n          slidesPerView: 7,\n          spaceBetween: 24\n        }\n      }\n    });\n  };\n  var nktScrollWineItem = function nktScrollWineItem() {\n    $('.cate-item').on('click', function (e) {\n      e.preventDefault();\n      var $this = $(this);\n      var targetSection = $this.data('cate');\n      var $targetElement = $('#' + targetSection);\n      if (!$targetElement.length) return;\n      var headerHeight = $('header').outerHeight() || 80;\n      var categoriesHeight = $('.nkt-list-categories__list').outerHeight() || 80;\n      var targetPosition = $targetElement.offset().top - headerHeight - categoriesHeight - 90;\n      window.scrollTo({\n        top: targetPosition,\n        behavior: 'smooth'\n      });\n\n      // Update active state\n      $('.cate-item').removeClass('active');\n      $this.addClass('active');\n    });\n  };\n  var nktModalBook = function nktModalBook() {\n    $('.btn-open-modal-book').on('click', function () {\n      var modalHTML = \"\\n                <div class=\\\"nkt-modal-book\\\">\\n                    <div class=\\\"nkt-modal-book-content\\\">\\n                        <button class=\\\"btn-close-modal-book\\\">&times;</button>\\n                        <iframe src=\\\"https://widget.thefork.com/en/68c527f1-efb7-4c60-8005-86ffcff0a82e\\\" frameborder=\\\"0\\\"></iframe>\\n                    </div>\\n                </div>\\n            \";\n      $('body').append(modalHTML);\n\n      // Animation open\n      setTimeout(function () {\n        $('.nkt-modal-book').addClass('active');\n        $('.nkt-modal-book-content').addClass('active');\n      }, 10);\n      $('.btn-close-modal-book, .nkt-modal-book').on('click', function (e) {\n        if (e.target === this) {\n          closeModal();\n        }\n      });\n      $(document).on('keydown', function (e) {\n        if (e.key === 'Escape') {\n          closeModal();\n        }\n      });\n    });\n    function closeModal() {\n      $('.nkt-modal-book').removeClass('active');\n      $('.nkt-modal-book-content').removeClass('active');\n      setTimeout(function () {\n        $('.nkt-modal-book').remove();\n      }, 300);\n    }\n  };\n  function debounce(func, wait) {\n    var timeout;\n    return function () {\n      var context = this,\n        args = arguments;\n      clearTimeout(timeout);\n      timeout = setTimeout(function () {\n        func.apply(context, args);\n      }, wait);\n    };\n  }\n  $(window).on('scroll', debounce(function () {\n    var isSticky = $(window).scrollTop() > $('.nkt-list-categories').offset().top - 73;\n    $('.nkt-list-categories, body').toggleClass('has-sticky', isSticky);\n  }, 10));\n  $(document).ready(function () {\n    nktInfoFooter();\n    nktLanguage();\n    nktHeroSlider();\n    nktaboutCarousel();\n    //    nktScrollWineItem()\n    nktModalBook();\n  });\n})(jQuery);\n\n//# sourceURL=webpack://nakatani/./assets/js/components/function.js?\n}");

/***/ }),

/***/ "./assets/js/components/header.js":
/*!****************************************!*\
  !*** ./assets/js/components/header.js ***!
  \****************************************/
/***/ (() => {

eval("{(function ($) {\n  \"use strict\";\n\n  var nktMenuMobile = function nktMenuMobile() {\n    var btnOpen = $('.header-main .btn-open-menu');\n    var btnClose = $('.header-main .btn-close-menu');\n    var menuMobile = $('.header-main .header-mobile');\n    btnOpen.on('click', function (e) {\n      e.preventDefault();\n      menuMobile.addClass('has-show');\n      $('body').addClass('menu-open');\n    });\n    btnClose.on('click', function (e) {\n      e.preventDefault();\n      menuMobile.removeClass('has-show');\n      $('body').removeClass('menu-open');\n    });\n  };\n  var nktAnchorMenu = function nktAnchorMenu() {\n    var $header = $('#site-header');\n    var queryString = window.location.search;\n    var urlParams = new URLSearchParams(queryString);\n    var $idAnchor = urlParams.get('section');\n    if (!$idAnchor || !$(\"#\".concat($idAnchor)).length) return;\n    var $target = $(\"#\".concat($idAnchor));\n    var targetPosition = $target.offset().top - 30 - $header.outerHeight();\n    window.scrollTo({\n      top: targetPosition,\n      behavior: 'smooth'\n    });\n  };\n  $(window).on(\"load\", function () {\n    nktAnchorMenu();\n  });\n  $(document).ready(function () {\n    nktMenuMobile();\n  });\n})(jQuery);\n\n//# sourceURL=webpack://nakatani/./assets/js/components/header.js?\n}");

/***/ }),

/***/ "./assets/js/components/nav-cate.js":
/*!******************************************!*\
  !*** ./assets/js/components/nav-cate.js ***!
  \******************************************/
/***/ (() => {

eval("{(function ($) {\n  'use strict';\n\n  var hasAnimatedHide = false;\n  var hasAnimatedShow = true;\n  var isAnimating = false;\n  var originalHeight = 0;\n  var minimizedHeight = 0;\n  var isClickInteraction = false;\n  var scrollTimeout = null;\n  var clickScrollTimeout = null;\n  function initCategoryScroll() {\n    if (!isMobile()) {\n      return;\n    }\n    var $section = $('.nkt-list-categories');\n    var $list = $('.nkt-list-categories__list');\n    var $thumbnails = $('.cate-item__thumbnail');\n    var $cateItems = $('.cate-item');\n    var stickyTop = parseInt($section.css('top')) || -103;\n\n    // Calculate the exact height\n    calculateHeights($list, $cateItems, $thumbnails);\n    var lastScrollTop = 0;\n    function handleScroll() {\n      if (isAnimating || isClickInteraction) return;\n      var scrollTop = $(window).scrollTop();\n      var scrollDirection = scrollTop > lastScrollTop ? 'down' : 'up';\n      lastScrollTop = scrollTop;\n      var sectionOffset = $section.offset().top;\n      var stickyStartPoint = sectionOffset + stickyTop;\n      var isInStickyPosition = scrollTop >= stickyStartPoint;\n\n      // Clear existing timeout\n      if (scrollTimeout) clearTimeout(scrollTimeout);\n\n      // Debounce scroll for better performance\n      scrollTimeout = setTimeout(function () {\n        if (isAnimating || isClickInteraction) return;\n\n        // SCROLL UP -> SHOW\n        if (scrollDirection === 'up' && isInStickyPosition && !hasAnimatedShow) {\n          showThumbnails($list, $thumbnails, $cateItems);\n        }\n        // SCROLL DOWN -> HIDE\n        else if (scrollDirection === 'down' && isInStickyPosition && !hasAnimatedHide) {\n          hideThumbnails($list, $thumbnails, $cateItems);\n        }\n        // Get out of the sticky zone -> reset\n        else if (!isInStickyPosition) {\n          hasAnimatedHide = false;\n          hasAnimatedShow = true;\n        }\n      }, 50);\n    }\n    $(window).on('scroll', handleScroll);\n\n    // Recalculate on resize\n    $(window).on('resize', function () {\n      if (!isMobile()) return;\n      calculateHeights($list, $cateItems, $thumbnails);\n    });\n\n    // Cleanup on page unload\n    $(window).on('beforeunload', function () {\n      if (scrollTimeout) clearTimeout(scrollTimeout);\n      if (clickScrollTimeout) clearTimeout(clickScrollTimeout);\n    });\n  }\n  function isMobile() {\n    return window.innerWidth <= 767.98;\n  }\n  function calculateHeights($list, $cateItems, $thumbnails) {\n    // Get original height\n    originalHeight = $list.outerHeight();\n\n    // Temporarily hide the thumbnail to calculate height.\n    $thumbnails.hide();\n\n    // get height when there is no thumbnail.\n    minimizedHeight = $list.outerHeight();\n\n    // show thumbnail\n    $thumbnails.show();\n  }\n  function hideThumbnails($list, $thumbnails, $cateItems) {\n    if (isClickInteraction) return;\n    isAnimating = true;\n    var timeline = gsap.timeline({\n      onComplete: function onComplete() {\n        hasAnimatedHide = true;\n        hasAnimatedShow = false;\n        isAnimating = false;\n      }\n    });\n    timeline.to($list[0], {\n      height: minimizedHeight,\n      duration: 0.6,\n      ease: \"power2.inOut\"\n    }).to($thumbnails.toArray(), {\n      opacity: 0,\n      scale: 0.8,\n      height: 0,\n      marginBottom: 0,\n      duration: 0.4,\n      stagger: 0.1\n    }, \"-=0.3\");\n  }\n  function showThumbnails($list, $thumbnails, $cateItems) {\n    if (isClickInteraction) {\n      // console.log('Blocked showThumbnails due to click interaction');\n      return;\n    }\n    isAnimating = true;\n    var timeline = gsap.timeline({\n      onComplete: function onComplete() {\n        hasAnimatedShow = true;\n        hasAnimatedHide = false;\n        isAnimating = false;\n      }\n    });\n    timeline.to($thumbnails.toArray(), {\n      opacity: 1,\n      scale: 1,\n      height: 'auto',\n      marginBottom: 0,\n      duration: 0.5,\n      stagger: 0.08\n    }).to($list[0], {\n      height: originalHeight,\n      duration: 0.7,\n      ease: \"power2.inOut\"\n    }, \"-=0.2\");\n  }\n  function nktScrollWineItem() {\n    $('.cate-item').on('click', function (e) {\n      e.preventDefault();\n\n      // Clear any existing click timeout\n      if (clickScrollTimeout) clearTimeout(clickScrollTimeout);\n      isClickInteraction = true;\n      var $this = $(this);\n      var targetSection = $this.data('cate');\n      var $targetElement = $('#' + targetSection);\n      if (!$targetElement.length) {\n        // Reset after 2 seconds if the target is not found.\n        clickScrollTimeout = setTimeout(function () {\n          isClickInteraction = false;\n          // console.log('Click interaction ended (no target)');\n        }, 2000);\n        return;\n      }\n      var headerHeight = $('header').outerHeight() || 80;\n      var categoriesHeight = $('.nkt-list-categories__list').outerHeight() || 80;\n      var targetPosition = $targetElement.offset().top - headerHeight - categoriesHeight - 90;\n\n      // Update active state trước\n      $('.cate-item').removeClass('active');\n      $this.addClass('active');\n      window.scrollTo({\n        top: targetPosition,\n        behavior: 'smooth'\n      });\n\n      // LONGER BLOCK: Reset flag after scrolling is completely finished\n      // Calculate time based on scroll distance\n      var currentPosition = $(window).scrollTop();\n      var scrollDistance = Math.abs(targetPosition - currentPosition);\n      var estimatedScrollTime = Math.min(Math.max(scrollDistance / 1000, 1), 3) * 1000; // 1-3 giây\n\n      // console.log(`Scroll distance: ${scrollDistance}px, Estimated time: ${estimatedScrollTime}ms`);\n\n      clickScrollTimeout = setTimeout(function () {\n        isClickInteraction = false;\n        // console.log('Click interaction ended after scroll');\n      }, estimatedScrollTime + 1000); // Thêm 1 giây buffer\n    });\n  }\n\n  // Initialize when document is ready\n  $(document).ready(function () {\n    if (typeof gsap !== 'undefined') {\n      initCategoryScroll();\n      nktScrollWineItem();\n    }\n  });\n\n  // Optional: Export functions for external control\n  window.categoryScroll = {\n    disable: function disable() {\n      var duration = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 5000;\n      isClickInteraction = true;\n      setTimeout(function () {\n        isClickInteraction = false;\n      }, duration);\n    },\n    enable: function enable() {\n      isClickInteraction = false;\n      if (clickScrollTimeout) clearTimeout(clickScrollTimeout);\n    },\n    forceHide: function forceHide() {\n      if (!isMobile()) return;\n      var $list = $('.nkt-list-categories__list');\n      var $thumbnails = $('.cate-item__thumbnail');\n      var $cateItems = $('.cate-item');\n      hideThumbnails($list, $thumbnails, $cateItems);\n    },\n    getState: function getState() {\n      return {\n        isClickInteraction: isClickInteraction,\n        hasAnimatedHide: hasAnimatedHide,\n        hasAnimatedShow: hasAnimatedShow,\n        isAnimating: isAnimating\n      };\n    }\n  };\n})(jQuery);\n\n//# sourceURL=webpack://nakatani/./assets/js/components/nav-cate.js?\n}");

/***/ }),

/***/ "./assets/js/index.js":
/*!****************************!*\
  !*** ./assets/js/index.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("{__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_header__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/header */ \"./assets/js/components/header.js\");\n/* harmony import */ var _components_header__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_components_header__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _components_function__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/function */ \"./assets/js/components/function.js\");\n/* harmony import */ var _components_function__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_components_function__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _components_nav_cate__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/nav-cate */ \"./assets/js/components/nav-cate.js\");\n/* harmony import */ var _components_nav_cate__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_components_nav_cate__WEBPACK_IMPORTED_MODULE_2__);\n\n\n\n\n//# sourceURL=webpack://nakatani/./assets/js/index.js?\n}");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/js/index.js");
/******/ 	
/******/ })()
;