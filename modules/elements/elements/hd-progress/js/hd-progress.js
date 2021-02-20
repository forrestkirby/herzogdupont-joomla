UIkit.util.ready(function() {

	UIkit.util.$$('.hd-progess progress').forEach(function(bar) {

		UIkit.scrollspy(bar, { hidden: false });

		UIkit.util.on(bar, 'inview', function() {

			let bar   = this,
			    step  = parseInt(bar.getAttribute('data-step')),
			    stop  = parseInt(bar.getAttribute('data-stop')),
			    speed = parseInt(bar.getAttribute('data-speed'));

			let animate = setInterval(function() {

				bar.value += step;

				if (bar.value >= stop) {
					clearInterval(animate);
				}

			}, speed);

		});

	});

});