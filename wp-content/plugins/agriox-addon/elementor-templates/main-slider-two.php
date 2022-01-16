<?php if ('layout_two' === $settings['layout_type']) : ?>

     <!--Main Slider Start-->
	 <section class="main-slider main-slider-one main-slider-one--two">
            <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true, "effect": "fade", "pagination": {
            "el": "#main-slider-pagination",
            "type": "bullets",
            "clickable": true
            },
            "navigation": {
            "nextEl": "#main-slider__swiper-button-next",
            "prevEl": "#main-slider__swiper-button-prev"
            },
            "autoplay": {
            "delay": 7000
            }}'>

			<div class="swiper-wrapper">
			<?php foreach ($settings['sliders'] as $slider) : ?>
				<!--Start Single Swiper Slide-->
				<div class="swiper-slide">
					<div class="image-layer"
						style="background-image: url(<?php echo esc_url($slider['background_image']['url']); ?>);"></div>
					<div class="image-layer-overlay"></div>
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="main-slider-inner text-center">
									<div class="main-slider__content">
									<?php if (!empty($slider['sub_title'])) : ?>
										<span class="main-slider-tagline"><?php echo wp_kses($slider['sub_title'], 'agriox_allowed_tags'); ?></span>
									<?php endif; ?>
									<?php if (!empty($slider['title'])) : ?>
										<h2 class="main-slider__title"><?php echo wp_kses($slider['title'], 'agriox_allowed_tags'); ?></h2>
									<?php endif; ?>
									</div>
									<?php if (!empty($slider['button_label'])) : ?>
										<div class="main-slider__button-box">
											<a href="<?php echo esc_url($slider['button_url']['url']); ?>" class="thm-btn"><?php echo esc_html($slider['button_label']); ?></a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--End Single Swiper Slide-->
			<?php endforeach; ?>
			</div>
			<!-- If we need navigation buttons -->
			<div class="swiper-pagination" id="main-slider-pagination"></div>

			<div class="main-slider__nav">
				<div class="swiper-button-prev" id="main-slider__swiper-button-next">
					<span class="icon-right-arrow-2"></span>
				</div>
				<div class="swiper-button-next" id="main-slider__swiper-button-prev">
					<span class="icon-right-arrow-2"></span>
				</div>
			</div>
		</div>
	</section>
	<!--Main Slider End-->

<?php endif; ?>