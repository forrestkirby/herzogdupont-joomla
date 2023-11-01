/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2023 Thomas Weidlich GNU GPL v3 */

class hdLottie {

	constructor(el) {
		this.player = el.querySelector('.el-lottie');
		this.name = this.player.dataset.name;
		this.path = this.player.dataset.animationPath;
		this.renderer = this.player.dataset.renderer;
		this.trigger = this.player.dataset.trigger;
		// scrollspy does not trigger if offsetTop > 0.5vh, so we limit it to 300
		this.offsetTop = this.player.dataset.offsetTop ? Math.min(Math.abs(parseInt(this.player.dataset.offsetTop)), 300) * -1 : 0;
		this.loop = this.player.hasAttribute('data-loop');
		this.speed = this.player.dataset.speed ? Math.abs(parseFloat(this.player.dataset.speed)) : 1;
		this.step = 0;
		this.isComplete = false;
		this.rendererSettings = {};
		this.rendererSettings.preserveAspectRatio = this.player.dataset.preserveAspectRatioAlignmentValue + ' ' + this.player.dataset.preserveAspectRatioReference;
	}

	init() {
		let anim = lottie.loadAnimation({
			container: this.player,
			name: this.name,
			path: this.path,
			renderer: this.renderer,
			autoplay: false,
			loop: this.trigger === 'mouseenter' ? false : this.loop,
			rendererSettings: this.rendererSettings
		});

		let handleMouseEnter = this.handleMouseEnter.bind(this, anim);
		let handleMouseLeave = this.handleMouseLeave.bind(this, anim);

		anim.addEventListener('complete', () => {
			this.isComplete = true;

			if (this.loop) this.playOnMouseEnter(anim);

			else {
				this.player.removeEventListener('mouseenter', handleMouseEnter);
				this.player.removeEventListener('mouseleave', handleMouseLeave);
			}
		});

		anim.addEventListener('DOMLoaded', () => {
			// we don’t take absolute values for start and end frame, but values relative to the total frames
			this.animationStart = this.player.dataset.animationStart ? Math.ceil(anim.totalFrames * Math.min(Math.max(this.player.dataset.animationStart, 0), 100) / 100) : anim.firstFrame;
			this.animationEnd = this.player.dataset.animationEnd ? Math.floor(anim.totalFrames * Math.min(Math.max(this.player.dataset.animationEnd, 0), 100) / 100) : anim.totalFrames;
			this.initialFirstFrame = anim.firstFrame;
			this.initialTotalFrames = anim.totalFrames;
			anim.initialSegment = [this.animationStart, this.animationEnd];
			anim.setSpeed(this.speed);

			// make sure that the start frame is displayed, not the first frame
			anim.goToAndStop(this.animationStart, true);

			switch (this.trigger) {
				case 'autoplay':
					anim.playSegments(anim.initialSegment, true);
					break;
				case 'inview':
					if (UIkit.util.isVisible(this.player)) {
						anim.playSegments(anim.initialSegment, true);
					} else {
						window.addEventListener('scroll', () => {
							if (UIkit.util.isVisible(this.player) && !this.isComplete) {
								anim.playSegments(anim.initialSegment, true);
								this.isComplete = true;
							}
						});
					}

					break;
				case 'click':
					this.player.addEventListener('click', () => {
						anim.playSegments(anim.initialSegment, true);
					}, { once: true });

					break;
				case 'mouseenter':
					let once = this.player.dataset.onMouseleave === 'pause' ? { once: false } : { once: true };

					this.player.addEventListener('mouseenter', handleMouseEnter, once);

					if (this.player.dataset.onMouseleave === 'pause') {
						this.player.addEventListener('mouseleave', handleMouseLeave);
					}

					break;
				case 'scroll':
					window.addEventListener('scroll', () => {
						this.step = Math.floor((UIkit.util.scrolledOver(this.player) * (this.animationEnd - this.animationStart) + this.animationStart));
						anim.goToAndStop(this.step, true);
					});

					break;
				default:
					// do nothing
			}
		});

	}

	handleMouseEnter(anim) {
		if (this.player.dataset.onMouseleave !== 'pause') anim.playSegments(anim.initialSegment, true);
		else this.playOnMouseEnter(anim);
	}

	handleMouseLeave(anim) {
		anim.pause();
	}

	playOnMouseEnter(anim) {
		// calculate the correct starting and end points for the animation, thank you Elementor Pro
		let currentFrame = anim.firstFrame === 0 ? anim.currentFrame : anim.firstFrame + anim.currentFrame,
			firstFrame = this.initialFirstFrame,
			lastFrame = this.initialFirstFrame === 0 ? this.initialTotalFrames : this.initialFirstFrame + this.initialTotalFrames;

		if (this.animationStart > firstFrame) {
			firstFrame = this.animationStart;
		}

		if (this.animationEnd < lastFrame) {
			lastFrame = this.animationEnd;
		}

		if (!this.isComplete) {
			firstFrame = this.animationStart > currentFrame ? this.animationStart : currentFrame;
		}

		anim.stop();
		anim.playSegments([firstFrame, lastFrame], true);

		this.isComplete = false;
	}


}

UIkit.util.$$('.hd-lottie').forEach(el => {
	let x = new hdLottie(el);
	x.init();

	if (x.renderer === 'canvas')
		window.addEventListener('resize', () => {
			lottie.resize(x.name);
		})
});
