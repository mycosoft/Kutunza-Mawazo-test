<div id="apus-mobile-menu" class="apus-offcanvas hidden-lg"> 
    <div class="apus-offcanvas-body">
        <div class="offcanvas-head bg-primary">
            <a class="btn-toggle-canvas" data-toggle="offcanvas">
                <i class="ti-close"></i><span><?php esc_html_e( 'Close', 'travlio' ); ?></span>
            </a>
        </div>

        <nav class="navbar navbar-offcanvas navbar-static" role="navigation">
            <?php
                $args = array(
                    'theme_location' => 'primary',
                    'container_class' => 'navbar-collapse navbar-offcanvas-collapse',
                    'menu_class' => 'nav navbar-nav main-mobile-menu',
                    'fallback_cb' => '',
                    'menu_id' => '',
                    'walker' => new Travlio_Mobile_Menu()
                );
                wp_nav_menu($args);
            ?>
        </nav>
        
    </div>
</div>
<div class="over-dark"></div>