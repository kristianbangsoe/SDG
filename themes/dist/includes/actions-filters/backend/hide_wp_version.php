<?php

/** Remove WordPress & WooCommerce version generator Hook */
remove_action( 'wp_head', 'wp_generator' );