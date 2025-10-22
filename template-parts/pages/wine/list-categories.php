
<?php 
    $intro = nkt_translate('categories', 'wine-page');
    $wine_categories = get_terms([
        'taxonomy'   => 'category-wine',
        'hide_empty' => false,
    ]);

?>
<section class="nkt-list-categories section-relative nkt-bg-image">
    <div class="nkt-list-categories__intro text-center"> 
        <div class="container text-center"> 
            <?php if(!empty($intro['label'])): ?>
                <h2><?= $intro['label'] ?></h2>
            <?php endif; ?>

            <?php if(!empty($intro['tax_note'])): ?>
                <p><?= $intro['tax_note'] ?></p>
            <?php endif; ?>

            <?php if(!empty($intro['cta_text']) && !empty($intro['cta_link'])): ?>
                <a href="<?= $intro['cta_link'] ?>"> <?= $intro['cta_text'] ?> </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if(!empty($wine_categories) && !is_wp_error($wine_categories)): ?>
        <div class="nkt-list-categories__list container"> 
            <?php foreach ($wine_categories as $category) : ?>
                <?php  $thumbnail = get_field('thumbnail_cate_wine', 'category-wine_' . $category->term_id);
                
                    // echo "<pre>";
                    // echo print_r($thumbnail);
                    // echo "</pre>";
                ?>
                <div id="item-cate-<?= esc_attr($category->slug) ?>" class="cate-item" data-cate="section-<?= esc_attr($category->slug) ?>"> 
                    <?php if($thumbnail): ?>
                        <div class="cate-item__thumbnail text-center w-100">
                            <img src="<?= esc_url($thumbnail) ?>" alt="<?= esc_attr($category->name) ?>">
                        </div>
                    <?php endif; ?>

                    <h3 class="cate-item__title text-center w-100"><?= esc_html($category->name) ?></h3>

                    <div class="cate-item__arrow text-center w-100"> 
                        <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/wine/icon-arrow-wine.png" alt="icon-arrow"/>
                    </div>
                </div>
            <?php endforeach; ?>    
        </div>
    <?php endif; ?>    
    
</section>