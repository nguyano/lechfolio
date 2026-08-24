/**
 * Public interactions for the LechFolio container theme.
 *
 * Handles loader, mobile menu, dropdowns, and simple plugin dialog triggers.
 */
window.addEventListener('load', function () {
    const loader = document.getElementById('lechfolio-loader');
    if (loader) {
      loader.classList.add('hide');
    }
});


//dropdown menu toggle
const lechfolioToggle = document.getElementById('lechfolio-menu-toggle');
const lechfolioMenu = document.getElementById('lechfolio-main-menu');

if (lechfolioToggle && lechfolioMenu) {
	lechfolioToggle.addEventListener('click', () => {
		lechfolioMenu.classList.toggle('lechfolio-active');
	});
}

document.addEventListener('DOMContentLoaded', function () {
	// Keep theme-owned dropdowns active even when Coshelters exposes its frontend global.
	document.addEventListener('click', function (e) {
		const toggle = e.target.closest('.lechfolio-dropdown-toggle');
		const activeDropdown = toggle ? toggle.closest('.lechfolio-dropdown, .coshlt-dropdown') : null;

		const setDropdownMenuVisible = (dropdown, visible) => {
			const menu = dropdown ? dropdown.querySelector('.lechfolio-dropdown-menu') : null;
			if (!menu) {
				return;
			}

			menu.style.display = visible ? 'block' : '';
			menu.style.visibility = visible ? 'visible' : '';
			menu.style.opacity = visible ? '1' : '';
			menu.style.pointerEvents = visible ? 'auto' : '';
		};

		document.querySelectorAll('.lechfolio-dropdown.open, .lechfolio-dropdown.is-open, .coshlt-dropdown.open, .coshlt-dropdown.is-open').forEach(dropdown => {
			if (dropdown !== activeDropdown) {
				dropdown.classList.remove('open');
				dropdown.classList.remove('is-open');
				setDropdownMenuVisible(dropdown, false);
				const openToggle = dropdown.querySelector('.lechfolio-dropdown-toggle');
				if (openToggle) {
					openToggle.setAttribute('aria-expanded', 'false');
				}
			}
		});

		if (!toggle || !activeDropdown) {
			return;
		}

		e.preventDefault();
		const isOpen = activeDropdown.classList.toggle('open');
		activeDropdown.classList.toggle('is-open', isOpen);
		setDropdownMenuVisible(activeDropdown, isOpen);
		toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
	});

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
