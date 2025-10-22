<?php
/**
 * Template Name: Wine Page
 * Template for displaying wine list
 */
get_header();
?>

<main id="primary" class="site-main wine-page">
    <?php get_template_part('template-parts/pages/wine/hero') ?>
    <?php get_template_part('template-parts/pages/wine/list-categories') ?>
    <?php get_template_part('template-parts/pages/wine/wines') ?>
</main>
<?php
get_footer();