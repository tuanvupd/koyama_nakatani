<?php
/**
 * The template for displaying single posts
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @package nakatani
 */

get_header();
?>
<div class="container wysiwyg-editor wysiwyg-editor-post">
    <?php
    while (have_posts()):
        the_post();
        the_content();
    endwhile; 
    ?>
</div>
<?php
get_footer();