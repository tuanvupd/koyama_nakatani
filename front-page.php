<?php
/**
 * Template Name: Homepage
 * Front Page Template
 */

get_header();
?>
    <main id="primary" class="site-main template-home">
        <?php get_template_part('template-parts/pages/home/hero') ?>
        <?php get_template_part('template-parts/pages/home/about') ?>
        <?php get_template_part('template-parts/pages/home/menu') ?>
        <?php get_template_part('template-parts/pages/home/profile') ?> 
    </main>
<?php
get_footer();