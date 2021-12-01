/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019–2021 Thomas Weidlich GNU GPL v3 */

function countUp(el, start, end, duration, separatorLocale) {

	let range = end - start;
	let stepTime = Math.abs(Math.floor(duration / range));

	let startTime = new Date().getTime();
	let endTime = startTime + duration;
	let timer;

	function count() {
		let now = new Date().getTime();
		let remaining = Math.max((endTime - now) / duration, 0);
		let value = Math.round(end - (remaining * range));
		el.innerHTML = (separatorLocale === undefined) ? value : value.toLocaleString(separatorLocale, {useGrouping: true });
		if (value == end) {
			clearInterval(timer);
		}
	}

	timer = setInterval(count, stepTime);
	count();
}

function startAnimation() {

	let counters = document.querySelectorAll('.counter-container');

	for (let i = 0; i < counters.length; i++) {

		let el = counters[i];

		if (!el.getAttribute('data-animated') && UIkit.util.isInView(el)) {

			let perimeter = 2 * Math.PI * el.dataset.radius,
			    circle    = el.querySelector('.counter-value'),
			    numberEl  = el.querySelector('.el-number'),
			    svg       = el.querySelector('.el-circle');

			if (svg) { svg.setAttribute('id', el.dataset.uniqid); }

			if (circle) {
				circle.style.strokeDashoffset = perimeter * (1 - el.dataset.percentage / 100);
				circle.style.strokeDasharray = perimeter;
			}

			if (numberEl) {
				countUp(numberEl, 0, el.dataset.number, parseInt(el.dataset.duration), el.dataset.separatorLocale);
			}

			el.setAttribute('data-animated', true);

		}

	}

};

UIkit.util.ready(function() {
	startAnimation();
	window.addEventListener('load', startAnimation, false);
	window.addEventListener('scroll', startAnimation, false);
	window.addEventListener('resize', startAnimation, false);
});
