<?php
/*
Plugin Name: Simple Bootstrap Shortcodes
//Plugin URI: https://github.com/TBD
Description: Simple shortcodes formatted for Bootstrap 4. Based on original plugin by Michael W. Delaney, Filip Stefansson, and Simon Yeldon https://github.com/MWDelaney/bootstrap-shortcodes
Version: 0.1
Author: Brent Patroch
Author URI: https://modevmedia.com
License: MIT
*/


class BSShortcodes {

    function __construct()
    {
        // Initiate the shortcodes
        add_action('init', array($this, 'mv_bs_shortcodes'));
    }

    /* ----------------
     *
     * mv_bs_shortcodes
     *
     * Builds array of available codes and calls individual functions
     *
     */
    function mv_bs_shortcodes(){
        $codes = array(
            'container',
            'row',
            'column',
            'accordion',
            'card',
            'responsive_embed',
            'alert',
            'badge',
            'button',
            'button_group',
            'carousel',
            'carousel_item'
        );
        foreach($codes as $code){
            $function = 'mv_bs_'.$code;
            add_shortcode($code, array($this,$function));
        }
    }

    /* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
     *
     * Individual functions for each shortcode
     *
    /* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */

    /* ----------------------------------------------
     * alert
     */
    function mv_bs_alert( $atts, $content = null ) {

        $atts = shortcode_atts( array(
            "type"          => false,
            "dismissable"   => false,
            "class"        => false
        ), $atts );

        $class  = 'alert';
        $class .= ( $atts['type'] )         ? ' alert-' . $atts['type'] : ' alert-success';
        $class .= ( $atts['dismissable']   == 'true' )  ? ' alert-dismissable' : '';
        $class .= ( $atts['class'] )       ? ' ' . $atts['class'] : '';

        $dismissable = ( $atts['dismissable'] ) ? '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' : '';

        return sprintf(
            '<div class="%s">%s%s</div>',
            esc_attr( trim($class) ),
            $dismissable,
            do_shortcode( $content )
        );
    }
    /* ----------------------------------------------
     * alert
     */
    function mv_bs_badge( $atts, $content = null ) {
        $atts = shortcode_atts( array(
            "type"    => false,
            "pill"    => false,
            "url"     => false,
            "class"   => false
        ), $atts );

        $class  = 'badge';
        $class .= ( $atts['type'] )         ? ' alert-' . $atts['type'] : '';
        $class .= ( $atts['pill']   == 'true' )  ? ' badge-pill' : '';
        $class .= ( $atts['class'] )   ? ' ' . $atts['class'] : '';


        if( $atts['url'] !== 'false') {
            return sprintf(
                '<a href="%s" class="%s">%s</a>',
                $atts['url'],
                esc_attr( trim($class) ),
                do_shortcode( $content )
            );
        }else{
            return sprintf(
                '<span class="%s">%s</span>',
                esc_attr( trim($class) ),
                do_shortcode( $content )
            );
        }
    }
    /* ----------------------------------------------
     * Button
     */
    function mv_bs_button( $atts, $content = null ) {

        $atts = shortcode_atts( array(
            "type"     => false,
            "block"    => false,
            "url"      => '',
            "target"   => false,
            "disabled" => false,
            "active"   => false,
            "class"    => false
        ), $atts );

        $class  = 'btn';
        $class .= ( $atts['type'] )     ? ' btn-' . $atts['type'] : ' btn-default';
        $class .= ( $atts['size'] )     ? ' btn-' . $atts['size'] : '';
        $class .= ( $atts['block'] == 'true' )    ? ' btn-block' : '';
        $class .= ( $atts['disabled']   == 'true' ) ? ' disabled' : '';
        $class .= ( $atts['active']     == 'true' )   ? ' active' : '';
        $class .= ( $atts['class'] )   ? ' ' . $atts['class'] : '';

        return sprintf(
            '<a href="%s" class="%s"%s>%s</a>',
            esc_url( $atts['link'] ),
            esc_attr( trim($class) ),
            ( $atts['target'] )     ? sprintf( ' target="%s"', esc_attr( $atts['target'] ) ) : '',
            do_shortcode( $content )
        );

    }
    /* ----------------------------------------------
     * Button Group
     */
    function mv_bs_button_group( $atts, $content = null ) {

        $atts = shortcode_atts( array(
            "size"      => false,
            "vertical"  => false,
            "class"    => false
        ), $atts );

        $class  = 'btn-group';
        $class .= ( $atts['size'] )         ? ' btn-group-' . $atts['size'] : '';
        $class .= ( $atts['vertical']   == 'true' )     ? ' btn-group-vertical' : '';
        $class .= ( $atts['class'] )       ? ' ' . $atts['class'] : '';

        return sprintf(
            '<div class="%s"%s role="group">%s</div>',
            esc_attr( trim($class) ),
            do_shortcode( $content )
        );
    }
    /* ----------------------------------------------
     * Carousel
     */
    function mv_bs_carousel( $atts, $content = null ) {

        $atts = shortcode_atts( array(
            "class"     => false,
            "id"        => false,
            "controls"  => false,
            
        ), $atts );

        $div_class  = 'carousel slide';
        $div_class .= ( $atts['class'] ) ? ' ' . $atts['class'] : '';
        $id = esc_attr( $atts['id']);
        $inner_class = 'carousel-inner';

        $controls = '';
        if($atts['controls']){
            $controls = 
                sprintf(
                    "<a class='carousel-control-prev' href='#%s' role='button' data-slide='prev'>
                                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                <span class='sr-only'>Previous</span>
                            </a>
                            <a class='carousel-control-next' href='#%s' role='button' data-slide='next'>
                                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                <span class='sr-only'>Next</span>
                            </a>",
                $id,$id
                );
        }
        return sprintf(
            '<div class="%s" id="%s" data-ride="carousel"><div class="%s">%s</div>%s</div>',
            esc_attr( $div_class ),
            $id,
            $inner_class,
            do_shortcode( $content ),
            $controls
        );
    }
    /* ----------------------------------------------
     * Carousel Item
     */

