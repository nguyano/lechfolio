/**
 * Public interactions for the LechFolio container theme.
 *
 * Handles the loader, accessible nested navigation, and plugin dialog triggers.
 */
/*
 * Page loader: leaves once the page is usable (DOM ready plus a short grace
 * for the first paint, or the load event, whichever comes first, capped so
 * heavy embeds never hold it), and returns softly on same-site navigation.
 */
(function () {
	const loader = document.getElementById('lechfolio-loader');
	if (!loader) {
		return;
	}

	// Scripts are running: the CSS no-JS failsafe would otherwise pin it hidden later.
	loader.style.animation = 'none';
	const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	let hidden = false;
	let leaveTimer = null;

	function hide() {
		if (hidden) {
			return;
		}
		hidden = true;
		window.clearTimeout(leaveTimer);
		loader.classList.remove('is-leaving');
		loader.classList.add('hide');
		loader.setAttribute('aria-hidden', 'true');
	}

	function show() {
		hidden = false;
		loader.removeAttribute('aria-hidden');
		loader.classList.remove('hide');
		loader.classList.add('is-leaving');
		// A navigation that turns into a download or is cancelled never unloads the page.
		leaveTimer = window.setTimeout(hide, 8000);
	}

	const ready = () => window.setTimeout(hide, reduceMotion ? 0 : 280);
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', ready, { once: true });
	} else {
		ready();
	}
	window.addEventListener('load', hide, { once: true });
	window.setTimeout(hide, 4000);

	// Back/forward cache restores the page as it was left: never with the loader up.
	window.addEventListener('pageshow', function (event) {
		if (event.persisted) {
			hidden = false;
			hide();
		}
	});

	/** Whether a click on this link leaves for another same-site page in this tab. */
	function isPageNavigation(event, link) {
		if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
			return false;
		}
		if (link.target && link.target !== '_self') {
			return false;
		}
		if (link.hasAttribute('download') || link.getAttribute('role') === 'button' || link.closest('[data-no-loader]')) {
			return false;
		}
		const url = new URL(link.href, window.location.href);
		if (url.origin !== window.location.origin || !/^https?:$/.test(url.protocol)) {
			return false;
		}
		if (url.pathname === window.location.pathname && url.search === window.location.search) {
			return false; // hash jumps and same-page links
		}
		return !/\/wp-admin\/|wp-login\.php|action=logout|\.(pdf|zip|csv|xlsx?|docx?|png|jpe?g|webp)$/i.test(url.href);
	}

	// Bubble phase: page scripts that cancel the click (dialogs, tabs) run first.
	document.addEventListener('click', function (event) {
		const link = event.target.closest ? event.target.closest('a[href]') : null;
		if (!link || !isPageNavigation(event, link)) {
			return;
		}
		// Short delay so instant responses never flash the overlay.
		window.clearTimeout(leaveTimer);
		leaveTimer = window.setTimeout(show, 140);
	});
})();

const lechfolioToggle = document.getElementById('lechfolio-menu-toggle');
const lechfolioMenu = document.getElementById('lechfolio-main-menu');

if (lechfolioToggle && lechfolioMenu) {
	const mobile = window.matchMedia('(max-width: 991px)');
	const dropdowns = [];

	/** Closes a branch and resets every nested disclosure. */
	function closeBranch(item) {
		item.classList.remove('lechfolio-submenu-open');
		item.querySelectorAll('.lechfolio-submenu-toggle').forEach(button => {
			button.setAttribute('aria-expanded', 'false');
			button.parentElement.classList.remove('lechfolio-submenu-open');
		});
	}

	/** Keeps mobile visibility and its announced state in sync. */
	function closeMenu() {
		lechfolioMenu.classList.remove('lechfolio-active');
		lechfolioToggle.setAttribute('aria-expanded', 'false');
		dropdowns.forEach(closeBranch);
	}

	lechfolioMenu.querySelectorAll('.sub-menu').forEach((submenu, index) => {
		const item = submenu.parentElement;
		const link = item.querySelector(':scope > a');
		if (!link) return;
		const button = document.createElement('button');
		button.type = 'button';
		button.className = 'lechfolio-submenu-toggle';
		submenu.id = submenu.id || `lechfolio-submenu-${index + 1}`;
		button.setAttribute('aria-controls', submenu.id);
		button.setAttribute('aria-expanded', 'false');
		button.setAttribute('aria-label', `${lechfolioMenu.dataset.submenuLabel || 'Submenu for'} ${link.textContent.trim()}`);
		item.classList.add('lechfolio-has-submenu');
		link.after(button);
		dropdowns.push(item);

		/** Opens this branch while closing sibling branches. */
		function openBranch() {
			Array.from(item.parentElement.children).forEach(sibling => {
				if (sibling !== item) closeBranch(sibling);
			});
			item.classList.add('lechfolio-submenu-open');
			button.setAttribute('aria-expanded', 'true');
		}

		button.addEventListener('click', () => {
			if (button.getAttribute('aria-expanded') === 'true') closeBranch(item);
			else openBranch();
		});
		item.addEventListener('pointerenter', event => {
			if (!mobile.matches && event.pointerType === 'mouse') openBranch();
		});
		item.addEventListener('pointerleave', event => {
			if (!mobile.matches && event.pointerType === 'mouse' && !item.contains(document.activeElement)) closeBranch(item);
		});
		item.addEventListener('focusout', event => {
			if (!item.contains(event.relatedTarget)) closeBranch(item);
		});
		item.addEventListener('keydown', event => {
			if (event.key === 'Escape' && button.getAttribute('aria-expanded') === 'true') {
				event.preventDefault();
				event.stopPropagation();
				closeBranch(item);
				button.focus();
			}
		});
	});
	lechfolioMenu.classList.add('lechfolio-menu-enhanced');

	lechfolioToggle.addEventListener('click', () => {
		const expanded = lechfolioToggle.getAttribute('aria-expanded') === 'true';
		closeMenu();
		if (!expanded) {
			lechfolioMenu.classList.add('lechfolio-active');
			lechfolioToggle.setAttribute('aria-expanded', 'true');
		}
	});
	document.addEventListener('click', event => {
		if (!lechfolioMenu.contains(event.target) && !lechfolioToggle.contains(event.target)) closeMenu();
	});
	document.addEventListener('keydown', event => {
		if (event.key === 'Escape' && lechfolioMenu.classList.contains('lechfolio-active')) {
			closeMenu();
			lechfolioToggle.focus();
		}
	});
	lechfolioMenu.addEventListener('focusout', event => {
		if (!lechfolioMenu.contains(event.relatedTarget) && event.relatedTarget !== lechfolioToggle) closeMenu();
	});
	mobile.addEventListener('change', closeMenu);
}

document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('[data-lechfolio-target]').forEach(trigger => {
		trigger.addEventListener('click', function (e) {
			const selector = trigger.getAttribute('data-lechfolio-target');
			const target = selector ? document.querySelector(selector) : null;

			if (!target) {
				return;
			}

			e.preventDefault();
			target.classList.toggle('lechfolio-active');
		});
	});
});
