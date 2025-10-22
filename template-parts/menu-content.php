
<?php 
    $menus = [
        'home',
        'menu',
        'wine',
        'access',
        'contact'
    ]
?>

<ul class="navbar-nav d-flex align-items-center p-0 m-0 navbar-nav">
    <?php foreach ($menus as $key): ?>
        <?php echo nkt_menu_item($key); ?>
    <?php endforeach; ?>
</ul>