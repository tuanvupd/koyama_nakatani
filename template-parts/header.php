<?php 
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_url       = wp_get_attachment_url($custom_logo_id);
    $button         = nkt_translate('button', 'header');
?>
<header id="site-header" class="header-main">
    <div class="container-fluid">
        <div class="header-main-inner d-flex justify-content-between align-items-center gap-3 w-100"> 
            <div class="header-main__logo"> 
                <?php
                if ($logo_url && str_ends_with($logo_url, '.svg')) {
                    $svg_path = get_attached_file($custom_logo_id);
                    if (file_exists($svg_path)) {
                        echo '<a href="'. home_url('/') .'" class="custom-logo-link">';
                        echo file_get_contents($svg_path);
                        echo '</a>';
                    }
                } elseif (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <h1 class="header__title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php } ?>
            </div>
            
            <div class="header-main__cta d-md-none d-flex justify-content-end align-items-center"> 
                <?php if(!empty($button)): ?>
                    <div class="cta-booking d-md-none d-flex flex-wrap btn-open-modal-book">
                        <?= $button ?>
                    </div>
                <?php endif; ?>

                <div class="btn-open-menu d-md-none d-flex flex-wrap"> 
                    <span class="line">  </span>
                    <span class="line">  </span>
                </div>
            </div>


            <div class="header-main-right d-none d-md-flex justify-content-end align-items-center"> 
                <div class="header-main__nav">
                    <?php get_template_part('template-parts/menu-content') ?>
                </div>   

                <div class="header-main__language"> 
                    <?php echo nkt_language_switcher(); ?>
                </div>
            </div>
        </div>


        <div class="header-mobile d-md-none"> 
            <div class="header-mobile-inner d-flex justify-content-between align-items-center gap-3"> 
                <div class="header-main__logo"> 
                    <?php
                    if ($logo_url && str_ends_with($logo_url, '.svg')) {
                        $svg_path = get_attached_file($custom_logo_id);
                        if (file_exists($svg_path)) {
                            echo '<a href="/" class="custom-logo-link">';
                            echo file_get_contents($svg_path);
                            echo '</a>';
                        }
                    } elseif (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <h1 class="header__title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                    <?php } ?>
                </div>

                <div class="btn-close-menu d-flex flex-wrap"> 
                    <span class="line"></span>
                    <span class="line"></span>
                </div>
            </div>

            <div class="header-mobile-content"> 
                <div class="header-main__nav">
                    <?php get_template_part('template-parts/menu-content') ?>
                </div>

                <div class="header-main__language"> 
                    <?php echo nkt_language_switcher_mobile(); ?>
                </div>

                <?php if(!empty($button)): ?>
                    <div class="cta-booking-menu-mb d-md-none d-flex flex-wrap btn-open-modal-book">
                        <?= $button ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>