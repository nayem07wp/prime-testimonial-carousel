/**
 * Prime Testimonial Carousel - Public Script
 * Vanilla JS, no dependencies. Touch & keyboard friendly.
 */
(function () {
	'use strict';

	function PtcrslCarousel(element) {
		this.el = element;
		this.track = element.querySelector('.ptcrsl-carousel-track');
		this.items = element.querySelectorAll('.ptcrsl-item');
		this.prevBtn = element.querySelector('.ptcrsl-arrow-prev');
		this.nextBtn = element.querySelector('.ptcrsl-arrow-next');
		this.dotsContainer = element.querySelector('.ptcrsl-dots');

		// Grid/masonry layouts don't need carousel logic.
		if (!this.track || !this.items.length) {
			return;
		}

		var cfg = {};
		try {
			cfg = JSON.parse(element.getAttribute('data-config') || '{}');
		} catch (e) {
			cfg = {};
		}

		this.config = {
			autoplay: cfg.autoplay !== false,
			autoplaySpeed: cfg.autoplaySpeed || 5000,
			loop: cfg.loop !== false,
			columns: cfg.columns || 3
		};

		this.currentIndex = 0;
		this.autoplayTimer = null;
		this.isPaused = false;

		this.init();
	}

	PtcrslCarousel.prototype.init = function () {
		this.calculateVisibleItems();
		this.buildDots();
		this.bindEvents();
		this.updateSlide();

		if (this.config.autoplay) {
			this.startAutoplay();
		}

		// Recalculate on resize.
		var self = this;
		var resizeTimer;
		window.addEventListener('resize', function () {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function () {
				self.calculateVisibleItems();
				self.buildDots();
				self.updateSlide();
			}, 200);
		});
	};

	PtcrslCarousel.prototype.calculateVisibleItems = function () {
		var width = window.innerWidth;
		if (width <= 640) {
			this.visibleItems = 1;
		} else if (width <= 1024) {
			this.visibleItems = Math.min(2, this.config.columns);
		} else {
			this.visibleItems = this.config.columns;
		}
		this.maxIndex = Math.max(0, this.items.length - this.visibleItems);
	};

	PtcrslCarousel.prototype.buildDots = function () {
		if (!this.dotsContainer) return;

		this.dotsContainer.innerHTML = '';
		var totalDots = this.maxIndex + 1;

		for (var i = 0; i < totalDots; i++) {
			var dot = document.createElement('button');
			dot.type = 'button';
			dot.className = 'ptcrsl-dot';
			dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
			dot.setAttribute('data-index', i);
			var self = this;
			(function (idx) {
				dot.addEventListener('click', function () {
					self.goTo(idx);
					self.resetAutoplay();
				});
			})(i);
			this.dotsContainer.appendChild(dot);
		}
	};

	PtcrslCarousel.prototype.bindEvents = function () {
		var self = this;

		if (this.prevBtn) {
			this.prevBtn.addEventListener('click', function () {
				self.prev();
				self.resetAutoplay();
			});
		}

		if (this.nextBtn) {
			this.nextBtn.addEventListener('click', function () {
				self.next();
				self.resetAutoplay();
			});
		}

		// Pause on hover.
		this.el.addEventListener('mouseenter', function () {
			self.isPaused = true;
		});
		this.el.addEventListener('mouseleave', function () {
			self.isPaused = false;
		});

		// Keyboard navigation.
		this.el.setAttribute('tabindex', '0');
		this.el.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowLeft') {
				e.preventDefault();
				self.prev();
				self.resetAutoplay();
			} else if (e.key === 'ArrowRight') {
				e.preventDefault();
				self.next();
				self.resetAutoplay();
			}
		});

		// Touch/swipe support.
		var startX = 0;
		var startY = 0;
		var isSwiping = false;

		this.el.addEventListener('touchstart', function (e) {
			startX = e.touches[0].clientX;
			startY = e.touches[0].clientY;
			isSwiping = true;
		}, { passive: true });

		this.el.addEventListener('touchmove', function (e) {
			if (!isSwiping) return;
			var diffY = Math.abs(e.touches[0].clientY - startY);
			var diffX = Math.abs(e.touches[0].clientX - startX);
			// If vertical scroll intent, cancel swipe.
			if (diffY > diffX) {
				isSwiping = false;
			}
		}, { passive: true });

		this.el.addEventListener('touchend', function (e) {
			if (!isSwiping) return;
			var endX = e.changedTouches[0].clientX;
			var diff = startX - endX;
			if (Math.abs(diff) > 50) {
				if (diff > 0) {
					self.next();
				} else {
					self.prev();
				}
				self.resetAutoplay();
			}
			isSwiping = false;
		});

		// Pause on focus within carousel (accessibility).
		this.el.addEventListener('focusin', function () {
			self.isPaused = true;
		});
		this.el.addEventListener('focusout', function () {
			self.isPaused = false;
		});
	};

	PtcrslCarousel.prototype.updateSlide = function () {
		var offset = -(this.currentIndex * (100 / this.visibleItems));
		this.track.style.transform = 'translateX(' + offset + '%)';

		// Update dots.
		if (this.dotsContainer) {
			var dots = this.dotsContainer.querySelectorAll('.ptcrsl-dot');
			for (var i = 0; i < dots.length; i++) {
				if (i === this.currentIndex) {
					dots[i].classList.add('ptcrsl-dot-active');
					dots[i].setAttribute('aria-current', 'true');
				} else {
					dots[i].classList.remove('ptcrsl-dot-active');
					dots[i].removeAttribute('aria-current');
				}
			}
		}

		// Update arrows (disabled state if no loop).
		if (!this.config.loop) {
			if (this.prevBtn) this.prevBtn.disabled = this.currentIndex === 0;
			if (this.nextBtn) this.nextBtn.disabled = this.currentIndex >= this.maxIndex;
		}
	};

	PtcrslCarousel.prototype.next = function () {
		if (this.currentIndex >= this.maxIndex) {
			if (this.config.loop) {
				this.currentIndex = 0;
			} else {
				return;
			}
		} else {
			this.currentIndex++;
		}
		this.updateSlide();
	};

	PtcrslCarousel.prototype.prev = function () {
		if (this.currentIndex <= 0) {
			if (this.config.loop) {
				this.currentIndex = this.maxIndex;
			} else {
				return;
			}
		} else {
			this.currentIndex--;
		}
		this.updateSlide();
	};

	PtcrslCarousel.prototype.goTo = function (index) {
		this.currentIndex = Math.max(0, Math.min(index, this.maxIndex));
		this.updateSlide();
	};

	PtcrslCarousel.prototype.startAutoplay = function () {
		var self = this;
		this.stopAutoplay();
		this.autoplayTimer = setInterval(function () {
			if (!self.isPaused && !document.hidden) {
				self.next();
			}
		}, this.config.autoplaySpeed);
	};

	PtcrslCarousel.prototype.stopAutoplay = function () {
		if (this.autoplayTimer) {
			clearInterval(this.autoplayTimer);
			this.autoplayTimer = null;
		}
	};

	PtcrslCarousel.prototype.resetAutoplay = function () {
		if (this.config.autoplay) {
			this.startAutoplay();
		}
	};

	// Initialize all carousels on page.
	function init() {
		var carousels = document.querySelectorAll('.ptcrsl-carousel');
		for (var i = 0; i < carousels.length; i++) {
			new PtcrslCarousel(carousels[i]);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
