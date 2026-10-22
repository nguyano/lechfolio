<?php
/**
 * Offline security regression fixtures for LechFolio; never boots the database.
 * Run: php tests/security-regressions.php [path/to/wordpress]
 * Uses WordPress escaping/KSES with explicit stubs for template and user state.
 *
 * @package LechFolio
 */
if ( PHP_SAPI !== 'cli' ) {
	exit;
}
define( 'ABSPATH', rtrim( $argv[1] ?? dirname( __DIR__, 4 ), '/\\' ) . '/' );
define( 'WPINC', 'wp-includes' );
require_once ABSPATH . WPINC . '/compat.php';
require_once ABSPATH . WPINC . '/plugin.php';
require_once ABSPATH . WPINC . '/formatting.php';
require_once ABSPATH . WPINC . '/kses.php';
if ( is_file( ABSPATH . WPINC . '/utf8.php' ) ) {
	require_once ABSPATH . WPINC . '/compat-utf8.php';
	require_once ABSPATH . WPINC . '/utf8.php';
}
require_once ABSPATH . WPINC . '/html-api/class-wp-html-tag-processor.php';
if ( is_file( ABSPATH . WPINC . '/class-wp-token-map.php' ) ) {
	require_once ABSPATH . WPINC . '/class-wp-token-map.php';
}
foreach ( glob( ABSPATH . WPINC . '/html-api/*.php' ) as $html_file ) {
	require_once $html_file;
}

$state = array( 'protected' => true, 'admin' => false, 'login' => true, 'id' => 0, 'queries' => array(), 'writes' => array(), 'posts' => 1 );
$checks = 0;

/** Fails immediately when a security expectation is violated. */
function check( $condition, $message ) {
	global $checks;
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
	++$checks;
}

/** Captures a real theme template with deterministic fixture state. */
function render_fixture( $file, $args = array() ) {
	ob_start();
	include dirname( __DIR__ ) . '/' . $file;
	return ob_get_clean();
}

// WordPress runtime stubs: no database, current session, mail, or network access.
function get_option( $key ) { return $key === 'blog_charset' ? 'UTF-8' : false; }
function is_utf8_charset( $charset = null ) { return true; }
function _canonical_charset( $charset ) { return $charset; }
function wp_allowed_protocols() { return array( 'http', 'https', 'mailto' ); }
function __( $text, $domain = '' ) { return $text; }
function esc_html__( $text, $domain = '' ) { return esc_html( $text ); }
function esc_html_e( $text, $domain = '' ) { echo esc_html( $text ); }
function absint( $value ) { return abs( (int) $value ); }
function post_password_required() { return $GLOBALS['state']['protected']; }
function is_admin() { return $GLOBALS['state']['admin']; }
function is_user_logged_in() { return $GLOBALS['state']['login']; }
function get_the_ID() { return $GLOBALS['state']['id']; }
function get_current_user_id() { return 42; }
function get_comments( $args ) { $GLOBALS['state']['queries'][] = $args; return 3; }
function wp_verify_nonce( $nonce, $action ) { return $nonce === 'valid' && $action === 'lechfolio_dismiss_notice'; }
function add_user_meta( ...$args ) { $GLOBALS['state']['writes'][] = $args; }
function have_comments() { return false; }
function comments_open() { return true; }
function comment_form() { echo 'COMMENT_FORM'; }
function get_header() {}
function get_footer() {}
function have_posts() { return $GLOBALS['state']['posts'] > 0; }
function the_post() { --$GLOBALS['state']['posts']; }
function get_the_password_form() { return 'PASSWORD_FORM'; }
function has_post_thumbnail() { return true; }
function get_post_thumbnail_id() { return 9; }
function get_the_post_thumbnail_url( ...$args ) { return 'https://example.test/private.jpg'; }
function get_the_title( ...$args ) { return 'Title'; }
function the_title() { echo 'Title'; }
function the_title_attribute() { echo 'Title'; }
function the_ID() { echo '42'; }
function post_class( ...$args ) { echo 'class="fixture"'; }
function edit_post_link( ...$args ) {}
function the_post_thumbnail( ...$args ) { echo 'FEATURED_MEDIA'; }
function get_the_excerpt() { return 'EXCERPT'; }
function the_excerpt() { echo 'EXCERPT'; }
function the_content() { echo post_password_required() ? 'PASSWORD_FORM' : 'CONTENT'; }
function wp_link_pages( ...$args ) {}
function is_search() { return false; }
function get_permalink() { return 'https://example.test/post'; }
function current_user_can( $capability ) { return $GLOBALS['state']['admin']; }
function wp_json_encode( $value, $flags = 0 ) { return json_encode( $value, $flags ); }
function get_stylesheet() { return 'quote"]</script><script>alert(1)</script>'; }
function wp_get_theme() {
	return new class {
		/** Supplies hostile metadata to exercise the inline script boundary. */
		public function get( $key ) { return '</script><script>alert(1)</script>'; }
	};
}

