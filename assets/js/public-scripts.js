/**
 * Public interactions for the LechFolio container theme.
 *
 * Handles the loader, mobile menu, and simple plugin dialog triggers.
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
	lechfolioToggle.addEventListener('click', () => {
		lechfolioMenu.classList.toggle('lechfolio-active');
	});
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
