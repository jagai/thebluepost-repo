<?php
/**
 * default search form
 */
?>
<form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">
        <input type="text" name="s" class="form-control" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'neovantage'); ?>" value="<?php echo get_search_query(); ?>">
        <span class="input-group-addon">
            <button class="btn btn-default" type="submit">
                <span class="fa fa-search"></span>
            </button>  
        </span>
    </div>
</form>