<?php
/**
 * Custom template tags for this theme
 *
 * @package Book_Review
 */

if ( ! function_exists( 'bookreview_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function bookreview_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'bookreview' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'bookreview_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function bookreview_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'bookreview' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'bookreview_categories_list' ) ) :
	/**
	 * Prints HTML with categories list
	 */
	function bookreview_categories_list() {
		if ( 'post' === get_post_type() || 'book' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'bookreview' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"><strong>' . __( 'Posted in ', 'bookreview' ) .'</strong>' . $categories_list . '</span>', $categories_list );
			}
		}
	}
endif;

if ( ! function_exists( 'bookreview_tag_list' ) ) :
	/**
	 * Prints HTML with tag list
	 */
	function bookreview_tag_list() {
		if ( 'post' === get_post_type() || 'book' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'bookreview' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links"><strong>' . __( 'Tagged ', 'bookreview' ) . '</strong>' . $tags_list . '</span>' );
			}
		}
	}
endif;

if ( ! function_exists( 'bookreview_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function bookreview_entry_footer() {
		bookreview_categories_list();
		bookreview_tag_list();

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'bookreview' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'bookreview' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'bookreview_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function bookreview_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'bookreview_user_thumbnail' ) ) :
	/**
	 * Displays User Image
	 * If no User Image defined, defaults to gravatar
	 */
	function bookreview_user_thumbnail() {
		if ( post_password_required() || is_attachment() ) {
			return;
		}

		$author_id = get_the_author_meta('ID');
		$author_image = get_field('author_image_link', 'user_'. $author_id );

		if ( ! $author_image ) {
			$author_image = get_avatar( $author_id, 150 ); 
		} else {
			$author_image = wp_get_attachment_image( $author_image, 'thumbnail');
		}
		echo ($author_image);
	}
endif;

if ( ! function_exists( 'bookreview_comments_badge' ) ) :
	/**
	 * Gets Book Infos from custom fields
	 */
	function bookreview_comments_badge() {
		if ( 'book' != get_post_type() && 'post' != get_post_type() ) {
			return;
		}?>
		<div class="comments-badge">
			<a href="<?php comments_link(); ?>">
				<i class="fas fa-comments"></i>
				<?php echo get_comments_number(); ?>
			</a>	
		</div><!-- .comments-badge -->
	<?php 
	} 
endif;

if ( ! function_exists( 'bookreview_entry_title' ) ) :
	/**
	 * wraps title in html tags accoding to singular view
	 */
	function bookreview_entry_title() {
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		endif;
	}
endif;

if ( ! function_exists( 'bookreview_entry_meta' ) ) :
	/**
	 * Gets Meta Data for post or book
	 */
	function bookreview_entry_meta() {
		?>
		<div class="entry-meta">
			<p>
				<?php bookreview_book_shortinfo(); ?>
				<?php if ( ! is_single() ) : ?>
					<?php bookreview_categories_list(); ?><br>
					<?php bookreview_tag_list(); ?><br>
					<?php bookreview_posted_on(); bookreview_posted_by(); ?>
				<?php endif; ?>
			</p>
		</div><!-- .entry-meta -->
	<?php }
endif;

if ( ! function_exists( 'bookreview_entry_content' ) ) :
	/**
	 * prints content including read more and pagination
	 */
	function bookreview_entry_content() {
		if ( is_singular() ) :
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'bookreview' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );
		else :
			the_excerpt();
		endif;

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bookreview' ),
			'after'  => '</div>',
		) );
	}
endif;

if ( ! function_exists( 'bookreview_book_shortinfo' ) ) :
	/**
	 * Gets Book Infos from custom fields
	 */
	function bookreview_book_shortinfo() {
		if ( 'book' != get_post_type() ) {
			return;
		} ?>
		<strong><?php _e( 'title', 'bookreview'); ?>: </strong><?php echo esc_html( get_field('title') ); ?><br>
		<strong><?php _e( 'author', 'bookreview'); ?>: </strong><?php echo esc_html( get_field('author') ); ?><br>
	<?php }
endif;

if ( ! function_exists( 'bookreview_book_datatable' ) ) :
	/**
	 * Show Book Data-Table from Custom Fields
	 */
	function bookreview_book_datatable() {
		if ( 'book' != get_post_type() ) {
			return;
		} 
		$translator = get_field('translator');
		$isbn = get_field('isbn');
		$published = get_field('published');
		$orig = get_field('originally_published');
		$edition = get_field('edition');
		$media = get_field('media_type');
		$pages = get_field('pages');
		$dewey = get_field('dewey_classification');
		$format = '';
		if ( $media ) $format.=$media.", ";
		if ( $pages ) $format.=$pages." ".__('pages', 'bookreview');
		
		?>
		<div class="entry-datatable">
			<table>
				<tr><th><?php _e( 'title', 'bookreview'); ?></th><td><?php echo esc_html( get_field('title') ); ?></td></tr>
				<tr><th><?php _e( 'author', 'bookreview'); ?></th><td><?php echo esc_html( get_field('author')); ?></td></tr>
				<?php if ( $translator ) : ?>
					<tr><th><?php _e( 'translator', 'bookreview'); ?></th><td><?php echo esc_html( $translator ); ?></td></tr>
				<?php endif; ?>
				<?php if ( $isbn ) : ?>
					<tr><th><?php _e( 'isbn', 'bookreview'); ?></th><td><?php echo esc_html( $isbn ) ?></td></tr>
				<?php endif; ?>
				<?php if ( $published ) : ?>
					<tr><th><?php _e( 'published', 'bookreview'); ?></th><td><?php echo esc_html( $published ) ?></td></tr>
				<?php endif; ?>
				<?php if ( $orig ) : ?>
					<tr><th><?php _e( 'originally published', 'bookreview'); ?></th><td><?php echo esc_html( $orig ) ?></td></tr>
				<?php endif; ?>
				<?php if ( $edition ) : ?>
					<tr><th><?php _e( 'edition', 'bookreview'); ?></th><td><?php echo esc_html( $edition ) ?></td></tr>
				<?php endif; ?>
				<?php if ( $format ) : ?>
					<tr><th><?php _e( 'format', 'bookreview'); ?></th><td><?php echo esc_html( $format ) ?></td></tr>
				<?php endif; ?>
				<?php if ( $dewey ) : ?>
					<tr><th><?php _e( 'Dewey classification', 'bookreview'); ?></th><td><?php echo esc_html( $dewey ) ?></td></tr>
				<?php endif; ?>
			</table>
		</div>
	<?php
	}
endif;

if ( ! function_exists( 'bookreview_rating' ) ) :
	/**
	 * Show rating stars
	 */
	function bookreview_rating() {
		if ( 'book' != get_post_type() ) {
			return;
		}
		$rating 		= get_field('rating_percentage');
		$half 			= $rating%20;
		$full 			= ($rating-$half)/20;
		$half 			= $half>0 ? 1 : 0;
		$empty 			= 5-$full-$half;
		$ratingstars	= '';

		for ($i=0; $i < $full; $i++) { 
			$ratingstars .= '<i class="fas fa-star"></i>';
		}
		if ( $half ) {
			$ratingstars .= '<i class="fas fa-star-half-alt"></i>';
		}
		for ($i=0; $i < $empty; $i++) { 
			$ratingstars .= '<i class="far fa-star"></i>';
		} ?>
		<div class="review">
			<p><?php echo $ratingstars; ?></p>
		</div>
	<?php }
endif;
?>