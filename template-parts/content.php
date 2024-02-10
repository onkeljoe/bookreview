<?php
/**
 * Template part for displaying posts
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

	<div class="entry-content">
		<?php bookreview_entry_content(); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
