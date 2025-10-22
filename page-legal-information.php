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
        <?php nktReservation() ?>
        <div class="container"> 
            <div class="ntk-hero-content"> 
                <?php if(!empty($heading)): ?>
                    <h1> <?= $heading ?> </h1>
                <?php endif; ?>  
                
                <?php if(!empty($subHd)): ?>
                    <p class="sub-heading"> <?= $subHd ?> </p>
                <?php endif; ?>   

                <div class="warp"> 
                    <?php foreach ($contents as $key => $content): ?>
                        <div class="group-content"> 
                            <h2> <?= $key + 1 ?>. <?= $content['title'] ?> </h2>
    
                            <?php foreach ($content['content'] as $key => $paragraph): ?>
                                <p> <?= $paragraph ?> </p>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();