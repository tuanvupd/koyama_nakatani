(function($) {
    'use strict';
    
    let hasAnimatedHide = false;
    let hasAnimatedShow = true;
    let isAnimating = false;
    let originalHeight = 0;
    let minimizedHeight = 0;
    let isClickInteraction = false;
    let scrollTimeout = null;
    let clickScrollTimeout = null;

    function initCategoryScroll() {
        if (!isMobile()) {
            return;
        }
        
        const $section = $('.nkt-list-categories');
        const $list = $('.nkt-list-categories__list');
        const $thumbnails = $('.cate-item__thumbnail');
        const $cateItems = $('.cate-item');
        const stickyTop = parseInt($section.css('top')) || -103;
        
        // Calculate the exact height
        calculateHeights($list, $cateItems, $thumbnails);
        
        let lastScrollTop = 0;
        
        function handleScroll() {
            if (isAnimating || isClickInteraction) return;
            
            const scrollTop = $(window).scrollTop();
            const scrollDirection = scrollTop > lastScrollTop ? 'down' : 'up';
            lastScrollTop = scrollTop;
            
            const sectionOffset = $section.offset().top;
            const stickyStartPoint = sectionOffset + stickyTop;
            const isInStickyPosition = scrollTop >= stickyStartPoint;
            
            // Clear existing timeout
            if (scrollTimeout) clearTimeout(scrollTimeout);
            
            // Debounce scroll for better performance
            scrollTimeout = setTimeout(() => {
                if (isAnimating || isClickInteraction) return;
                
                // SCROLL UP -> SHOW
                if (scrollDirection === 'up' && isInStickyPosition && !hasAnimatedShow) {
                    showThumbnails($list, $thumbnails, $cateItems);
                }
                // SCROLL DOWN -> HIDE
                else if (scrollDirection === 'down' && isInStickyPosition && !hasAnimatedHide) {
                    hideThumbnails($list, $thumbnails, $cateItems);
                }
                // Get out of the sticky zone -> reset
                else if (!isInStickyPosition) {
                    hasAnimatedHide = false;
                    hasAnimatedShow = true;
                }
            }, 50);
        }
        
        $(window).on('scroll', handleScroll);
        
        // Recalculate on resize
        $(window).on('resize', function() {
            if (!isMobile()) return;
            calculateHeights($list, $cateItems, $thumbnails);
        });
        
        // Cleanup on page unload
        $(window).on('beforeunload', function() {
            if (scrollTimeout) clearTimeout(scrollTimeout);
            if (clickScrollTimeout) clearTimeout(clickScrollTimeout);
        });
    }
    
    function isMobile() {
        return window.innerWidth <= 767.98;
    }
    
    function calculateHeights($list, $cateItems, $thumbnails) {
        // Get original height
        originalHeight = $list.outerHeight();
        
        // Temporarily hide the thumbnail to calculate height.
        $thumbnails.hide();
        
        // get height when there is no thumbnail.
        minimizedHeight = $list.outerHeight();
        
        // show thumbnail
        $thumbnails.show();
    }
    
    function hideThumbnails($list, $thumbnails, $cateItems) {
        if (isClickInteraction) return;
        
        isAnimating = true;
        
        const timeline = gsap.timeline({
            onComplete: () => {
                hasAnimatedHide = true;
                hasAnimatedShow = false;
                isAnimating = false;
            }
        });
        
        timeline
            .to($list[0], {
                height: minimizedHeight,
                duration: 0.6,
                ease: "power2.inOut"
            })
            .to($thumbnails.toArray(), {
                opacity: 0,
                scale: 0.8,
                height: 0,
                marginBottom: 0,
                duration: 0.4,
                stagger: 0.1
            }, "-=0.3");
    }
    
    function showThumbnails($list, $thumbnails, $cateItems) {
        if (isClickInteraction) {
            // console.log('Blocked showThumbnails due to click interaction');
            return;
        }
        
        isAnimating = true;
        
        const timeline = gsap.timeline({
            onComplete: () => {
                hasAnimatedShow = true;
                hasAnimatedHide = false;
                isAnimating = false;
            }
        });
        
        timeline
            .to($thumbnails.toArray(), {
                opacity: 1,
                scale: 1,
                height: 'auto',
                marginBottom: 0,
                duration: 0.5,
                stagger: 0.08
            })
            .to($list[0], {
                height: originalHeight,
                duration: 0.7,
                ease: "power2.inOut"
            }, "-=0.2");
    }

    function nktScrollWineItem() {
        $('.cate-item').on('click', function(e) {
            e.preventDefault();
            
            // Clear any existing click timeout
            if (clickScrollTimeout) clearTimeout(clickScrollTimeout);
            
            
            isClickInteraction = true;
            
            const $this = $(this);
            const targetSection = $this.data('cate');
            const $targetElement = $('#' + targetSection);
            
            if (!$targetElement.length) {
                // Reset after 2 seconds if the target is not found.
                clickScrollTimeout = setTimeout(() => {
                    isClickInteraction = false;
                    // console.log('Click interaction ended (no target)');
                }, 2000);
                return;
            }
            
            const headerHeight = $('header').outerHeight() || 80;
            const categoriesHeight = $('.nkt-list-categories__list').outerHeight() || 80;
            const targetPosition = $targetElement.offset().top - headerHeight - categoriesHeight - 90;
            
            // Update active state trước
            $('.cate-item').removeClass('active');
            $this.addClass('active');
            
           
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
            
            // LONGER BLOCK: Reset flag after scrolling is completely finished
            // Calculate time based on scroll distance
            const currentPosition = $(window).scrollTop();
            const scrollDistance = Math.abs(targetPosition - currentPosition);
            const estimatedScrollTime = Math.min(Math.max(scrollDistance / 1000, 1), 3) * 1000; // 1-3 giây
            
            // console.log(`Scroll distance: ${scrollDistance}px, Estimated time: ${estimatedScrollTime}ms`);
            
            clickScrollTimeout = setTimeout(() => {
                isClickInteraction = false;
                // console.log('Click interaction ended after scroll');
            }, estimatedScrollTime + 1000); // Thêm 1 giây buffer
        });
    }

    // Initialize when document is ready
    $(document).ready(function() {
        if (typeof gsap !== 'undefined') {
            initCategoryScroll();
            nktScrollWineItem();
        }
    });
    
    // Optional: Export functions for external control
    window.categoryScroll = {
        disable: function(duration = 5000) {
            isClickInteraction = true;
            setTimeout(() => {
                isClickInteraction = false;
            }, duration);
        },
        enable: function() {
            isClickInteraction = false;
            if (clickScrollTimeout) clearTimeout(clickScrollTimeout);
        },
        forceHide: function() {
            if (!isMobile()) return;
            const $list = $('.nkt-list-categories__list');
            const $thumbnails = $('.cate-item__thumbnail');
            const $cateItems = $('.cate-item');
            hideThumbnails($list, $thumbnails, $cateItems);
        },
        getState: function() {
            return {
                isClickInteraction: isClickInteraction,
                hasAnimatedHide: hasAnimatedHide,
                hasAnimatedShow: hasAnimatedShow,
                isAnimating: isAnimating
            };
        }
    };
})(jQuery);