<?php
/**
 * Template Name: Legal Information
 */
get_header();
$heading  = nkt_translate('heading', 'legal-information');
$subHd    = nkt_translate('subHd', 'legal-information');
$contents = nkt_translate('content', 'legal-information');
?>

<main id="primary" class="site-main legal-information-page">
    <div class="ntk-hero"> 
        <?php nktReservation(); ?>
        <div class="container"> 
            <div class="ntk-hero-content"> 
                <?php if (!empty($heading)): ?>
                    <h1><?php echo esc_html($heading); ?></h1>
                <?php endif; ?>  
                
                <?php if (!empty($subHd)): ?>
                    <p class="sub-heading"><?php echo esc_html($subHd); ?></p>
                <?php endif; ?>   

                <div class="warp"> 
                    <?php foreach ($contents as $key => $content): ?>
                        <div class="group-content"> 
                            <h2><?php echo esc_html($content['title']); ?></h2>
                            <?php foreach ($content['content'] as $pKey => $paragraph): ?>
                                <p><?php echo wp_kses_post($paragraph); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
