<div class="footer-one__bottom">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="footer-one__bottom-inner">
                    <div class="footer-one__bottom-text">
                        <p><?php echo wp_kses($settings['title'], 'agriox_allowed_tags'); ?></p>
                    </div>
                    <?php if( is_array( $settings[ 'social_icons' ] ) ) : ?>
                        <div class="footer-one__bottom-social-links">
                            <ul class="list-unstyled">
                                <?php foreach( $settings[ 'social_icons' ] as $item ): ?>
                                   <li><a href="<?php echo esc_url( $item[ 'social_url' ][ 'url' ] ); ?>"><i class="fab <?php echo esc_attr(  $item[ 'social_icon' ] ); ?>"></i></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>