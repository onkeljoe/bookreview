<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Book_Review
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'bookreview' ); ?></a>

	<header id="masthead" class="site-header">
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<i class="fas fa-bars"></i>
			</button>
			<?php
			wp_nav_menu( array(
				'theme_location' 	=> 'head-nav',
				'menu_id'        	=> 'primary-menu',
				'container_class'	=> 'menu-bar',
				'depth'				=> 2,
			) );
			?>
		</nav><!-- #site-navigation -->
		
		<!-- No Branding on singular pages -->
		<?php if ( ! is_singular() ) { ?>
			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) {
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				} else {
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				}
				$bookreview_description = get_bloginfo( 'description', 'display' );
				if ( $bookreview_description || is_customize_preview() ) {
					?>
					<p class="site-description"><?php echo $bookreview_description; /* WPCS: xss ok. */ ?></p>
				<?php } ?>
			</div><!-- .site-branding -->
		<?php } ?>

		
	</header><!-- #masthead -->

	<div id="content" class="site-content">
