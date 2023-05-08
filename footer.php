<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<footer class="site-footer">
    <nav class="primary-navigation wrapper">
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer-menu',
                'container' => '',
                'menu_class' => 'footer-menu-wrapper',
            )
        );
        ?>
    </nav>
    <p class="copyright">&copy; 2023 - <?php echo date('Y'); ?> <?php bloginfo('name'); ?> All Rights Reserved.</p>
</footer>

<?php wp_footer(); ?>
</body>

</html>