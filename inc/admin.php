<?php 

function remove_editor_from_post_and_page() {
    remove_post_type_support('page', 'editor');
}
add_action('admin_init', 'remove_editor_from_post_and_page');