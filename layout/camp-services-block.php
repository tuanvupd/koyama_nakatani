<?php

/**
 * Flexible Layout: Camp Services Block
 */

$heading = get_sub_field('heading');
$note_service = get_sub_field('note_service');
$bg_color = get_sub_field('bg_color');
$additional_classes = get_sub_field('additional_classes');
$services = get_sub_field('services');
?>

<div class="camp-services-block <?= 'bg-' . $bg_color . ' ' . $additional_classes; ?>">
    <div class="container">
        <?php if ($heading) { ?>
            <h2 class="camp-services-block__heading"> <?= $heading; ?></h2>
        <?php } ?>

        <?php if ($services) { ?>
            <div class="camp-services-block__list">
                <?php foreach ($services as $item) { ?>
                    <div class="camp-services-block__item">
                        <div class="camp-services-block__item--icon">
                            <img src="<?= $item['icon']; ?>" alt="<?= $item['title']; ?>">
                        </div>

                        <div class="camp-services-block__item--content">
                            <?php if ($item['title']) { ?>
                                <div class="camp-services-block__item--title">
                                    <?= $item['title']; ?>
                                </div>
                            <?php } ?>

                            <?php if ($item['time']) { ?>
                                <div class="camp-services-block__item--time">
                                    <?= $item['time']; ?>
                                </div>
                            <?php } ?>

                            <?php if ($item['description']) { ?>
                                <div class="camp-services-block__item--description">
                                    <?= $item['description']; ?>
                                </div>
                            <?php } ?>
                            <?php if ($item['cta_link']) { ?>
                                <a href="<?= $item['cta_link']['url']; ?>" target="<?= $item['cta_link']['target']; ?>"
                                    class="camp-services-block__item--cta">
                                    <?= $item['cta_link']['title']; ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M4 12H16.25L11 6.75L11.66 6L18.16 12.5L11.66 19L11 18.25L16.25 13H4V12Z"
                                            fill="#1EACD4" />
                                    </svg>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($note_service) { ?>
            <div class="camp-services-block__note">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <path
                        d="M16 22C16.1902 22 16.3489 21.936 16.476 21.808C16.6031 21.68 16.6667 21.5218 16.6667 21.3333V15.3333C16.6667 15.144 16.6027 14.9858 16.4747 14.8587C16.3467 14.7316 16.188 14.6676 15.9987 14.6667C15.8093 14.6658 15.6511 14.7298 15.524 14.8587C15.3969 14.9876 15.3333 15.1458 15.3333 15.3333V21.3333C15.3333 21.5227 15.3973 21.6809 15.5253 21.808C15.6533 21.9351 15.812 21.9991 16.0013 22M16 12.7693C16.2329 12.7693 16.428 12.6907 16.5853 12.5333C16.7427 12.376 16.8209 12.1813 16.82 11.9493C16.8191 11.7173 16.7404 11.5222 16.584 11.364C16.4276 11.2058 16.2329 11.1271 16 11.128C15.7671 11.1289 15.5724 11.2076 15.416 11.364C15.2596 11.5204 15.1809 11.7156 15.18 11.9493C15.1791 12.1831 15.2578 12.3778 15.416 12.5333C15.5742 12.6889 15.7689 12.7676 16 12.7693ZM16.004 28C14.3444 28 12.7844 27.6853 11.324 27.056C9.86356 26.4258 8.59289 25.5707 7.512 24.4907C6.43111 23.4107 5.57556 22.1413 4.94533 20.6827C4.31511 19.224 4 17.6644 4 16.004C4 14.3436 4.31511 12.7836 4.94533 11.324C5.57467 9.86356 6.42844 8.59289 7.50667 7.512C8.58489 6.43111 9.85467 5.57556 11.316 4.94533C12.7773 4.31511 14.3373 4 15.996 4C17.6547 4 19.2147 4.31511 20.676 4.94533C22.1364 5.57467 23.4071 6.42889 24.488 7.508C25.5689 8.58711 26.4244 9.85689 27.0547 11.3173C27.6849 12.7778 28 14.3373 28 15.996C28 17.6547 27.6853 19.2147 27.056 20.676C26.4267 22.1373 25.5716 23.408 24.4907 24.488C23.4098 25.568 22.1404 26.4236 20.6827 27.0547C19.2249 27.6858 17.6653 28.0009 16.004 28ZM16 26.6667C18.9778 26.6667 21.5 25.6333 23.5667 23.5667C25.6333 21.5 26.6667 18.9778 26.6667 16C26.6667 13.0222 25.6333 10.5 23.5667 8.43333C21.5 6.36667 18.9778 5.33333 16 5.33333C13.0222 5.33333 10.5 6.36667 8.43333 8.43333C6.36667 10.5 5.33333 13.0222 5.33333 16C5.33333 18.9778 6.36667 21.5 8.43333 23.5667C10.5 25.6333 13.0222 26.6667 16 26.6667Z"
                        fill="#1EACD4" />
                </svg>
                <?= $note_service; ?>
            </div>
        <?php } ?>
    </div>
</div>