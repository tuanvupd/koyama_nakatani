<?php 
    $about = nkt_translate('about', 'home');
?>
<section class="nkt-about section-relative nkt-bg-image">
    <div class="nkt-about-warp"> 
        <div class="nkt-about-thumbanil"> 
            <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/image-ab-ss.jpg" alt="logo site on hero"/>
        </div>
        <div class="nkt-about-content">
            <?php if(!empty($about['heading'])): ?>
                <h2> <?= $about['heading'] ?> </h2>
            <?php endif; ?>    

            <?php if(!empty($about['subHeading'])): ?>
                <p class="sub-heading"> <?= $about['subHeading'] ?> </p>
            <?php endif; ?>   

            <div class="content"> 
                <?php 
                    if (!empty($about['content']) && is_array($about['content'])) {
                        foreach ($about['content'] as $paragraph) {
                            echo '<p>' . esc_html($paragraph) . '</p>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="nkt-about_carousel swiper">
        <div class="swiper-wrapper">
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <div class="swiper-slide nkt-hero__slide">
                    <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/image-ab-carousel-<?= sprintf('%03d', $i) ?>.jpg" alt="image slider <?= sprintf('%02d', $i) ?>"/>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>