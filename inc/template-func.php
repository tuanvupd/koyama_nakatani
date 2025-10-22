<?php

function nkt_arrow_effect(){ ?>
    <div class="nkt-arrow-effect"> 
        <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/image-arrow.png" alt="icon arrow srcoll"/>
        <span>Scroll</span>
    </div>
<?php }

function nakatani_post_item()
{
    $date = get_the_date('F j, Y');
    $categories = get_the_category();
    $external_link = get_field('external_link', get_the_ID());
    $external_url = get_field('external_url', get_the_ID());
    if ($external_link) {
        $link_post = $external_url;
        $target = '_blank';
    } else {
        $link_post = get_permalink();
        $target = '_self';
    }

    ?>
    <div class="item-post">
        <div class="item-post__thumbnail">
            <a href="<?= esc_url($link_post) ?>" target="<?= $target ?>" class="d-flex">
                <?php the_post_thumbnail('full'); ?>

                <?php if ($external_link && !empty($external_url)): ?>
                    <span class="item-post__thumbnail--badge">Social Share</span>
                <?php endif; ?>
            </a>
        </div>

        <h3 class="d-flex">
            <a href="<?= esc_url($link_post) ?>" target="<?= $target ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="item-post-meta d-flex align-items-center">
            <p class="item-post__date d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8" fill="none">
                    <circle cx="4" cy="4.00012" r="4" fill="#1EACD4" />
                </svg>
                <?= $date ?>
            </p>

            <?php if (!empty($categories)): ?>
                <div class="item-post__cate d-flex align-items-center">
                    <?php foreach ($categories as $value): ?>
                        <div class="item-cate d-flex align-items-center <?= $value->slug ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8" fill="none">
                                <circle cx="4" cy="4.00012" r="4" fill="#1EACD4" />
                            </svg>
                            <?= $value->name ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="item-post__excerpt" style="-webkit-box-orient:vertical"> <?= get_the_excerpt() ?> </div>

        <a href="<?= esc_url($link_post) ?>" target="<?= $target ?>" class="d-flex align-items-center item-post__btn">
            READ MORE
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                    d="M4 12.0001H16.25L11 6.75012L11.66 6.00012L18.16 12.5001L11.66 19.0001L11 18.2501L16.25 13.0001H4V12.0001Z"
                    fill="#1EACD4" />
            </svg>
        </a>
    </div>
<?php }

function nktReservation(){
    $information  = get_field('information_ft', 'option') ? : '';
    $tel          = (!empty($information) && $information['tel']) ?  $information['tel']: '';
    $reservation  = nkt_translate('reservation', 'reservation');
    // echo "<pre>";
    // echo print_r($reservation);
    // echo "</pre>";
?>
    <?php if(!empty($reservation) || !empty($tel)): ?>
        <div class="nkt-reservation"> 
            <div class="nkt-reservation-inner"> 
                <?php if(!empty($reservation['label'])):?>
                    <p class="nkt-reservation__title w-100"> <?= $reservation['label'] ?> </p>
                <?php endif; ?>

                <p class="nkt-reservation__phone w-100">
                    tel:<a href="tel:<?= $tel ?>"> <?= $tel ?> </a>
                </p>

                <?php if(!empty($reservation['ctaText'])):?>
                    <div class="btn btn-open-modal-book"> <?= $reservation['ctaText'] ?> </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php }