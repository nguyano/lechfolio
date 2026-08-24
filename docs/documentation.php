<?php
/**
 * LechFolio internal developer documentation page.
 *
 * Provides a standalone one-page reference for internal developers maintaining
 * the LechFolio WordPress theme in the dev environment.
 *
 * @since 1.0.0
 * @package LechFolio
 */
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>LechFolio Theme Developer Documentation</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Internal developer documentation for the LechFolio WordPress theme.">
	<style>
		:root {
			--ngesc-bg: #f4f7fb;
			--ngesc-surface: #ffffff;
			--ngesc-surface-alt: #f8fafc;
			--ngesc-border: #dbe4f0;
			--ngesc-border-strong: #b8c7dc;
			--ngesc-text: #172033;
			--ngesc-muted: #5d6b82;
			--ngesc-heading: #123b7a;
			--ngesc-accent: #0f62fe;
			--ngesc-accent-dark: #0843a8;
			--ngesc-code-bg: #111827;
			--ngesc-code-text: #f8fafc;
			--ngesc-success: #0f766e;
			--ngesc-warning: #9a5b00;
			--ngesc-danger: #b42318;
			--ngesc-radius: 8px;
		}

		* {
			box-sizing: border-box;
		}

		html {
			scroll-behavior: smooth;
		}

		body {
			margin: 0;
			background: var(--ngesc-bg);
			color: var(--ngesc-text);
			font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
			font-size: 16px;
			line-height: 1.65;
		}

		a {
			color: var(--ngesc-accent);
			text-decoration: none;
		}

		a:hover,
		a:focus {
			color: var(--ngesc-accent-dark);
			text-decoration: underline;
		}

		.page {
			max-width: 1280px;
			margin: 0 auto;
			padding: 28px 18px 48px;
		}

		.hero,
		.content,
		.footer-note {
			background: var(--ngesc-surface);
			border: 1px solid var(--ngesc-border);
			border-radius: var(--ngesc-radius);
			box-shadow: 0 18px 45px rgba(15, 35, 70, 0.08);
		}

		.hero {
			padding: 34px;
			margin-bottom: 22px;
		}

		.hero-nav {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 16px;
			margin-bottom: 24px;
		}

		.brand-kicker {
			color: var(--ngesc-muted);
			font-size: 0.9rem;
			font-weight: 700;
			letter-spacing: 0.08em;
			text-transform: uppercase;
		}

		.back-link,
		.inline-action {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			min-height: 38px;
			padding: 8px 14px;
			border: 1px solid var(--ngesc-border-strong);
			border-radius: 6px;
			background: var(--ngesc-surface-alt);
			color: var(--ngesc-heading);
			font-weight: 700;
		}

		h1,
		h2,
		h3,
		h4 {
			color: var(--ngesc-heading);
			line-height: 1.2;
		}

		h1 {
			max-width: 980px;
			margin: 0 0 14px;
			font-size: clamp(2.2rem, 5vw, 4.1rem);
			letter-spacing: 0;
		}

		h2 {
			margin-top: 44px;
			padding-top: 16px;
			border-top: 1px solid var(--ngesc-border);
			font-size: 1.75rem;
		}

		h3 {
			margin-top: 30px;
			font-size: 1.2rem;
		}

		h4 {
			margin: 18px 0 8px;
			font-size: 1rem;
		}

		p {
			margin: 0 0 16px;
		}

		.lede {
			max-width: 980px;
			color: var(--ngesc-muted);
			font-size: 1.08rem;
		}

		.badges {
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
			margin-top: 22px;
		}

		.badge {
			padding: 7px 11px;
			border: 1px solid var(--ngesc-border);
			border-radius: 999px;
			background: var(--ngesc-surface-alt);
			color: var(--ngesc-muted);
			font-size: 0.88rem;
			font-weight: 700;
		}

		.content {
			display: grid;
			grid-template-columns: minmax(220px, 300px) minmax(0, 1fr);
			align-items: start;
		}

		.sidebar {
			position: sticky;
			top: 0;
			max-height: 100vh;
			overflow: auto;
			padding: 26px;
			border-right: 1px solid var(--ngesc-border);
			background: var(--ngesc-surface-alt);
		}

		.sidebar h4 {
			margin-top: 0;
		}

		.sidebar ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}

		.sidebar li + li {
			margin-top: 7px;
		}

		.sidebar a {
			display: block;
			padding: 7px 9px;
			border-radius: 6px;
			color: var(--ngesc-text);
			font-size: 0.94rem;
			font-weight: 650;
		}

		.sidebar a:hover,
		.sidebar a:focus {
			background: #eaf1fb;
			text-decoration: none;
		}

		.main {
			min-width: 0;
			padding: 34px;
		}

		.grid {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 16px;
		}

		.grid.three {
			grid-template-columns: repeat(3, minmax(0, 1fr));
		}

		.card,
		.callout,
		details {
			border: 1px solid var(--ngesc-border);
			border-radius: var(--ngesc-radius);
			background: var(--ngesc-surface-alt);
		}

		.card {
			padding: 18px;
		}

		.card p:last-child,
		.callout p:last-child {
			margin-bottom: 0;
		}

		.callout {
			margin: 18px 0;
			padding: 16px 18px;
			border-left: 5px solid var(--ngesc-accent);
		}

		.callout.warning {
			border-left-color: var(--ngesc-warning);
		}

		.callout.danger {
			border-left-color: var(--ngesc-danger);
		}

		ul,
		ol {
			margin: 0 0 18px 1.3em;
			padding: 0;
		}

		li {
			margin: 5px 0;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin: 16px 0 24px;
			border: 1px solid var(--ngesc-border);
			border-radius: var(--ngesc-radius);
			overflow: hidden;
			font-size: 0.95rem;
		}

		th,
		td {
			padding: 11px 12px;
			border-bottom: 1px solid var(--ngesc-border);
			vertical-align: top;
			text-align: left;
		}

		th {
			background: #eaf1fb;
			color: var(--ngesc-heading);
			font-weight: 800;
		}

		tr:last-child td {
			border-bottom: 0;
		}

		code {
			padding: 2px 5px;
			border-radius: 4px;
			background: #e9eef6;
			color: #0f274b;
			font-family: Consolas, Monaco, "Courier New", monospace;
			font-size: 0.92em;
		}

		pre {
			margin: 14px 0 22px;
			padding: 16px;
			overflow-x: auto;
			border-radius: var(--ngesc-radius);
			background: var(--ngesc-code-bg);
			color: var(--ngesc-code-text);
			font-size: 0.92rem;
			line-height: 1.55;
		}

		pre code {
			padding: 0;
			background: transparent;
			color: inherit;
		}

		.footer-note {
			margin-top: 22px;
			padding: 22px 28px;
			color: var(--ngesc-muted);
		}

		@media (max-width: 900px) {
			.content,
			.grid,
			.grid.three {
				grid-template-columns: 1fr;
			}

			.sidebar {
				position: static;
				max-height: none;
				border-right: 0;
				border-bottom: 1px solid var(--ngesc-border);
			}

			.hero,
			.main {
				padding: 24px;
			}
		}

		@media (max-width: 560px) {
			.page {
				padding: 12px;
			}

			.hero-nav {
				align-items: flex-start;
				flex-direction: column;
			}

			table {
				display: block;
				overflow-x: auto;
				white-space: nowrap;
			}
		}
	</style>
