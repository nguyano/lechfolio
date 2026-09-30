/**
 * Public interactions for the LechFolio container theme.
 *
 * Handles the loader, accessible nested navigation, and plugin dialog triggers.
 */
window.addEventListener('load', function () {
    const loader = document.getElementById('lechfolio-loader');
    if (loader) {
      loader.classList.add('hide');
    }
});

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
