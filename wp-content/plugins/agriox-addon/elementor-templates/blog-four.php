<?php if ('layout_four' == $settings['layout_type']) : ?>

		<!--Blog One Start-->
		<section class="blog-one">
			<div class="container">
			<?php if( !empty( $settings[ 'title' ] ) || !empty( $settings[ 'sub_title' ] ) ) : ?>
				<div class="sec-title text-center">
				 <?php if( !empty( $settings[ 'icon_image' ][ 'url' ] ) ) : ?>
						<div class="icon">
							<img src="<?php echo esc_url( $settings[ 'icon_image' ][ 'url' ] ); ?>" 
							alt="<?php echo esc_attr( agriox_get_thumbnail_alt( $settings[ 'icon_image' ][ 'id' ] ) ); ?>">
						</div>
					<?php endif; ?>
				   <?php if( !empty( $settings[ 'sub_title' ] ) ) : ?>
					   <span class="sec-title__tagline"><?php echo wp_kses( $settings[ 'sub_title' ], 'agriox_allowed_tags' ); ?></span>
					<?php endif; ?>
					<?php if( !empty( $settings[ 'title' ] ) ) : ?>
						<h2 class="sec-title__title"><?php echo wp_kses( $settings[ 'title' ], 'agriox_allowed_tags' ); ?></h2>
					<?php endif; ?>
				</div>
			<?php endif; ?>
				<div class="row">
				<?php
				$blog_post_one_query_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				$blog_post_one_query_args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'ignore_sticky_posts' => true,
					'orderby' => 'date',
					'order'   => $settings['query_order'],
					'paged'          => $blog_post_one_query_paged,
					'posts_per_page' => $settings['post_count']['size']
				);

				$blog_post_one_query = new \WP_Query($blog_post_one_query_args);
				?>
				<?php while ($blog_post_one_query->have_posts()) :
				$blog_post_one_query->the_post(); ?>
					<!--Start Single Blog One-->
					<div class="col-xl-4 col-lg-4  wow fadeInLeft" data-wow-delay="0ms">
						<div class="blog-one__single">
							<div class="blog-one__single-img">
								<?php the_post_thumbnail( 'agriox_blog_370X271' ); ?>
								<div class="date-box">
									<span><?php the_time( 'd M, Y' ); ?></span>
								</div>
								<div class="overlay-icon">
									<a href="<?php the_permalink(); ?>"><span class="icon-plus"></span></a>
								</div>
							</div>

							<div class="blog-one__single-content">
								<ul class="meta-info list-unstyled">
									<li><?php agriox_posted_by(); ?></li>
									<?php if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) : ?>
											<li><?php agriox_comment_count(); ?></li>
									<?php endif; ?>
								</ul>
								<h2><a href="<?php the_permalink(); ?>">
									<?php echo wp_kses( get_the_title(), 'agriox_allowed_tags' ); ?>
								</a>
								</h2>
							</div>
						</div>
					</div>
					<!--End Single Blog One-->
					<?php endwhile; ?>
					<?php if ('yes' == $settings['pagination_status']) : ?>
						<div class="col-lg-12">
							<div class="blog-pagination portfolio-page__btn-box justify-content-center">
								<?php agriox_custom_query_pagination($blog_post_one_query_paged, $blog_post_one_query->max_num_pages); ?>
							</div><!-- /.blog-post-pagination -->
						</div><!-- /.col-lg-12 -->
					<?php endif; ?>
				 <?php wp_reset_postdata(); ?>
				</div>
			</div>
		</section>
		<!--Blog One End-->

<?php endif; ?>