<?php
/**
 * Template part for displaying results in search pages
 *
 * @package Book_Review
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php bookreview_post_thumbnail(); ?>
		<?php bookreview_comments_badge(); ?>
		<?php bookreview_entry_title(); ?>
		<?php bookreview_entry_meta(); ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-<?php the_ID(); ?> -->
