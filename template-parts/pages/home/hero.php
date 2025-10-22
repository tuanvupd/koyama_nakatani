<?php
    $hero = nkt_translate('hero', 'home');
?>
<section class="nkt-hero section-fixed">
    <div class="nkt-hero__slider swiper">
        <div class="swiper-wrapper">
            <?php for ($i = 1; $i <= 6; $i++): ?>
                <div class="swiper-slide nkt-hero__slide">
                    <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/img-slider-<?= sprintf('%03d', $i) ?>.jpg" alt="image slider <?= sprintf('%02d', $i) ?>"/>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    
    <?php nktReservation() ?>

    <div class="nkt-hero__content w-100"> 
        <div class="container"> 
            <?php if(!empty($hero['subHeading'])): ?>
                <h1 class="text-center"> <?= $hero['subHeading'] ?> </h1>
            <?php endif;?>    

            <div class="nkt-hero__logo text-center"> 
                <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/logo-hero.png" alt="logo site on hero"/>
            </div>
        </div>
    </div>

    <?php nkt_arrow_effect() ?>
</section>