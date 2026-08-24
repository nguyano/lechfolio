=== LechFolio ===

Contributors: Ngunyi yannick
Theme link: https://dev.sheltersconnectcolorado.com
Tags: accessibility-ready, one-column, two-columns, custom-menu, featured-images, microformats, sticky-post, threaded-comments, translation-ready
Requires at least: 5.2
Tested up to: 6.5
Stable tag: trunk
License: GNU General Public License v3 or Later
License URI: https://www.gnu.org/licenses/gpl.html

LechFolio is the custom WordPress theme shell for the Shelters Connect Colorado Project. It is designed to work with the custom Coshelters plugin.

== Description ==

LechFolio is a project-specific WordPress theme for the Shelters Connect Colorado Project at https://dev.sheltersconnectcolorado.com.

The theme provides the presentation shell for the ShelterConnect Colorado platform, including shared layout, branding, navigation, footer output, page structure, and theme-level styling. It is intentionally lightweight and depends on the custom Coshelters plugin for the shelter-domain application behavior.

Coshelters provides the platform's directory, account, verification, claim, shelter-management, administration, REST API, scheduled work, and integration workflows. Most shelter-specific page output is routed through the plugin rather than stored as ordinary theme content.

This theme should be deployed and maintained together with the Coshelters plugin located at `wp-content/plugins/coshelters`. Replacing or disabling the plugin removes the core ShelterConnect application even if LechFolio remains active.

== Project Status and Distribution ==

LechFolio is a custom, project-specific theme maintained for the Shelters Connect Colorado deployment. It is not a general-purpose public WordPress theme and is not distributed through the WordPress.org theme directory.

The theme should be transferred, deployed, configured, and maintained as part of the complete ShelterConnect Colorado WordPress system. Its rendered behavior depends on WordPress configuration, menus, uploaded media, active pages, user state, and the companion Coshelters plugin.

== Technical Requirements ==

* WordPress 5.2 or later.
* The custom Coshelters plugin active for platform application pages and authenticated shelter workflows.
* HTTPS for production traffic.
* A writable WordPress uploads directory for theme and platform media.
* A modern browser with JavaScript enabled for responsive navigation and interactive platform screens.

== Installation ==

Install this theme from the authorized project repository or approved release package.

1. Back up the target database and `wp-content` directory.
2. Confirm the Coshelters plugin is present at `wp-content/plugins/coshelters`.
3. Place this theme in `wp-content/themes/lechfolio`.
4. Activate LechFolio through WordPress administration.
5. Confirm the site URL uses https://dev.sheltersconnectcolorado.com in the development environment.
6. Configure the site logo, menus, pages, and any required WordPress theme settings.
7. Verify that public pages, authenticated menus, shelter navigation, account links, and footer links render correctly with Coshelters active.

Do not deploy this theme by itself as a complete replacement for the ShelterConnect Colorado platform. The application workflows belong to Coshelters.

== Post-Deployment Verification ==

At minimum, verify:

* The home page loads over HTTPS at https://dev.sheltersconnectcolorado.com.
* The public shelter directory and shelter detail pages render with the active theme.
* Registration, login, logout, account, profile, shelter, map, and claim navigation links point to the expected Coshelters-managed pages.
* The responsive menu works on desktop and mobile viewports.
* The configured logo, footer, About link, Contact link, and project branding are correct.
* Authenticated user menus reflect the correct resident, shelter-manager, and administrator states.
* Browser console and PHP logs contain no new theme-related errors.

== Troubleshooting ==

= Application pages are missing or return 404 =

Confirm Coshelters is active, the plugin-managed pages exist, and WordPress permalinks have been saved.

= Shelter-specific content does not appear =

Trace the request through the Coshelters plugin first. LechFolio supplies the theme shell, while Coshelters supplies most platform-specific content, permissions, routes, and data access.

= Menus or account links are incorrect =

Confirm the WordPress menu configuration, Coshelters managed-page settings, active user role, account approval state, and current permalink structure.

== Frequently Asked Questions ==

= Is LechFolio a public WordPress theme? =

No. It is a custom theme maintained for the Shelters Connect Colorado Project.

= Does LechFolio contain the ShelterConnect application? =

No. LechFolio provides the custom presentation shell. The Coshelters plugin provides the core shelter directory, account, verification, claim, administration, and integration workflows.

= Can LechFolio be used without Coshelters? =

Only as a basic WordPress theme shell. The ShelterConnect Colorado application requires the Coshelters plugin.

== License ==

LechFolio WordPress Theme 2025

LechFolio is distributed under the terms of the GNU GPL.

The LechFolio theme package and all files contained within are distributed under the terms of the GNU GPL v3 or Later (https://www.gnu.org/licenses/gpl.html).
