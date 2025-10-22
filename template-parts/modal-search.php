<div id="search-box">
    <div class="container">
        <a class="close" href="#close"></a>
        <div class="search-main">
            <div class="search-inner">
                <form role="search" method="get" class="search-form" action="<?= home_url('/') ?>">
                    <input type="search" id="inputSearch" name="s" placeholder="" value="<?= get_search_query() ?>" name="s">
                    <span class="search-info">Hit enter to search or ESC to close</span>
                    <button type="submit" class="search-submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>