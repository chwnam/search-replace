<?php
class MyClass {
}

$x = 1;
__( sprintf( '%s ab', $x ), 'textdomain' );
__( 'Hello', 'textdomain' );
?>

<a href="#"><?php _n( 'Count', 'Counts', $x, 'domain' ); ?></a>
