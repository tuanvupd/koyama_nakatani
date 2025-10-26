

(function ($) {
    "use strict";

    const nktLanguage = () => {
        const $languageSwitchers = $('.language-switcher-desktop');

        function initLanguageSwitcher() {
            $languageSwitchers.each(function() {
                const $switcher = $(this);
                const $dropdown = $switcher.find('.language-dropdown');
                const $languageItems = $switcher.find('.language-item');

            
                $switcher.on('click', function(e) {
                    e.stopPropagation(); 
                    $(this).toggleClass('has-show');
                });

                $(document).on('click', function(e) {
                    if (!$switcher.is(e.target) && $switcher.has(e.target).length === 0) {
                        $switcher.removeClass('has-show');
                    }
                });

                $languageItems.on('click', function(e) {
                    e.preventDefault();
                    const newLangName = $(this).text();
                    $switcher.find('.current-language').text(newLangName);
                    window.location.href = $(this).attr('href');
                });
            });
        }

        initLanguageSwitcher();
    };


    const nktInfoFooter = () => {
        let maxWidth = 0;

        $('.info-item__title').each(function() {
            var thisWidth = $(this).outerWidth(); 
            if (thisWidth > maxWidth) {
                maxWidth = thisWidth;
            }
        });
        $('.info-item__title').css('min-width', maxWidth + 'px');
    }

    const nktHeroSlider = () => {
        const swiper = new Swiper('.nkt-hero__slider', {
            loop: true,
            speed: 1000,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
        });
    }

    const nktaboutCarousel = () => {
        const swiper = new Swiper('.nkt-about_carousel', {
            loop: true,
            speed: 8000,
            effect: 'side',
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                375: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },

                768: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                },
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 24,
                },
                1600: {
                    slidesPerView: 7,
                    spaceBetween: 24,
                }
            }
        });
    }

    
    const nktScrollWineItem = () => { 
        $('.cate-item').on('click', function(e) {
            e.preventDefault();
            const $this = $(this);
            const targetSection = $this.data('cate');
            const $targetElement = $('#' + targetSection);
            
            if (!$targetElement.length) return;
            
            const headerHeight = $('header').outerHeight() || 80;
            const categoriesHeight = $('.nkt-list-categories__list').outerHeight() || 80;
            const targetPosition = $targetElement.offset().top - headerHeight -categoriesHeight - 90;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
            
            // Update active state
            $('.cate-item').removeClass('active');
            $this.addClass('active');
        });
    };


    const nktModalBook = () => {
        $('.btn-open-modal-book').on('click', function() {
            const modalHTML = `
                <div class="nkt-modal-book">
                    <div class="nkt-modal-book-content">
                        <button class="btn-close-modal-book">&times;</button>
                        <iframe src="https://widget.thefork.com/en/68c527f1-efb7-4c60-8005-86ffcff0a82e" frameborder="0"></iframe>
                    </div>
                </div>
            `;
        
            $('body').append(modalHTML);
        
            // Animation open
            setTimeout(() => {
                $('.nkt-modal-book').addClass('active');
                $('.nkt-modal-book-content').addClass('active');
            }, 10);
        
          
            $('.btn-close-modal-book, .nkt-modal-book').on('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });
    
        function closeModal() {
            $('.nkt-modal-book').removeClass('active');
            $('.nkt-modal-book-content').removeClass('active');
        
            setTimeout(() => {
                $('.nkt-modal-book').remove();
            }, 300);
        }
    }

    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }

    $(window).on('scroll', debounce(function() {
        var isSticky = $(window).scrollTop() > $('.nkt-list-categories').offset().top - 73;
        
        $('.nkt-list-categories, body').toggleClass('has-sticky', isSticky);
    }, 10));
    
    $(document).ready(function () {
       nktInfoFooter()
       nktLanguage()
       nktHeroSlider()
       nktaboutCarousel()
    //    nktScrollWineItem()
       nktModalBook()
    })
})(jQuery); 