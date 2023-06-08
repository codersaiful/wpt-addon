<?php 
/**
 * All important functon will stay here.
 */

// add_filter('wpt_design_tab_fields','wpt_custom_design_tab');
function wpt_custom_design_tab( $args ){
    $args['body']['item'][] = [
        'title' => 'Table Border Width',
        'selector' => 'tbody tr td',
        'property' => 'border-width',
        'type'  => 'text'
    ];
    $args['body']['item'][] = [
        'title' => 'Table Border Width',
        'selector' => 'tbody tr td',
        'property' => 'border-style',
        'value'     => 'solid',
        'type'  => 'text'
    ];
    // var_dump($args['body']['item']);
    return $args;
}