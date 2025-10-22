<?php 
    $profile = nkt_translate('profile', 'home');
?>
<section class="nkt-profile section-relative">
    <div class="nkt-profile-warp"> 
        <div class="nkt-profile__thumbnail"> 
            <img src="<?= TEMPLATE_DIRECTORY_URL ?>/assets/images/home/img-profile.jpg" alt="img-profile"/>
        </div>

        <div class="nkt-profile__content"> 
            <h2><?= $profile['lable'] ?></h2>
            <p class="name"> <?= $profile ['name'] ?> </p>
            <div class="profile-bio">
                <p class="bio-part1"><?= esc_html($profile['bio']['part1']) ?></p>
                <div class="bio-group">
                    <p class="bio-part2a"><?= esc_html($profile['bio']['part2a']) ?></p>
                    <p class="bio-part2b"><?= esc_html($profile['bio']['part2b']) ?></p>
                </div>
                <p class="bio-part3 highlight"><?= esc_html($profile['bio']['part3']) ?></p>
            </div>
        </div>
    </div>
</section>