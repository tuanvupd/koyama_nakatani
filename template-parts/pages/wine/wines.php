<?php 
// Get all wine categories
$wine_categories = get_terms([
    'taxonomy' => 'category-wine',
    'hide_empty' => true,
]);
?>

<?php if(!empty($wine_categories)): ?>
    <section class="nkt-wines section-relative">
        <?php foreach ($wine_categories as $category) : ?>
            <?php ntk_group_cate_post($category); ?>
        <?php endforeach; ?>    
    </section>    
<?php endif; ?>

<?php function ntk_group_cate_post($category){ 
    $image    = get_field('bg_cate_wine', 'category-wine_' . $category->term_id);
    $bg_style = $image ? 'background-image: url(' . esc_url($image) . ')' : 'background-color: #5d442c';
    $classed  = $image ? 'nkt-bg-image' : '';
?>
    <div id="cate-group-<?= esc_attr($category->slug) ?>" class="cate-group"> 
        <div class="cate-group-top <?php echo esc_attr($classed); ?>" style="<?php echo esc_attr($bg_style); ?>"> 
            <h2 id="section-<?php echo esc_attr($category->slug); ?>" class="text-center">
                <?php echo esc_html($category->name); ?>
            </h2>
        </div>
        <div class="cate-group-bottom"> 
            <?php get_all_wine_by_cate($category); ?>
        </div>
    </div>
<?php } ?>

<?php function get_all_wine_by_cate($category){ 
    // Get all wines in this category first
    $wines_in_category = new WP_Query([
        'post_type' => 'wine',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'category-wine',
                'field' => 'term_id',
                'terms' => $category->term_id,
            ]
        ],
        'orderby' => 'title',
        'order' => 'ASC'
    ]);

    // Group wines by their type
    $wines_by_type = [];
    $wines_without_type = [];

    if ($wines_in_category->have_posts()) {
        $post_ids = wp_list_pluck($wines_in_category->posts, 'ID');
        
        
        while ($wines_in_category->have_posts()) {
            $wines_in_category->the_post();
            $post_id = get_the_ID();
            
            // Get wine types for this post
            $wine_types = get_the_terms($post_id, 'type-wine');
            
            if ($wine_types && !is_wp_error($wine_types)) {
                foreach ($wine_types as $wine_type) {
                    if (!isset($wines_by_type[$wine_type->term_id])) {
                        $wines_by_type[$wine_type->term_id] = [
                            'type' => $wine_type,
                            'wines' => []
                        ];
                    }
                    $wines_by_type[$wine_type->term_id]['wines'][] = [
                        'title' => get_the_title(),
                        'ID' => $post_id,
                    ];
                }
            } else {
                // If no type, add to wines_without_type array
                $wines_without_type[] = [
                    'title' => get_the_title(),
                    'ID' => $post_id,
                ];
            }
        }
    }
    wp_reset_postdata();

    // Sort types by name
    uasort($wines_by_type, function($a, $b) {
        return strcmp($a['type']->name, $b['type']->name);
    });
?>
    <div class="cate-group__types d-flex flex-wrap align-content-start"> 
        <?php 
            // First, display wines grouped by type (posts WITH type)
            foreach ($wines_by_type as $type_group) : 
                $type = $type_group['type'];
                $wines = $type_group['wines'];
        ?>
            <?php get_all_wines_by_type($wines, $type); ?>
        <?php endforeach; ?>

        <?php if (!empty($wines_without_type)) : ?>
            <?php get_all_wines_not_type($wines_without_type); ?>
        <?php endif; ?>
    </div>
<?php } ?>

<?php function get_all_wines_by_type($wines, $type){ ?>
    <div class="type-group w-100"> 
        <h3 class="type-group__title"><?php echo esc_html($type->name); ?></h3>
        <div class="type-group__wines"> 
            <?php foreach ($wines as $wine) : ?>
                <?php wine_item($wine) ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php } ?>

<?php function get_all_wines_not_type($wines_without_type){ ?> 
    <div class="type-group not-type w-100">  
        <div class="type-group__wines">
            <?php foreach ($wines_without_type as $wine) : ?>
                <?php wine_item($wine) ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php } ?>


<?php function wine_item($wine){ 
    $producer = get_field( "producer_wine", $wine['ID'] );
    $vintage  = get_field( "vintage_wine", $wine['ID'] );
    $price    = get_field( "price_wine", $wine['ID'] );    
?>
    <div class="wine-item d-flex justify-content-between align-items-center">
        <h4 class="mb-0"> <?= esc_html($wine['title']); ?> </h4>

        <p class="producer mb-0 text-end"> 
            <?php if(!empty($producer)): ?>
                <?= esc_html( $producer) ?>
            <?php endif ?>    
        </p>
        
        <p class="vintage mb-0 text-end"> 
            <?php if(!empty($vintage)): ?>
                <?= esc_html( $vintage) ?> 
            <?php endif ?>
        </p>
    
        <p class="price mb-0 text-end"> 
            <?php if(!empty($price)): ?> <?= esc_html( $price) ?>€ <?php endif ?>
        </p>
        
    </div>
<?php } ?>