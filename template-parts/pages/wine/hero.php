<?php 
    $hero = nkt_translate('hero', 'wine-page');
    $sliders = [
        [
            'desktop' => '/assets/images/wine/slider-wine-001-min.jpg',
            'mobile'  => '/assets/images/wine/slider-wine-mb-001-min.jpg'
        ],
        [
            'desktop' => '/assets/images/wine/slider-wine-002-min.jpg',
            'mobile'  => '/assets/images/wine/slider-wine-mb-002-min.jpg'
        ],
        [
            'desktop' => '/assets/images/wine/slider-wine-003-min.jpg',
            'mobile'  => '/assets/images/wine/slider-wine-mb-003-min.jpg'
        ],
    ]
?>
<section class="nkt-hero section-fixed">
    <div class="nkt-hero__slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($sliders as $index => $slider): ?>
                <div class="swiper-slide nkt-hero__slide">
                    <img class="d-none d-md-block" src="<?= TEMPLATE_DIRECTORY_URL . $slider['desktop'] ?>" alt="Wine slider <?= $index + 1 ?>" />
                    <img class="d-md-none d-block" src="<?= TEMPLATE_DIRECTORY_URL . $slider['mobile'] ?>" alt="Wine slider mobile <?= $index + 1 ?>" />
                </div>
            <?php endforeach; ?>    
        </div>
    </div>

    <?php nktReservation() ?>

    <div class="nkt-hero__content w-100"> 
        <div class="container"> 
        <?php if(!empty($hero['heading'])): ?>
            <h1 class="text-center"> <?= $hero['heading'] ?> </h1>
        <?php endif;?>  
        </div>
    </div>

    <?php nkt_arrow_effect() ?>
</section>