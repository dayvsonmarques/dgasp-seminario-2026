<?php
/**
 * Bootstrap 5 Nav Walker for WordPress
 * Clean implementation for Bootstrap navigation menus
 */
class Bootstrap_NavWalker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="dropdown-menu">';
    }
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</ul>';
    }
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $classes[] = 'dropdown';
        }
        $class_names = join( ' ', array_filter( $classes ) );
        $output .= '<li class="' . esc_attr( $class_names ) . '">';
        $atts = array();
        $atts['class'] = 'nav-link';
        if ( in_array( 'menu-item-has-children', $classes ) ) {
            $atts['class'] .= ' dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
        }
        $atts['href'] = ! empty( $item->url ) ? $item->url : '';
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
        }
        $output .= '<a' . $attributes . '>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</a>';
    }
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}
