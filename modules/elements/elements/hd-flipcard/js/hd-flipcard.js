/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2023 Thomas Weidlich GNU GPL v3 */

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

UIkit.util.ready(() => {

	UIkit.util.$$('.hd-flipcard').forEach(el => {

		let evtType = 'mouse',
			flipMode = el.dataset.flipmode,
			flipModeTouch = el.dataset.flipmodetouch;

		el.addEventListener('pointerenter', e => {
			if (flipMode.includes('hover') && e.pointerType !== 'touch') {
				e.currentTarget.classList.add('hd-flipcard-hover');
			}
		});

		el.addEventListener('pointerleave', e => {
			if (flipMode.includes('hover') && e.pointerType !== 'touch') {
				e.currentTarget.classList.remove('hd-flipcard-hover');
			}
		});

		el.addEventListener('click', e => {
			if (flipMode.includes('click') && evtType !== 'touch' || flipModeTouch === 'tap' && evtType === 'touch') {
				if (e.currentTarget.classList.contains('hd-flipcard-hover') && e.target.tagName !== 'A') {
					e.currentTarget.classList.remove('hd-flipcard-hover');
				} else {
					e.currentTarget.classList.add('hd-flipcard-hover');
				}
			}
			evtType = 'mouse';
		});

		el.addEventListener('touchstart', e => {
			evtType = 'touch';
			if (flipModeTouch.includes('press')) {
				e.currentTarget.classList.add('hd-flipcard-hover');
			}
		});

		el.addEventListener('touchend', e => {
			evtType = 'touch';
			if (flipModeTouch.includes('press')) {
				e.currentTarget.classList.remove('hd-flipcard-hover');
			}
		});

	});

});