</head>
<body>
	<div class="page">
		<header class="hero">
			<div class="hero-nav">
				<div class="brand-kicker">LechFolio Theme Documentation</div>
				<a class="back-link" href="https://dev.sheltersconnectcolorado.com">Back to Dev Site</a>
			</div>
			<h1>LechFolio WordPress Theme Developer Documentation</h1>
			<p class="lede">
				LechFolio is the lightweight container theme for Shelters Connect Colorado. It provides the site shell,
				shared header/footer, WordPress content templates, and optional Coshelters frontend navigation adapters.
			</p>
			<div class="badges" aria-label="Documentation metadata">
				<span class="badge">Internal developer reference</span>
				<span class="badge">Theme version 1.0.0</span>
				<span class="badge">Text domain: lechfolio</span>
				<span class="badge">Docs URL: /docs/lechfolio</span>
				<span class="badge">Last updated: August 24, 2026</span>
			</div>
		</header>

		<div class="content">
			<nav class="sidebar" aria-label="Documentation navigation">
				<h4>On this page</h4>
				<ul>
					<li><a href="#overview">Overview</a></li>
					<li><a href="#structure">Theme Structure</a></li>
					<li><a href="#templates">Template Files</a></li>
					<li><a href="#includes">Functions and Includes</a></li>
					<li><a href="#hooks">Hooks and Filters</a></li>
					<li><a href="#assets">Assets</a></li>
					<li><a href="#data-model">CPTs, Taxonomies, ACF</a></li>
					<li><a href="#conventions">Conventions</a></li>
					<li><a href="#change-checklist">Change Checklist</a></li>
				</ul>
			</nav>

			<main class="main">
				<section id="overview">
					<h2>Overview</h2>
					<p>
						This theme should stay thin. Put presentation shell, template composition, and Coshelters compatibility
						wrappers here. Keep domain workflows, persistence, AJAX, REST, and business rules in the Coshelters plugin.
					</p>
					<div class="grid three">
						<div class="card">
							<h3>Primary role</h3>
							<p>Render the public WordPress shell and content templates with stable CSS classes used by the site and plugin UI.</p>
						</div>
						<div class="card">
							<h3>Integration role</h3>
							<p>Use small wrappers around optional Coshelters functions so the theme still loads when the plugin is disabled.</p>
						</div>
						<div class="card">
							<h3>Extension rule</h3>
							<p>Add files to the existing include/template-part structure. Avoid new frameworks, build tooling, and theme-side data models.</p>
						</div>
					</div>
				</section>

				<section id="structure">
					<h2>Theme Structure</h2>
					<pre><code>lechfolio/
  functions.php
  inc/
    constants.php
    theme-setup.php
    enqueue.php
    helpers.php
    navigation.php
    template-tags.php
    comments.php
    hooks.php
  template-parts/
    layout/
    content/
    navigation/
  assets/
    js/public-scripts.js
  lib/fontawesome/
  docs/documentation.php
  style.css
  theme.json</code></pre>
					<table>
						<thead>
							<tr>
								<th>Path</th>
								<th>Use</th>
							</tr>
						</thead>
						<tbody>
							<tr><td><code>functions.php</code></td><td>Bootstrap only. Add new runtime files to the include list; do not rebuild it into a large function dump.</td></tr>
							<tr><td><code>inc/</code></td><td>Theme setup, hooks, enqueueing, helpers, navigation, template tags, and comment helpers.</td></tr>
							<tr><td><code>template-parts/layout/</code></td><td>Shared loader, site header, and site footer markup.</td></tr>
							<tr><td><code>template-parts/content/</code></td><td>Post, page, archive/search result, entry meta, and empty-state fragments.</td></tr>
							<tr><td><code>template-parts/navigation/</code></td><td>Logged-in app menu, archive pagination, and single post navigation.</td></tr>
							<tr><td><code>assets/js/public-scripts.js</code></td><td>Loader hiding, mobile menu toggle, dropdown behavior, and lightweight data-target toggles.</td></tr>
							<tr><td><code>style.css</code></td><td>Theme header plus all current theme CSS. Keep CSS here unless a clear asset split is introduced intentionally.</td></tr>
							<tr><td><code>lib/fontawesome/</code></td><td>Bundled Font Awesome assets used by existing menu/icon CSS. Do not replace with a package manager.</td></tr>
						</tbody>
					</table>
				</section>

				<section id="templates">
					<h2>Template Files</h2>
					<p>
						Top-level templates should select the loop context, then delegate reusable markup to <code>template-parts/</code>.
						The root <code>entry*</code> and <code>nav-below*</code> files remain as compatibility wrappers.
					</p>
					<table>
						<thead>
							<tr>
								<th>File</th>
								<th>Role</th>
							</tr>
						</thead>
						<tbody>
							<tr><td><code>header.php</code></td><td>Document head, <code>wp_head()</code>, body open, loader include, site header include, and opening <code>&lt;main&gt;</code>.</td></tr>
							<tr><td><code>footer.php</code></td><td>Closes <code>&lt;main&gt;</code>, renders layout footer, closes wrapper, and calls <code>wp_footer()</code>.</td></tr>
							<tr><td><code>index.php</code></td><td>Fallback post loop using <code>template-parts/content/entry.php</code> and archive navigation.</td></tr>
							<tr><td><code>page.php</code></td><td>Standard page card via <code>template-parts/content/page.php</code>; comments render when open and not password-protected.</td></tr>
							<tr><td><code>single.php</code></td><td>Single post loop, optional comments, and single post navigation.</td></tr>
							<tr><td><code>archive.php</code>, <code>category.php</code>, <code>tag.php</code>, <code>author.php</code></td><td>Archive headers plus the shared entry partial and archive navigation.</td></tr>
							<tr><td><code>search.php</code></td><td>Search results header, shared entry partial, and <code>content/none.php</code> for empty results.</td></tr>
							<tr><td><code>attachment.php</code></td><td>Attachment details, parent link, image navigation, and attachment output.</td></tr>
							<tr><td><code>comments.php</code></td><td>Comment list, pingback list, comment pagination, and <code>comment_form()</code>.</td></tr>
							<tr><td><code>template-blank.php</code></td><td>Minimal page template that outputs only shared shell and page content.</td></tr>
						</tbody>
					</table>
				</section>

				<section id="includes">
					<h2>Functions and Includes</h2>
					<table>
						<thead>
							<tr>
								<th>Include</th>
								<th>Functions developers should know</th>
							</tr>
						</thead>
						<tbody>
							<tr><td><code>inc/constants.php</code></td><td><code>LECHFOLIO_VERSION</code>, <code>LECHFOLIO_DIR</code>, <code>LECHFOLIO_URI</code>, <code>LECHFOLIO_INC</code>.</td></tr>
							<tr><td><code>inc/theme-setup.php</code></td><td><code>lechfolio_setup()</code>, <code>lechfolio_notice_dismissed()</code>, <code>lechfolio_widgets_init()</code>.</td></tr>
							<tr><td><code>inc/enqueue.php</code></td><td><code>lechfolio_asset_version()</code>, <code>lechfolio_enqueue()</code>, <code>lechfolio_footer_device_classes()</code>.</td></tr>
							<tr><td><code>inc/helpers.php</code></td><td>Coshelters wrappers: <code>lechfolio_is_frontend_request()</code>, <code>lechfolio_coshlt_frontend_url()</code>, <code>lechfolio_coshlt_image()</code>, <code>lechfolio_coshlt_icon()</code>.</td></tr>
							<tr><td><code>inc/navigation.php</code></td><td><code>lechfolio_primary_menu()</code> and compatibility function <code>lechfolio_loged_in_menu()</code>. Keep the misspelling for existing internal references.</td></tr>
							<tr><td><code>inc/template-tags.php</code></td><td>Schema attributes, skip link, title fallback, read-more links, image-size filtering, and pingback header.</td></tr>
							<tr><td><code>inc/comments.php</code></td><td>Threaded comment script enqueue, ping callback, and front-end comment count normalization.</td></tr>
							<tr><td><code>inc/hooks.php</code></td><td>Central list of actions and filters. Wire new theme hooks here after adding implementation functions.</td></tr>
						</tbody>
					</table>
					<div class="callout warning">
						<p><strong>Compatibility note:</strong> <code>lechfolio_loged_in_menu()</code> is intentionally misspelled. Do not rename it unless all plugin/theme callers are migrated at the same time.</p>
					</div>
				</section>

				<section id="hooks">
					<h2>Hooks and Filters</h2>
					<h3>Actions registered by the theme</h3>
					<pre><code>after_setup_theme          lechfolio_setup
