// start the Stimulus application
import './stimulus_bootstrap.js';
import './styles/app.scss';
import 'highlight.js/styles/github-dark-dimmed.css';
import 'lato-font/css/lato-font.css';

// loads the Bootstrap plugins
import * as bootstrap from 'bootstrap';

// loads the code syntax highlighting library
import './js/highlight.js';

// Creates links to the Symfony documentation
import './js/doclinks.js';

import './js/flatpicker.js';

function initializeNavbarDropdowns() {
	document.querySelectorAll('.app-navbar [data-bs-toggle="dropdown"]').forEach((toggle) => {
		if (toggle.dataset.dropdownInitialized === 'true') {
			return;
		}

		bootstrap.Dropdown.getOrCreateInstance(toggle);
		toggle.addEventListener('click', (event) => {
			event.preventDefault();
			bootstrap.Dropdown.getOrCreateInstance(toggle).toggle();
		});
		toggle.dataset.dropdownInitialized = 'true';
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', initializeNavbarDropdowns, { once: true });
} else {
	initializeNavbarDropdowns();
}

