<?php
/**
 * The template for displaying single book-type posts
 *
 * @package Book_Review
 */

get_header();

while ( have_posts() ) : the_post(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<article id="post-<?php the_ID(); ?>">
				<section <?php post_class(); ?>>

					<?php bookreview_entry_title(); ?>
					<header class="entry-bookcard clear">
						<?php bookreview_post_thumbnail(); ?>
						<?php bookreview_comments_badge(); ?>
						<div class="entry-meta">
							<p><?php bookreview_book_shortinfo(); ?></p>
						</div>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php bookreview_entry_content(); ?>
					</div><!-- .entry-content -->
				</section>
                <?php if ( 'book' === get_post_type() ) : ?>
                    <section class="entry-data">
                        <?php bookreview_book_datatable(); ?>
                    </section>
                <?php endif; ?>

				<?php
				the_post_navigation(); 

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

			</article><!-- #post-<?php the_ID(); ?> -->
		</main><!-- #main -->
	</div><!-- #primary -->
	<aside id="meta-sidebar" class="widget-area">
		<section class="meta-widget">
			<h2><?php _e( 'Posted by' ); ?></h2>
			<figure class="user-thumbnail">
				<?php bookreview_user_thumbnail(); ?>
				<figcaption><?php the_author(); ?></figcaption>
			</figure>
		</section>
		<!-- If Rating exists, show widget -->
		<?php if ( get_post_meta( get_the_ID(), 'rating_percentage', true) ) : ?>
			<section class="meta-widget">
				<h2><?php _e( 'Rating' ); ?></h2>
				<?php bookreview_rating(); ?>
			</section>
		<?php endif; ?>
		<section class="meta-widget social">
			<h2><?php _e( 'Share this post' ); ?></h2>
			<p>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank">
					<i class="fab fa-facebook-square facebook"></i> Facebook
				</a>
			</p>
			<p>
				<a href="https://twitter.com/share?url=<?php echo esc_url( get_permalink() ); ?>" target="_blank">
					<i class="fab fa-twitter-square twitter"></i> Twitter
				</a>
			</p>
		</section>
		<section class="meta-widget">
			<h2><i class="far fa-folder-open"></i> <?php _e( 'Category' ); ?></h2>
			<?php the_category( '', 'single' ); ?>
		</section>
		<section class="meta-widget">
			<h2><i class="fas fa-tags"></i> <?php _e( 'Tagged with' ); ?></h2>
			<?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?>
		</section>
		<section class="meta-widget">
			<h2><?php _e( 'Recent Posts' ); ?></h2>
			<ul>
			<?php
				$args = array( 'numberposts' => '5' );
				$recent_posts = wp_get_recent_posts( $args );
				foreach( $recent_posts as $recent ){
					echo '<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
				}
				wp_reset_query();
			?>
			</ul>
		</section>
	</aside>
<?php 
endwhile; // End of the loop.

get_footer();