admin_init                 lechfolio_notice_dismissed
wp_enqueue_scripts         lechfolio_enqueue
wp_footer                  lechfolio_footer_device_classes
widgets_init               lechfolio_widgets_init
wp_head                    lechfolio_pingback_header
comment_form_before        lechfolio_enqueue_comment_reply_script
wp_body_open               lechfolio_skip_link</code></pre>
					<h3>Filters registered by the theme</h3>
					<pre><code>document_title_separator         lechfolio_document_title_separator
the_title                        lechfolio_title
nav_menu_link_attributes         lechfolio_schema_url
the_content_more_link            lechfolio_read_more_link
excerpt_more                     lechfolio_excerpt_read_more_link
big_image_size_threshold         __return_false
intermediate_image_sizes_advanced lechfolio_image_insert_override
get_comments_number              lechfolio_comment_count</code></pre>
					<h3>Integration hooks consumed by templates</h3>
					<ul>
						<li><code>coshlt_theme_header_logo_after</code> renders plugin-provided logo-adjacent content in <code>template-parts/layout/site-header.php</code>.</li>
						<li><code>coshlt_theme_header_controls</code> renders plugin-owned header controls next to navigation.</li>
					</ul>
				</section>

				<section id="assets">
					<h2>Assets</h2>
					<p>
						Assets are enqueued through <code>lechfolio_enqueue()</code>. Versions are based on <code>filemtime()</code>
						through <code>lechfolio_asset_version()</code>, with <code>LECHFOLIO_VERSION</code> as fallback.
					</p>
					<table>
						<thead>
							<tr>
								<th>Handle</th>
								<th>Source</th>
								<th>Notes</th>
							</tr>
						</thead>
						<tbody>
							<tr><td><code>lechfolio-style</code></td><td><code>style.css</code></td><td>Main stylesheet and WordPress theme header.</td></tr>
							<tr><td><code>lechfolio-public</code></td><td><code>assets/js/public-scripts.js</code></td><td>Loaded in the footer. No dependencies.</td></tr>
						</tbody>
					</table>
					<p>
						Add new frontend assets in <code>assets/css</code> or <code>assets/js</code> only when splitting makes maintenance clearer.
						Register them in <code>inc/enqueue.php</code>; do not print stylesheet or script tags directly in templates.
					</p>
				</section>

				<section id="data-model">
					<h2>CPTs, Taxonomies, ACF</h2>
					<table>
						<thead>
							<tr>
								<th>Type</th>
								<th>Status</th>
								<th>Where to add if needed</th>
							</tr>
						</thead>
						<tbody>
							<tr><td>Custom post types</td><td>None registered by this theme.</td><td>Prefer the Coshelters plugin for domain content. If theme-only presentation CPTs are ever required, add <code>inc/custom-post-types.php</code> and wire it in <code>functions.php</code>.</td></tr>
							<tr><td>Custom taxonomies</td><td>None registered by this theme.</td><td>Keep taxonomy registration with the owning content model, usually the plugin.</td></tr>
							<tr><td>ACF fields</td><td>None registered by this theme.</td><td>Do not hard-depend on ACF in the theme. Use guarded checks if an internal field group is introduced.</td></tr>
						</tbody>
					</table>
				</section>

				<section id="conventions">
					<h2>Theme Conventions</h2>
					<ul>
						<li>Prefix theme functions, handles, classes, and IDs with <code>lechfolio</code> unless matching an existing external contract.</li>
						<li>Use <code>get_template_part()</code> for reusable markup. Keep top-level templates short.</li>
						<li>Escape dynamic output at the template boundary with <code>esc_html()</code>, <code>esc_attr()</code>, <code>esc_url()</code>, or a narrow <code>wp_kses()</code> allowlist.</li>
						<li>Sanitize request values immediately with <code>sanitize_key()</code>, <code>sanitize_text_field()</code>, or a stricter sanitizer.</li>
						<li>Use nonces for state-changing admin or frontend actions. The current notice dismissal expects <code>_wpnonce</code> for <code>lechfolio_dismiss_notice</code>.</li>
						<li>Keep user-facing strings translation-ready with text domain <code>lechfolio</code>.</li>
						<li>Add concise file headers and method comments to new or updated PHP files.</li>
						<li>Do not introduce build tools, package managers, JS frameworks, or CSS frameworks for theme-only changes.</li>
					</ul>
				</section>

				<section id="change-checklist">
					<h2>Change Checklist</h2>
					<ul>
						<li>For markup changes, update the smallest relevant file in <code>template-parts/</code>.</li>
						<li>For new theme behavior, add a focused <code>inc/*.php</code> file and include it from <code>functions.php</code>.</li>
						<li>For new hooks, register them in <code>inc/hooks.php</code>.</li>
						<li>For assets, enqueue through <code>inc/enqueue.php</code> and use file-based versioning.</li>
						<li>Run <code>php -l</code> on changed PHP files and <code>node --check assets/js/public-scripts.js</code> when touching JavaScript.</li>
						<li>Use browser QA for header/footer/menu changes, especially logged-in Coshelters navigation and mobile dropdown behavior.</li>
					</ul>
				</section>
			</main>
		</div>

		<footer class="footer-note">
			<p>
				This page is internal developer documentation for the dev environment only. Keep it concise and update it when the theme structure,
				public helper functions, enqueued assets, or integration contracts change.
			</p>
		</footer>
	</div>
</body>
</html>
