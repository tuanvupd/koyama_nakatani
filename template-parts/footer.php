<?php 
    $copyright    = get_field('copyright_ft', 'option');
    $logo         = get_field('logo_footer', 'option');
    $socials      = get_field('socials_ft', 'option');
    $sub_text     = nkt_translate('sub-text', 'footer');
    $information  = get_field('information_ft', 'option');
    $work_hours   = nkt_translate('work_hours', 'footer');
    $payment      = nkt_translate('payment', 'footer');
    $closed_days = nkt_translate('closed_days', 'footer');
    $lunch       = nkt_translate('lunch', 'footer');
    $dinner      = nkt_translate('dinner', 'footer');
    $heading     = nkt_translate('heading', 'footer');
    $address     = nkt_translate('address', 'footer');
    $map         = nkt_translate('map', 'footer');
?>

<footer class="main-footer">
    <div class="main-footer-top w-100"> 
        <div class="main-footer-top__bg"> 
            <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/bg-top-footer.jpg" alt="bg-footer-top"/>
        </div>
        <div class="container"> 
            <h2 id="contact"><?= $heading ?></h2>

            <div class="main-footer-top-inner d-flex"> 
                <?php if(!empty($information)): ?>
                    <?php 
                        
                        $tel     = $information['tel'] ? : '';
                        $fax     = $information['fax'] ? : '';
                        $email   = $information['email'] ? : '';
                        $classed = 'info-item w-100 d-flex align-items-center';
                    ?>
                    <div class="main-footer__information d-flex flex-wrap"> 
                        <?php if(!empty($address)): ?>
                            <div class="<?=  $classed ?> address"> 
                                <div class="info-item__title">
                                    <span></span>
                                    <p><?= $address['label'] ?></p>
                                </div>

                                <p class="info-item__content"> 
                                   <?= $address['content'] ?>
                                </p>
                            </div>
                        <?php endif; ?>  
                        
                        <?php if(!empty($tel)): ?>
                            <div class="<?=  $classed ?> tel"> 
                                <div class="info-item__title">
                                    <span></span>
                                    <p>Tel</p>
                                </div>

                                <p class="info-item__content"> 
                                    <a href="tel:<?= $tel ?>"> <?= $tel ?> </a>
                                </p>
                            </div>
                        <?php endif; ?>  

                        <?php if(!empty($email)): ?>
                            <div class="<?=  $classed ?> email"> 
                                <div class="info-item__title">
                                    <span></span>
                                    <p>Email</p>
                                </div>

                                <p class="info-item__content"> 
                                    <a href="mailto:<?= $email ?>"> <?= $email ?> </a>
                                </p>
                            </div>
                        <?php endif; ?> 

                        <?php if(!empty($closed_days)): ?>
                            <div class="<?=  $classed ?> closed_days"> 
                                <div class="info-item__title">
                                    <span></span>
                                    <p><?= $closed_days['label'] ?></p>
                                </div>

                                <p class="info-item__content"> 
                                    <?= $closed_days['content'] ?>
                                </p>
                            </div>
                        <?php endif; ?> 

                        <?php if(!empty($lunch) || !empty($dinner)): ?>
                            <div class="<?=  $classed ?> closed_days"> 
                                <div class="info-item__title">
                                    <span></span>
                                    <p><?=$work_hours ?></p>
                                </div>

                                <div class="info-item__content"> 
                                    <?php if(!empty($lunch)): ?>
                                        <div class="item"> 
                                            <span class="w-100 d-flex"><?= $lunch['label'] ?></span>
                                            <span class="w-100 d-flex"> <?= $lunch['content'] ?> </span>
                                        </div>
                                    <?php endif;?>
                                    
                                    <?php if(!empty($dinner)): ?>
                                        <div class="item"> 
                                            <span class="w-100 d-flex"><?= $dinner['label'] ?></span>
                                            <span class="w-100 d-flex"> <?= $dinner['content'] ?> </span>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>    
                        <?php endif; ?> 

                        <?php if(!empty($payment)): ?>
                            <div class="<?=  $classed ?> payment"> 
                                <div class="info-item__title">
                                    <span></span>
                                    <p><?= $payment['label'] ?></p>
                                </div>

                                <p class="info-item__content"> 
                                    <?= $payment['content'] ?>
                                </p>
                            </div>
                        <?php endif; ?> 
                    </div>
                <?php endif;?>
                
                <div class="main-footer__map"> 
                    <iframe 
                        data-lang="<?= $map ?>" 
                        loading="lazy" 
                        src="https://maps.google.com/maps?q=27%20rue%20Pierre%20Leroux%2075007%20PARIS%20FRANCE&amp;t=m&amp;z=10&amp;output=embed&amp;iwloc=near&amp;hl=<?= $map ?>" 
                        title="27 rue Pierre Leroux 75007 PARIS FRANCE" 
                        aria-label="27 rue Pierre Leroux 75007 PARIS FRANCE">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="main-footer-bottom"> 
        <div class="container"> 
            <div class="main-footer-bottom-inner d-flex align-items-end flex-wrap flex-sm-nowrap"> 
                <div class="d-flex align-items-end"> 
                    <?php if($logo): ?>
                        <a href="/" class="main-footer__logo d-flex">
                            <img src="<?= $logo ?>" alt="logo footer">
                        </a>
                    <?php endif;?> 

                    <?php if ($socials): ?>
                        <ul class="main-footer__socials d-flex align-items-center p-0 m-0">
                            <?php foreach ($socials as $social) {
                                $icon_url = $social['icon'];
                                $icon_ext = pathinfo($icon_url, PATHINFO_EXTENSION);
                                $icon_path = str_replace(
                                    wp_get_upload_dir()['baseurl'], 
                                    wp_get_upload_dir()['basedir'], 
                                    $icon_url
                                );
                                ?>
                                <li class="main-footer__socials-item <?= $social['name'] ?>">
                                    <a href="<?= esc_url($social['link']) ?>" target="_blank" class="d-flex text-decoration-none">
                                        <?php if ($icon_ext === 'svg' && file_exists($icon_path)) : ?>
                                            <?php echo file_get_contents($icon_path); ?>
                                        <?php else: ?>
                                            <img src="<?= esc_url($icon_url) ?>" alt="<?= esc_attr($social['name']) ?>">
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="main-footer__menu"> 
                    <?php  get_template_part('template-parts/menu-content') ?>
                </div>                        
            </div>

            <?php if(!empty($sub_text)): ?>
                <div class="main-footer_sub-text"> 
                    <a href="<?= home_url('/legal-information/') ?>" class="legal-link" style="color: #fff !important; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'"><?= $sub_text ?> </a>
                </div>
            <?php endif;?>  

            <?php if ($copyright) { ?>
                <p class="main-footer__copyright"> <?= str_replace('{{YEAR}}', date('Y'), $copyright) ?></p>
            <?php } ?>
        </div>
    </div>
</footer>