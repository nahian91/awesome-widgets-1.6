(function () {
	'use strict';

	function awea_accordion_init(root) {
		if (!root || root.dataset.aweaAccordionBound === '1') {
			return;
		}
		root.dataset.aweaAccordionBound = '1';

		var isMultiple = root.getAttribute('data-awea_accordion_multiple') === 'true';
		var headers = root.querySelectorAll('.awea_accordion_header');

		headers.forEach(function (header) {
			header.addEventListener('click', function () {
				var item = header.closest('.awea_accordion_item');
				var panel = item ? item.querySelector('.awea_accordion_collapse') : null;
				var isActive = item.classList.contains('awea_accordion_is_active');

				if (isActive) {
					item.classList.remove('awea_accordion_is_active');
					header.setAttribute('aria-expanded', 'false');
					if (panel) {
						panel.setAttribute('aria-hidden', 'true');
						panel.setAttribute('inert', '');
					}
				} else {
					if (!isMultiple) {
						root.querySelectorAll('.awea_accordion_item').forEach(function (other) {
							other.classList.remove('awea_accordion_is_active');
							var otherBtn = other.querySelector('.awea_accordion_header');
							var otherPanel = other.querySelector('.awea_accordion_collapse');
							if (otherBtn) {
								otherBtn.setAttribute('aria-expanded', 'false');
							}
							if (otherPanel) {
								otherPanel.setAttribute('aria-hidden', 'true');
								otherPanel.setAttribute('inert', '');
							}
						});
					}
					item.classList.add('awea_accordion_is_active');
					header.setAttribute('aria-expanded', 'true');
					if (panel) {
						panel.setAttribute('aria-hidden', 'false');
						panel.removeAttribute('inert');
					}
				}
			});
		});
	}

	function awea_accordion_init_all() {
		document.querySelectorAll('.awea_accordion_wrap').forEach(awea_accordion_init);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', awea_accordion_init_all);
	} else {
		awea_accordion_init_all();
	}

	if (window.elementorFrontend && window.elementorFrontend.hooks) {
		window.elementorFrontend.hooks.addAction(
			'frontend/element_ready/awesome-accordion.default',
			function ($scope) {
				var el = $scope && $scope[0] ? $scope[0].querySelector('.awea_accordion_wrap') : null;
				awea_accordion_init(el);
			}
		);
	}
})();