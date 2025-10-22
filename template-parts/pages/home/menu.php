<?php
    $menu        = nkt_translate('menu', 'home');
    $lunch       = $menu['lunch'] ? : '';
    $dinner      = $menu['dinner'] ? : '';
    $seller_book = $menu['sellerBook'] ? : '';
?>
<section id='menu' class="nkt-menu section-relative">
    <div class="container"> 
        <h2 id="menu" class="text-center"> <?= $menu['label'] ?> </h2>
    </div>

    <?php if(!empty($lunch)): ?>
        <div class="nkt-menu__lunch w-100"> 
            <div class="nkt-menu__lunch-bg nkt-bg"> 
                <img class="d-none d-md-block" src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/bg-menu-section.jpg" alt="bg-menu-lunch"/>
                <img class="d-md-none d-block" src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/image-mb-001.jpg" alt="bg-menu-lunch"/>
            </div>

            <div class="nkt-menu__lunch-warp warp"> 
                <div class="content"> 
                    <h3> <?= $lunch['label'] ?>  </h3>
                    <p class="course"> <?= $lunch['course'] ?> </p>
                    <p class="origin_note"> <?= $lunch['origin_note'] ?> </p>
                    <p class="price"> <?= $lunch['price'] ?> </p>
                </div>
            </div>
        </div>
    <?php endif;?> 

    <?php if(!empty($dinner)): ?>
        <div class="nkt-menu__dinner w-100"> 
            <div class="nkt-menu__dinner-bg nkt-bg"> 
                <img class="d-none d-md-block" src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/bg-menu-lunch.jpg" alt="bg-menu-lunch"/>
                <img class="d-md-none d-block" src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/image-mb-002.jpg" alt="bg-menu-lunch"/>
            </div>

            <div class="nkt-menu__dinner-warp warp"> 
                <div class="content"> 
                    <h3> <?= $dinner['label'] ?>  </h3>
                    <p class="course"> <?= $dinner['course'] ?> </p>
                    <p class="origin_note"> <?= $dinner['origin_note'] ?> </p>
                    <p class="price"> <?= $dinner['price'] ?> </p>
                </div>
            </div>
        </div>
    <?php endif;?>   

    <?php if(!empty($seller_book)): ?>
        <div class="nkt-menu__sb w-100"> 
            <div class="nkt-menu__sb-bg nkt-bg"> 
                <img class="d-none d-md-block" src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/bg-seller-book.jpg" alt="bg-menu-lunch"/>
                <img class="d-md-none d-block" src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/image-mb-003.jpg" alt="bg-menu-lunch"/>
            </div>

            <div class="nkt-menu__sb-warp warp"> 
                <div class="content"> 
                    <h3> <?= $seller_book['label'] ?>  </h3>
                    <p class="origin_note"> <?= $seller_book['origin_note'] ?> </p>
                    <a href="<?= $seller_book['btnLink'] ?>"> 
                        <?= $seller_book['btnText'] ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endif;?> 

</section>