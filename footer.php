<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package akuna
 */

?>

</div><!-- .col-full -->
</div><!-- #content -->

<?php do_action('akuna_before_footer'); ?>

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="col-full">

        <?php
        /**
         * Functions hooked into akuna_footer action
         *
         * @hooked akuna_footer_widgets - 10
         * @hooked akuna_credit         - 30
         */
        do_action('akuna_footer');
        ?>

    </div><!-- .col-full -->
</footer><!-- #colophon -->

<?php do_action('akuna_after_footer'); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>