    function mv_bs_carousel_item( $atts, $content = null ) {

        $atts = shortcode_atts( array(
            "active"  => false,
            "caption" => false,
            "class"   => false,
            "img"     => ''
        ), $atts );

        $class  = 'carousel-item';
        $class .= ( $atts['active']   == 'true' ) ? ' active' : '';
        $class .= ( $atts['class'] ) ? ' ' . $atts['class'] : '';

        return sprintf(
            '<div class="%s"><img class="d-block w-100" src="%s" alt="%s">%s</div>',
            esc_attr( trim($class) ),
            esc_attr($atts['img']),
            esc_html($atts['caption']),
            ( $atts['caption'] ) ? '<div class="carousel-caption d-none d-md-block">' . esc_html( $atts['caption'] ) . '</div>' : ''
        );
    }

    /* ----------------------------------------------
     * container
     */
    function mv_bs_container($atts, $content = null) {
        $atts = shortcode_atts( array(
            "fluid"  => false,
            "class" => false,
            "id"     => false
        ), $atts );
        $class  = ( $atts['fluid']   == 'true' )  ? 'container-fluid' : 'container';
        $class .= ( $atts['class'] )   ? ' ' . $atts['class'] : '';
        $id = ($atts['id']) ? ' id="'. $atts['id'] .'"':'';

        return sprintf(
            '<div class="%s"%s>%s</div>',
            esc_attr( trim($class) ),
            ( $id ) ? ' ' . $id : '',
            do_shortcode( $content )
        );
    }
    /* ----------------------------------------------
     * row
     */
    function mv_bs_row($atts, $content = null) {
        $atts = shortcode_atts( array(
            "class" => false,
            "gutters" => true,
            "justify" => false,
            "id"     => false
        ), $atts );

        $class  = 'row';
        $class  .= ( $atts['gutters']   === 'false' )  ? ' no-gutters': null;
        if (in_array($atts['justify'],array('start','center','end','around','between')))
            $class  .= ' justify-content-'.$atts['justify'];
        $class .= ( $atts['class'] )   ? ' ' . $atts['class'] : '';
        $id = ($atts['id']) ? ' id="'. $atts['id'] .'"':'';

        return sprintf(
            '<div class="%s"%s>%s</div>',
            esc_attr( trim($class) ),
            ( $id ) ? ' ' . $id : '',
            do_shortcode( $content )
        );

    }
    /* ----------------------------------------------
     * column
     */
    function mv_bs_column($atts, $content = null) {
        $atts = shortcode_atts( array(
            "xl"          => false,
            "lg"          => false,
            "md"          => false,
            "sm"          => false,
            "col"         => false,
            "offset_xl"   => false,
            "offset_lg"   => false,
            "offset_md"   => false,
            "offset_sm"   => false,
            "offset"      => false,
            "order_xl"    => false,
            "order_lg"    => false,
            "order_md"    => false,
            "order_sm"    => false,
            "order"       => false,
            "id"          => false,
            "class"       => false
        ), $atts, 'column' );

        $class  = 'col';
        $class .= ( $atts['xl'] )			                                ? ' col-xl-' . $atts['xl'] : '';
        $class .= ( $atts['lg'] )			                                ? ' col-lg-' . $atts['lg'] : '';
        $class .= ( $atts['md'] )                                           ? ' col-md-' . $atts['md'] : '';
        $class .= ( $atts['sm'] )                                           ? ' col-sm-' . $atts['sm'] : '';
        $class .= ( $atts['col'] )                                          ? ' col-' . $atts['col'] : '';
        $class .= ( $atts['offset_lg'] || $atts['offset_lg'] === "0" )      ? ' offset-lg-' . $atts['offset_lg'] : '';
        $class .= ( $atts['offset_md'] || $atts['offset_md'] === "0" )      ? ' offset-md-' . $atts['offset_md'] : '';
        $class .= ( $atts['offset_sm'] || $atts['offset_sm'] === "0" )      ? ' offset-sm-' . $atts['offset_sm'] : '';
        $class .= ( $atts['offset'] || $atts['offset'] === "0" )            ? ' offset-' . $atts['offset'] : '';
        $class .= ( $atts['order_xl']   || $atts['order_xl'] === "0" )      ? ' order-xl-' . $atts['order_xl'] : '';
        $class .= ( $atts['order_lg']   || $atts['order_lg'] === "0" )      ? ' order-lg-' . $atts['order_lg'] : '';
        $class .= ( $atts['order_md']   || $atts['order_md'] === "0" )      ? ' order-md-' . $atts['order_md'] : '';
        $class .= ( $atts['order_sm']   || $atts['order_sm'] === "0" )      ? ' order-sm-' . $atts['order_sm'] : '';
        $class .= ( $atts['order']   || $atts['order'] === "0" )            ? ' order-' . $atts['order'] : '';
        $class .= ( $atts['class'] )                                        ? ' ' . $atts['class'] : '';

        $id = ($atts['id']) ? ' id="'. $atts['id'] .'"':'';

        return sprintf(
            '<div class="%s"%s>%s</div>',
            esc_attr( trim($class) ),
            ( $id ) ? ' ' . $id : '',
            do_shortcode( $content )
        );
    }
    /* ----------------------------------------------
     * accordion  (basic container div) use in conjunction with cards
     */
    function mv_bs_accordion($atts, $content = null) {
        $atts = shortcode_atts( array(
            "class" => false,
            "id"     => false
        ), $atts );
        $class = 'accordion ';
        $class .= ( $atts['class'] )   ? ' ' . $atts['class'] : '';

        $id = ($atts['id']) ? ' id="'. $atts['id'] .'"':'';

        return sprintf(
            '<div class="%s"%s>%s</div>',
            esc_attr( trim($class) ),
            ( $id ) ? ' ' . $id : '',
            do_shortcode( $content )
        );
    }
    /* ----------------------------------------------
     * card
     */
    function mv_bs_card($atts, $content = null) {
        $atts = shortcode_atts( array(
            "title"  => false,
            "id"     => false,
            "acc_id" => false
        ), $atts );

        $id = ($atts['id']) ? ' id="'. $atts['id'] .'"':'';
        $title = ($atts['title']) ? $atts['title']: 'No Title';

        // Generate Unique Id
        $uq = uniqid();

        $acc_id = ($atts['acc_id']) ? $atts['acc_id']: $uq;

        $str = <<<EOF
<div class="card" %s>
    <div class="card-header" id="heading_%s">
        <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse_%s" aria-expanded="false" aria-controls="collapse_%s">
                %s
            </button>
        </h5>
    </div>
    <div id="collapse_%s" class="collapse" aria-labelledby="heading_%s" data-parent="#%s">
        <div class="card-body">
            %s
        </div>
    </div>
</div>
EOF;
        return sprintf(
            $str,$uq,$uq,$uq,
            ( $id ) ? ' ' . $id : '',
            $title,$uq,$uq,$acc_id,
            do_shortcode( $content )
        );
    }
    /* ----------------------------------------------
        *
        * embed iframe
        *
        */
    function mv_bs_responsive_embed($atts, $content = null) {
        $atts = shortcode_atts( array(
            "class" => false,
            "id"    => false,
            'url'   => false,
            'size'  => false
        ), $atts );
        $class = 'embed-responsive ';
        $class .= ( $atts['class'] )   ? ' ' . $atts['class'] : '';
        if(in_array($atts['size'],array('21by9','16by9','4by3','1by1'))){
            $class .= ' embed-responsive-'.$atts['size'];
        }else{
            $class .= ' embed-responsive-1by1';
        }
        $id = ($atts['id']) ? ' id="'. $atts['id'] .'"':'';
        $url = ($atts['url']) ? '<iframe class="embed-responsive-item" src="'.$atts['url'].'"></iframe>':'';
        return sprintf(
            '<div class="%s"%s>%s%s</div>',
            esc_attr( trim($class) ),
            ( $id ) ? ' ' . $id : '',
            $url,
            do_shortcode( $content )
        );
    }
}


$bs_codes = new BSShortcodes();