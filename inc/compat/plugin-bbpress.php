<?php
/**
 * @package The_SEO_Framework\Compat\Plugin\bbPress
 */
namespace The_SEO_Framework;

defined( 'THE_SEO_FRAMEWORK_PRESENT' ) and $_this = \the_seo_framework_class() and $this instanceof $_this or die;

/**
 * Override wp_title's bbPress title with the one generated by The SEO Framework.
 *
 * @since 2.3.5
 */
\add_filter( 'bbp_title', array( $this, 'title_from_cache' ), 99, 3 );

\add_filter( 'the_seo_framework_seo_column_keys_order', __NAMESPACE__ . '\\_bbpress_filter_order_keys' );
/**
 * Filters the order keys for The SEO Bar.
 *
 * @since 2.8.0
 * @access private
 *
 * @param array $current_keys The current column keys TSF looks for.
 * @return array Expanded keyset.
 */
function _bbpress_filter_order_keys( $current_keys = array() ) {

	$new_keys = array(
		'bbp_topic_freshness',
		'bbp_forum_freshness',
		'bbp_reply_created',
	);

	return array_merge( $current_keys, $new_keys );
}

\add_filter( 'the_seo_framework_pre_add_title', __NAMESPACE__ . '\\_bbpress_filter_pre_title', 10, 3 );
/**
 * Fixes bbPress Titles.
 *
 * bbPress has a hard time maintaining WordPress' query after the original query.
 * Reasons unknown.
 * This function fixes the Title part.
 *
 * @since 2.9.0
 * @access private
 *
 * @param string $title The filter title.
 * @param array $args The title arguments.
 * @param bool $escape Whether the output will be sanitized.
 * @return string $title The bbPress title.
 */
function _bbpress_filter_pre_title( $title = '', $args = array(), $escape = true ) {

	if ( \is_bbpress() ) {
		if ( \bbp_is_topic_tag() ) {
			$data = \the_seo_framework()->get_term_meta( \get_queried_object_id() );

			if ( ! empty( $data['doctitle'] ) ) {
				$title = $data['doctitle'];
			} else {
				$term = \get_queried_object();
				$title = $term->name ?: \the_seo_framework()->untitled();
			}
		}
	}

	return $title;
}

\add_filter( 'the_seo_framework_url_path', __NAMESPACE__ . '\\_bbpress_filter_url_path', 10, 3 );
/**
 * Fixes bbPress URLs.
 *
 * bbPress has a hard time maintaining WordPress' query after the original query.
 * Reasons unknown.
 * This function fixes the URl path part.
 *
 * @since 2.9.0
 * @access private
 *
 * @param string $path The current path.
 * @param int $id The page/post ID.
 * @param bool $external Whether the request is external (i.e. sitemap)
 * @return string The URL path.
 */
function _bbpress_filter_url_path( $path, $id = 0, $external = false ) {

	if ( $external || ! $id )
		return $path;

	if ( '' !== \the_seo_framework()->permalink_structure() && \is_bbpress() ) :

		if ( \bbp_is_single_user_topics() ) {
			// User's topics
			$base = \bbp_get_user_topics_created_url( \bbp_get_displayed_user_id() );

		} elseif ( \bbp_is_favorites() ) {
			// User's favorites
			$base = \bbp_get_favorites_permalink( \bbp_get_displayed_user_id() );

		} elseif ( \bbp_is_subscriptions() ) {
			// User's subscriptions
			$base = \bbp_get_subscriptions_permalink( \bbp_get_displayed_user_id() );

		} elseif ( \bbp_is_single_user() ) {
			// Root profile page
			$base = \bbp_get_user_profile_url( \bbp_get_displayed_user_id() );

		} elseif ( \bbp_is_single_view() ) {
			// View
			$base = \bbp_get_view_url();

		} elseif ( \bbp_is_topic_tag() ) {
			// Topic tag
			$base = \bbp_get_topic_tag_link();

		} elseif ( \is_page() || \is_single() ) {
			// Page/post, skip.
			$base = null;

		} elseif ( \bbp_is_forum_archive() ) {
			// Forum archive
			$base = \bbp_get_forums_url();

		} elseif ( \bbp_is_topic_archive() ) {
			// Topic archive
			$base = \bbp_get_topics_url();
		}

		if ( isset( $base ) )
			$path = \the_seo_framework()->set_url_scheme( $base, 'relative', true );
	endif;

	return $path;
}

\add_filter( 'the_seo_framework_fetched_description_excerpt', __NAMESPACE__ . '\\_bbpress_filter_excerpt_generation', 10, 4 );
/**
 * Fixes bbPress excerpts.
 *
 * bbPress has a hard time maintaining WordPress' query after the original query.
 * Reasons unknown.
 * This function fixes the Excerpt part.
 *
 * @since 2.9.0
 * @since 3.0.4 : Default value for $max_char_length has been increased from 155 to 300.
 * @access private
 *
 * @param string $excerpt The excerpt to use.
 * @param bool $page_id The current page/term ID
 * @param object|mixed $term The current term.
 * @param int $max_char_length Determines the maximum length of excerpt after trimming.
 * @return string The excerpt.
 */
function _bbpress_filter_excerpt_generation( $excerpt = '', $page_id = 0, $term = '', $max_char_length = 300 ) {

	if ( \is_bbpress() ) {
		if ( \bbp_is_topic_tag() ) {
			$term = \get_queried_object();
			$description = $term->description ?: '';

			//* Always overwrite.
			$excerpt = \the_seo_framework()->s_description_raw( $description );
		}
	}

	return $excerpt;
}

\add_filter( 'the_seo_framework_custom_field_description', __NAMESPACE__ . '\_bbpress_filter_custom_field_description' );
/**
 * Fixes bbPress custom Description.
 *
 * bbPress has a hard time maintaining WordPress' query after the original query.
 * Reasons unknown.
 * This function fixes the Custom Description part.
 *
 * @since 2.9.0
 * @access private
 *
 * @param string $description The description.
 * @param array $args The description arguments.
 * @return string The custom description.
 */
function _bbpress_filter_custom_field_description( $description = '', $args = array() ) {

	if ( \is_bbpress() ) {
		if ( \bbp_is_topic_tag() ) {
			$data = \the_seo_framework()->get_term_meta( \get_queried_object_id() );
			if ( ! empty( $data['description'] ) ) {
				$description = $data['description'];
			} else {
				$description = '';
			}
		}
	}

	return $description;
}

\add_filter( 'the_seo_framework_do_adjust_archive_query', __NAMESPACE__ . '\_bbpress_filter_do_adjust_query', 10, 2 );
/**
 * Fixes bbPress exclusion of first reply.
 *
 * bbPress has a hard time maintaining WordPress' query after the original query.
 * Reasons unknown.
 * This function fixes the query alteration part.
 *
 * @since 3.0.3
 * @access private
 * @link <https://bbpress.trac.wordpress.org/ticket/2607> (regression)
 *
 * @param bool      $do       Whether to adjust the query.
 * @param \WP_Query $wp_query The query. Passed by reference.
 * @return bool
 */
function _bbpress_filter_do_adjust_query( $do, &$wp_query ) {

	if ( \is_bbpress() && isset( $wp_query->query['post_type'] ) ) {
		if ( in_array( 'reply', (array) $wp_query->query['post_type'], true ) ) {
			$do = false;
		}
	}

	return $do;
}
