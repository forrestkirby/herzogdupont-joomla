/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2023 Thomas Weidlich GNU GPL v3 */

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
		el.innerHTML = (separatorLocale === undefined) ? value : value.toLocaleString(separatorLocale, { useGrouping: true });
		if (value == end) {
			clearInterval(timer);
		}
	}

	timer = setInterval(count, stepTime);
	count();
}

UIkit.util.ready(_ => {
	// Register IntersectionObserver
	const io = new IntersectionObserver((entries) => {
		entries.forEach((entry) => {
			let el = entry.target;
			if (entry.intersectionRatio > 0 && !el.getAttribute('data-animated')) {
				let perimeter = 2 * Math.PI * el.dataset.radius,
					circle = el.querySelector('.counter-value'),
					numberEl = el.querySelector('.el-number'),
					svg = el.querySelector('.el-circle');

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
		});
	});

	// Declares what to observe, and observes its properties.
	const counterElList = document.querySelectorAll('.counter-container');
	counterElList.forEach((el) => {
		io.observe(el);
	});
});