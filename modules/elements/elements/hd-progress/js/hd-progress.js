/* Herzog Dupont for YOOtheme Pro Copyright (C) 2018-2023 Thomas Weidlich GNU GPL v3 */

UIkit.util.ready(() => {

	UIkit.util.$$('.hd-progess progress').forEach(bar => {

		UIkit.scrollspy(bar, { hidden: false });

		UIkit.util.on(bar, 'inview', function() {

			let bar   = this,
			    stop  = parseInt(bar.getAttribute('data-stop')),
			    step  = parseInt(bar.getAttribute('data-step')),
			    speed = parseInt(bar.getAttribute('data-speed'));

			let animate = setInterval(() => {

				bar.value += step;

				if (bar.value >= stop) {
					clearInterval(animate);
				}

			}, speed);

		});

	});

});