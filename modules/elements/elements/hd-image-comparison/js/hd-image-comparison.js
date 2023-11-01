/* Herzog Dupont for YOOtheme Pro Copyright (C) 2020-2023 Thomas Weidlich GNU GPL v3 */

class hdImgComp {

	constructor(el) {
		this.element = el;
		this.initialized = false;
		this.before = el.querySelector('.hd-image-comparison-before');
		this.beforeimg = el.querySelector('.hd-image-comparison-before img');
		this.afterimg = el.querySelector('.hd-image-comparison-after img');
		this.slider = el.querySelector('.hd-image-comparison-slider');
		this.iconWidth = parseInt(this.slider.getAttribute('uk-icon').split('height: ')[1]);
		if (!('marginRemove' in this.slider.dataset)) this.element.style.marginLeft = this.element.style.marginRight = this.iconWidth / 2 + 10 + 'px';
		this.range = document.createElement('input');
		this.range.type = 'range';
		this.range.min = '0';
		this.range.max = '100';
		this.range.value = this.slider.dataset.start ? this.slider.dataset.start : 50;
		this.range.style.marginLeft = `calc(-1 * (${this.slider.dataset.width}px + ${this.iconWidth}px) / 2)`;
		this.range.style.width = `calc(100% + (${this.slider.dataset.width}px + ${this.iconWidth}px))`;
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
		this.initialized = true;
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

	// add multiple event listeners for initialization because we don’t reliably know which image will be loaded first
	UIkit.util.on(x.beforeimg, 'load', () => { if (x.initialized === false) { x.init() } });
	UIkit.util.on(x.afterimg, 'load', () => { if (x.initialized === false) { x.init() } });
	// catch cases in which no image load event has been triggered or the images are loaded prior to the execution of the script 
	window.addEventListener('load', () => { if (x.initialized === false) { x.init() } });

});
