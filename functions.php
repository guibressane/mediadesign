<?php
/**
 * Function generate_add_footer_info rewrited
 */
if ( ! function_exists( 'generate_add_footer_info' ) ) {
add_action( 'generate_credits', 'generate_add_footer_info' );

function generate_add_footer_info() {
		$copyright = sprintf( '<div class="logo-icon"></div><br /><span class="copyright">%1$s &copy; %2$s</span> &bull; %4$s <a href="%3$s" itemprop="url">%5$s</a>',
			get_bloginfo( 'name' ),
			date( 'Y' ),
			esc_url( 'https://br.wordpress.org' ),
			_x( 'Criado com', 'WordPress', 'generatepress' ),
			__( 'WordPress', 'generatepress' )
		);

		echo apply_filters( 'generate_copyright', $copyright ); // WPCS: XSS ok.
	}
};

/**
 * Function post meta last updated
 */

function puresimple_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		__( 'Published on %s', 'generatepress' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'generatepress' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
}

/**
 * Functions generate post meta rewrited
 */

if ( ! function_exists( 'generate_post_meta' ) ) {
	add_action( 'generate_after_entry_title', 'generate_post_meta' );
	/**
	 * Build the post meta.
	 *
	 * @since 1.3.29
	 */
	function generate_post_meta() {
		$post_types = apply_filters( 'generate_entry_meta_post_types', array(
			'post',
		) );

		if ( in_array( get_post_type(), $post_types ) ) : ?>
				<div class="entry-meta">
				     <?php _e( 'Atualizado em ', 'generatepress' );  the_modified_date() ; ?>
				</div>
		<?php endif;
	}
}

/**
 * Functions generate post thumbnail rewrited
 */
if ( ! function_exists( 'generate_post_image' ) ) {
	add_action( 'generate_after_entry_header', 'generate_post_image' );
	/**
	 * Prints the Post Image to post excerpts
	 */
	function generate_post_image() {
		// If there's no featured image, return.
		if ( ! has_post_thumbnail() ) {
			return;
		}

		// If we're not on any single post/page or the 404 template, we must be showing excerpts.
		if ( ! is_singular() && ! is_404() ) {
			echo apply_filters( 'generate_featured_image_output', sprintf( // WPCS: XSS ok.
				'<div class="post-image">
					%3$s
					<a href="%1$s">
						%2$s
					</a>
				</div>',
				esc_url( get_permalink() ),
				get_the_post_thumbnail(
					get_the_ID(),
					apply_filters( 'generate_page_header_default_size', 'medium_large' ),
					array(
						'itemprop' => 'image',
					)
				),
				apply_filters( 'generate_inside_featured_image_output', '' )
			) );
		}
	}
}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function justread_entry_single_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'generatepress' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links"><span class="cat-links__title">' . __( 'Categorias', 'generatepress' ) . '</span>%1$s</span>', $categories_list ); // WPCS: XSS OK.
		}

		$tags_list = get_the_tag_list( '', '' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links"><span class="tags-links__title">' . __( 'Tags', 'generatepress' ) . '</span>%1$s</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
}