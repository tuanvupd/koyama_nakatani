<?php
    $hero = nkt_translate('hero', 'home');
    $sliders = [
        [
            'desktop' => '/assets/images/home/img-hm-slider-001-min.jpg',
            'mobile'  => '/assets/images/home/img-hm-slider-mb-001-min.jpg'
        ],
        [
            'desktop' => '/assets/images/home/img-hm-slider-002-min.jpg',
            'mobile'  => '/assets/images/home/img-hm-slider-mb-002-min.jpg'
        ],
        [
            'desktop' => '/assets/images/home/img-hm-slider-003-min.jpg',
            'mobile'  => '/assets/images/home/img-hm-slider-mb-003-min.jpg'
        ],
        [
            'desktop' => '/assets/images/home/img-hm-slider-004-min.jpg',
            'mobile'  => '/assets/images/home/img-hm-slider-mb-004-min.jpg'
        ],
        [
            'desktop' => '/assets/images/home/img-hm-slider-005-min.jpg',
            'mobile'  => '/assets/images/home/img-hm-slider-mb-005-min.jpg'
        ],
        [
            'desktop' => '/assets/images/home/img-hm-slider-006-min.jpg',
            'mobile'  => '/assets/images/home/img-hm-slider-mb-006-min.jpg'
        ],
    ]
?>
<section class="nkt-hero section-fixed">
    <div class="nkt-hero__slider swiper">
        <div class="swiper-wrapper">
              <?php foreach ($sliders as $index => $slider): ?>
                <div class="swiper-slide nkt-hero__slide">
                    <img class="d-none d-md-block" src="<?= TEMPLATE_DIRECTORY_URL . $slider['desktop'] ?>" alt="home slider <?= $index + 1 ?>" />
                    <img class="d-md-none d-block" src="<?= TEMPLATE_DIRECTORY_URL . $slider['mobile'] ?>" alt="home slider mobile <?= $index + 1 ?>" />
                </div>
            <?php endforeach; ?> 
        </div>
    </div>

    
    <?php nktReservation() ?>

    <div class="nkt-hero__content w-100"> 
        <div class="container"> 
            <?php if(!empty($hero['subHeading'])): ?>
                <h1 class="text-center"> <?= $hero['subHeading'] ?> </h1>
            <?php endif;?>    

            <div class="nkt-hero__logo text-center"> 
                <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/logo-footer-mIN.png" alt="logo site on hero"/>
            </div>
        </div>
    </div>

    <?php nkt_arrow_effect() ?>
</section>