<div class="sidebar">
    <?php
    if ( is_single() ) {
        dynamic_sidebar( 'sidebar-single' ); // Sidebar за чланке
    } elseif ( is_page_template( 'template-frontpage.php' ) ) {
        dynamic_sidebar( 'blog' ); // Sidebar за насловну
    } elseif ( is_page() ) {
        dynamic_sidebar( 'page' ); // Sidebar за статичке странице
    } else {
        dynamic_sidebar( 'blog' ); // Подразумевани sidebar
    }
    ?>
</div>
