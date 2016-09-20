<?php 


add_shortcode( 'dashicon', 'blox_dashicon_shortcode' );

function blox_dashicon_shortcode( $atts ) {

	$atts = shortcode_atts( array( 
		'markup'	 => 'span',
		'icon'      => '', 
	), $atts );

	$output = '<' . $atts['markup'] . ' class="dashicons ' . $atts['icon'] . '"></' .  $atts['markup'] . '>';
	
	return ( $output );
}

add_shortcode( 'example_block', 'blox_example_block_shortcode' );

function blox_example_block_shortcode( $atts, $content ) {

	$atts = shortcode_atts( array( 
		'markup' => 'div',
		'align' => 'left',
		'class'	 => '',
	), $atts );

	$output = '<' . $atts['markup'] . ' class="example-block ' . $atts['class'] . '" style="text-align:' . $atts['align'] . '">' . $content . '</' .  $atts['markup'] . '>';
	
	return ( $output );
}