require dirname( __DIR__ ) . '/inc/comments.php';
require dirname( __DIR__ ) . '/inc/theme-setup.php';
require dirname( __DIR__ ) . '/inc/helpers.php';
require dirname( __DIR__ ) . '/inc/admin.php';

check( trim( render_fixture( 'comments.php' ) ) === '', 'Protected comments must emit no markup.' );
check( trim( render_fixture( 'attachment.php' ) ) === 'PASSWORD_FORM', 'Protected attachments must stop before media lookup.' );
foreach ( array( 'page', 'entry-content', 'entry-summary' ) as $template ) {
	$state['protected'] = true;
	check( ! str_contains( render_fixture( 'template-parts/content/' . $template . '.php' ), 'FEATURED_MEDIA' ), 'Protected media leaked: ' . $template );
	$state['protected'] = false;
	check( str_contains( render_fixture( 'template-parts/content/' . $template . '.php' ), 'FEATURED_MEDIA' ), 'Public media missing: ' . $template );
}
check( str_contains( render_fixture( 'comments.php' ), 'COMMENT_FORM' ), 'Public comment form missing.' );
check( lechfolio_comment_count( 7 ) === 7 && ! $state['queries'], 'Missing post must not query all comments.' );
check( lechfolio_comment_count( 7, 123 ) === 3, 'Explicit post count was not used.' );
check( $state['queries'][0] === array( 'status' => 'approve', 'post_id' => 123, 'type' => 'comment', 'count' => true ), 'Count query must be bounded to the requested post.' );
$state['admin'] = true;
check( lechfolio_comment_count( 7, 123 ) === 7 && count( $state['queries'] ) === 1, 'Admin count must remain unchanged.' );

foreach ( array( array(), array( 'dismiss' => 'lechfolio_notice' ), array( 'dismiss' => 'lechfolio_notice', '_wpnonce' => 'bad' ), array( 'dismiss' => array( 'lechfolio_notice' ), '_wpnonce' => array( 'valid' ) ) ) as $query ) {
	$_GET = $query;
	lechfolio_notice_dismissed();
	check( ! $state['writes'], 'Invalid dismissal request wrote metadata.' );
}
$_GET = array( 'dismiss' => 'lechfolio_notice', '_wpnonce' => 'valid' );
$state['login'] = false;
lechfolio_notice_dismissed();
check( ! $state['writes'], 'Anonymous dismissal wrote metadata.' );
$state['login'] = true;
lechfolio_notice_dismissed();
check( count( $state['writes'] ) === 1 && $state['writes'][0][0] === 42, 'Valid dismissal must target only the current user.' );

$hostile = '<svg onload="alert(1)"><script>alert(1)</script><path d="M0 0" onmouseover="alert(1)" /></svg><img src="javascript:alert(1)" onerror="alert(1)">';
$safe = wp_kses( $hostile, lechfolio_allowed_icon_markup() );
check( ! preg_match( '/<script|onload|onmouseover|onerror|javascript:/i', $safe ), 'Icon allowlist retained executable markup.' );
check( str_contains( $safe, '<svg' ) && str_contains( $safe, '<path' ), 'Safe icon markup must remain.' );
$menu = render_fixture(
	'template-parts/navigation/logged-in-menu.php',
	array( 'nav_items' => array(
		array( 'id' => 'x" onmouseover="alert(1)', 'href' => 'javascript:alert(1)', 'icon' => 'x" onclick="alert(1)', 'label' => '<script>alert(1)</script>' ),
		array( 'type' => 'dropdown', 'id' => 'profile', 'user_img' => 'javascript:alert(1)', 'username' => '<img src=x onerror=alert(1)>', 'items' => array() ),
	) )
);
check( ! preg_match( '/<script|javascript:|<img src=x|" onmouseover="|" onclick="/', $menu ), 'Navigation values escaped their HTML/URL contexts.' );
check( str_contains( $menu, '&lt;script&gt;' ) && str_contains( $menu, '&lt;img' ), 'Hostile names should remain visible as text.' );
ob_start();
lechfolio_print_themes_screen_docs_link();
$script = ob_get_clean();
check( substr_count( $script, '</script>' ) === 1 && ! str_contains( $script, '</script><script>' ), 'Theme metadata escaped the inline script.' );
$state['admin'] = false;
ob_start();
lechfolio_print_themes_screen_docs_link();
check( ob_get_clean() === '', 'Unprivileged documentation script output.' );
echo "PASS: {$checks} security regression checks (offline fixtures).\n";
