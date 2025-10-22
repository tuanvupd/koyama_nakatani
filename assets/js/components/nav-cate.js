(function($) {
    'use strict';
    
    let hasAnimatedHide = false;
    let hasAnimatedShow = true;
    let isAnimating = false;
    let originalHeight = 0;
    let minimizedHeight = 0;
    
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
        
        $(window).on('scroll', function() {
            if (isAnimating) return;
            
            const scrollTop = $(window).scrollTop();
            const scrollDirection = scrollTop > lastScrollTop ? 'down' : 'up';
            lastScrollTop = scrollTop;
            
            const sectionOffset = $section.offset().top;
            const stickyStartPoint = sectionOffset + stickyTop;
            const isInStickyPosition = scrollTop >= stickyStartPoint;
            
            // SCROLL UP -> HIDE
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
        });
        
        // Recalculate on resize
        $(window).on('resize', function() {
            if (!isMobile()) return;
            calculateHeights($list, $cateItems, $thumbnails);
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

    $(document).ready(function() {
        if (typeof gsap !== 'undefined') {
            initCategoryScroll();
        }
    });
    
})(jQuery);