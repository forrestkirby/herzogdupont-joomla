/* Herzog Dupont Copyright (C) 2019–2021 Thomas Weidlich GNU GPL v3 */

function setBackSize() {

	let flipcards = document.querySelectorAll('.hd-flipcard'),
		i = flipcards.length;

	while (i--) {

		let flipcard = flipcards[i],
			front = flipcard.querySelector('.el-card'),
			back = flipcard.querySelector('.el-card-back');

		front.style.removeProperty('min-height');
		back.style.removeProperty('height');


		if (front.offsetHeight < back.offsetHeight) {
			front.style.minHeight = back.offsetHeight + 'px';
		} else {
			back.style.height = '100%';
		}

	}

}

window.addEventListener('load', setBackSize);
window.addEventListener('resize', setBackSize);

UIkit.util.ready(function() {
	UIkit.util.$$('.hd-flipcard').forEach(el => {
		let flipMode = el.dataset.flipmode;
		UIkit.toggle(el, { mode: flipMode, cls: 'hd-flipcard-hover' });
	});
});