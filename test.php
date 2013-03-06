<?php
// Envío de correo electrónico.


function epic( $a, $b )
{
    fail( $a . ' ' . $b );
}

function fail( $string )
{
    $backtrace = debug_backtrace();

    print_r( $backtrace );
}

epic( 'Hello', 'World' );

?>