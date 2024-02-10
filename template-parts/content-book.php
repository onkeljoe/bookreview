<?php
/**
 * Template part for displaying book posts
 *
 * @package Book_Review
 */

?>

<article id="post-<?php the_ID(); ?>">
	<section <?php post_class(); ?>>

	<!-- div class="entry-block" -->

		<header class="entry-header">
			<?php bookreview_post_thumbnail(); ?>
			<?php bookreview_comments_badge(); ?>
			<?php bookreview_entry_title(); ?>
			<?php bookreview_entry_meta(); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php bookreview_entry_content(); ?>
		</div><!-- .entry-content -->

	</section>
<!-- /div><!- .entry-block -->

</article><!-- #post-<?php the_ID(); ?> -->
