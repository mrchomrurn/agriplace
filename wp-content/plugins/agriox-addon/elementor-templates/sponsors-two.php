<?php if ('layout_two' == $settings['layout_type']) : ?>
    <section class="company-logos-one company-logos-one--gray">
			<div class="container">
				<div class="thm-swiper__slider swiper-container" data-swiper-options='{"spaceBetween": 100, "slidesPerView": 5, "autoplay": { "delay": 5000 }, "breakpoints": {
                "0": {
                    "spaceBetween": 20,
                    "slidesPerView": 2
                },
                "375": {
                    "spaceBetween": 20,
                    "slidesPerView": 2
                },
                "575": {
                    "spaceBetween": 20,
                    "slidesPerView": 3
                },
                "767": {
                    "spaceBetween": 30,
                    "slidesPerView": 4
                },
                "991": {
                    "spaceBetween": 40,
                    "slidesPerView": 5
                },
                "1199": {
                    "spaceBetween": 40,
                    "slidesPerView": 5
                }
            }}'>
                <div class="swiper-wrapper">
                    <?php foreach ($settings['sponsor_images'] as $image) : ?>
                            <div class="swiper-slide">
                               <?php echo wp_get_attachment_image($image['image']['id'], 'agriox_brand_logo_125X24'); ?>
                            </div><!-- /.swiper-slide -->
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
