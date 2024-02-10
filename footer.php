<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Book_Review
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
				<a href="https://wordpress.org/">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Proudly powered by %s', 'bookreview' ), 'WordPress' );
					?>
				</a>
				<span class="sep"> | </span>
					<?php
					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( 'Theme: %1$s by %2$s.', 'bookreview' ), 'bookreview', '<a href="https://onkeljoe.de">Johannes Heinemann</a>' );
					?>
		</div><!-- .site-info -->
		<?php
			wp_nav_menu( array(
				'theme_location' 	=> 'foot-nav',
				'menu_id'        	=> 'bottom-menu',
				'container_class'	=> 'menu-bar',
				'depth'				=> 1,
			) );
		?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
