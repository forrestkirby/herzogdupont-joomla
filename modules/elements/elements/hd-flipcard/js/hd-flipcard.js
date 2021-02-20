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

};

window.addEventListener('load', setBackSize);
window.addEventListener('resize', setBackSize);

UIkit.util.ready(function() {
	UIkit.util.$$('.hd-flipcard').forEach(el => {
		el.addEventListener('mouseenter', e => {
			e.currentTarget.classList.add('hd-flipcard-hover');
		});
		el.addEventListener('mouseleave', e => {
			e.currentTarget.classList.remove('hd-flipcard-hover');
		});
		el.addEventListener('touchend', e => {
			if (e.currentTarget.classList.contains('hd-flipcard-hover')) {
				e.currentTarget.classList.remove('hd-flipcard-hover');
			} else {
				e.currentTarget.classList.add('hd-flipcard-hover');
			}
		});
	});
})
