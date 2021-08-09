/* Herzog Dupont Copyright (C) 2020–2021 Thomas Weidlich GNU GPL v3 */

class hdImgComp {

	constructor(el) {
		this.element = el;
		this.before = el.querySelector('.hd-image-comparison-before');
		this.beforeimg = el.querySelector('.hd-image-comparison-before img');
		this.afterimg = el.querySelector('.hd-image-comparison-after img');
		this.slider = el.querySelector('.hd-image-comparison-slider');
		this.iconWidth = parseInt(this.slider.getAttribute('uk-icon').split('height: ')[1]);
		this.element.style.marginLeft = this.iconWidth + 'px';
		this.element.style.marginRight = this.iconWidth + 'px';
		this.range = document.createElement('input');
		this.range.type = 'range';
		this.range.min = '0';
		this.range.max = '100';
		this.range.value = this.slider.dataset.start ? this.slider.dataset.start : 50;
		this.range.style.marginLeft = `calc(-1 * (${this.slider.dataset.width}px + 20px) / 2)`;
		this.range.style.width = `calc(100% + (${this.slider.dataset.width}px + 20px))`;
		this.range.classList.add('hd-image-comparison-range');
		el.insertBefore(this.range, this.slider);
	}

	init() {
		// set initial sizes and positions
		this.setSizePos();
		// add event listeners
		this.range.addEventListener('input', () => { this.slide() });
		if (this.slider.dataset.onmousemove) {
			this.range.addEventListener('mousemove', (e) => { this.slideOnMousemove(e) });
		}
		window.addEventListener('resize', () => { this.setSizePos() });
		window.addEventListener('orientationchange', () => { this.setSizePos() });
	}

	setSizePos() {
		// reset width of element container
		this.element.style.width = 'auto';
		// set size of before image container
		this.before.style.height = `${this.afterimg.clientHeight}px`;
		this.before.style.width = `${this.range.value}%`;
		// set width of before image
		this.beforeimg.style.width = `${this.afterimg.clientWidth}px`;
		// set position of slider
		this.slider.style.left = `${this.range.value}%`;
	}

	slideOnMousemove(e) {
		let rect = this.range.getBoundingClientRect();
		let newWidth = Math.round((e.clientX - rect.left - this.iconWidth) / (rect.right - rect.left - this.iconWidth * 2) * 100);
		this.range.value = newWidth;
		this.slide();
	}

	slide() {
		// update width of before image container
		this.before.style.width = `${this.range.value}%`;
		// update position of slider
		this.slider.style.left = `${this.range.value}%`;
	}

}

UIkit.util.$$('.hd-image-comparison').forEach(el => {

	let x = new hdImgComp(el);

	if (x.afterimg.complete && x.beforeimg.complete && x.afterimg.clientHeight > 1)
		x.init()
	else
		UIkit.util.on(x.afterimg, 'load', () => { x.init() });

});