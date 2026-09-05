/* Wanko Corporate – front-end behaviour (no dependencies). */
(function () {
	'use strict';

	var body = document.body;
	var toggle = document.querySelector('.menu-toggle');
	var nav = document.getElementById('global-nav');

	// Mobile navigation.
	if (toggle && nav) {
		var closeNav = function () {
			toggle.setAttribute('aria-expanded', 'false');
			nav.classList.remove('is-open');
			body.classList.remove('nav-open');
		};
		toggle.addEventListener('click', function () {
			var open = toggle.getAttribute('aria-expanded') === 'true';
			toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
			nav.classList.toggle('is-open', !open);
			body.classList.toggle('nav-open', !open);
		});
		nav.addEventListener('click', function (e) {
			if (e.target.closest('a')) {
				closeNav();
			}
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				closeNav();
			}
		});
		window.addEventListener('resize', function () {
			if (window.innerWidth > 860) {
				closeNav();
			}
		});
	}

	// MV slideshow (crossfade every 3.5s; pauses when the tab is hidden).
	var slidesWrap = document.querySelector('[data-hero-slides]');
	var slides = slidesWrap ? slidesWrap.querySelectorAll('.hero__slide') : [];
	if (slides.length > 1) {
		var current = 0;
		var timer = null;
		var next = function () {
			slides[current].classList.remove('is-active');
			current = (current + 1) % slides.length;
			slides[current].classList.add('is-active');
		};
		var start = function () { if (!timer) { timer = window.setInterval(next, 3500); } };
		var stop = function () { if (timer) { window.clearInterval(timer); timer = null; } };
		document.addEventListener('visibilitychange', function () { document.hidden ? stop() : start(); });
		start();
	}

	// Back to top.
	var toTop = document.querySelector('.to-top');
	if (toTop) {
		var onScroll = function () {
			toTop.classList.toggle('is-visible', window.scrollY > 400);
		};
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
		toTop.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}

	// Scroll reveal for sections and cards.
	var targets = document.querySelectorAll('.section-title, .shop-card, .card, .promise-item, .value-card, .link-tile, .news-item, .feature, .greeting, .spec-table');
	if ('IntersectionObserver' in window && targets.length) {
		targets.forEach(function (el, i) {
			el.setAttribute('data-reveal', '');
			el.style.transitionDelay = (i % 3) * 80 + 'ms';
		});
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-in');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -10% 0px' });
		targets.forEach(function (el) { io.observe(el); });
		// Safety net: never leave content hidden (print, very slow devices, etc.).
		setTimeout(function () {
			targets.forEach(function (el) { el.classList.add('is-in'); });
		}, 2000);
	}

	// Offset in-page anchors for the sticky header.
	var header = document.getElementById('site-header');
	var anchorNav = document.querySelector('.anchor-nav');
	var offset = function () {
		return (header ? header.offsetHeight : 0) + (anchorNav ? anchorNav.offsetHeight : 0) + 12;
	};
	document.querySelectorAll('a[href*="#"]').forEach(function (a) {
		a.addEventListener('click', function (e) {
			var url = new URL(a.href, location.href);
			if (url.pathname !== location.pathname || !url.hash) {
				return;
			}
			var target = document.querySelector(url.hash);
			if (!target) {
				return;
			}
			e.preventDefault();
			var top = target.getBoundingClientRect().top + window.scrollY - offset();
			window.scrollTo({ top: top, behavior: 'smooth' });
			history.pushState(null, '', url.hash);
		});
	});
	if (location.hash) {
		var t = document.querySelector(location.hash);
		if (t) {
			setTimeout(function () {
				window.scrollTo({ top: t.getBoundingClientRect().top + window.scrollY - offset(), behavior: 'auto' });
			}, 50);
		}
	}
})();

/* Column: auto table of contents from h2/h3 */
(function () {
	'use strict';
	var toc = document.querySelector('[data-toc]');
	var src = document.querySelector('[data-toc-source]');
	if (!toc || !src) { return; }
	var heads = src.querySelectorAll('h2, h3');
	if (heads.length < 2) { return; }
	var list = toc.querySelector('.toc__list');
	heads.forEach(function (h, i) {
		if (!h.id) { h.id = 'sec-' + (i + 1); }
		var li = document.createElement('li');
		if (h.tagName === 'H3') { li.className = 'is-sub'; }
		var a = document.createElement('a');
		a.href = '#' + h.id;
		a.textContent = h.textContent;
		li.appendChild(a);
		list.appendChild(li);
	});
	toc.hidden = false;
})();

/* Product gallery: swap the main image */
(function () {
	'use strict';
	var g = document.querySelector('[data-gallery]');
	if (!g) { return; }
	var main = g.querySelector('[data-gallery-main]');
	g.querySelectorAll('.product__thumbs button').forEach(function (btn) {
		btn.addEventListener('click', function () {
			if (!main) { return; }
			main.src = btn.getAttribute('data-full');
			main.removeAttribute('srcset');
			g.querySelectorAll('.product__thumbs button').forEach(function (b) { b.classList.remove('is-active'); });
			btn.classList.add('is-active');
		});
	});
})();
