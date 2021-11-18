<?php
/******** Get Post Categories in Contact Form 7 Dropdown *******/

add_action( 'wpcf7_init', 'custom_add_form_tag_customlist' );

function custom_add_form_tag_customlist() {
    wpcf7_add_form_tag( array( 'customlist', 'customlist*' ), 
'custom_customlist_form_tag_handler', true );
}

function custom_customlist_form_tag_handler( $tag ) {

    $tag = new WPCF7_FormTag( $tag );

    if ( empty( $tag->name ) ) {
        return '';
    }

    $customlist = '';

    $wcatTerms = get_terms(
        'wow_category', array('hide_empty' => 0, 'order' =>'asc', 'parent' =>0));
        foreach($wcatTerms as $category) :
            $post_title = $category->name;
            $customlist .= sprintf( '<option value="%1$s">%2$s</option>', 
            esc_html( $post_title ), esc_html( $post_title ) );
        endforeach;

    $customlist = sprintf(
        '<span class="wpcf7-form-control-wrap"><select name="%1$s" id="%2$s">%3$s</select></span>', $tag->name,
    $tag->name . '-options',
        $customlist );

    return $customlist;
}

//use this tag in your form
//[customlist your-cat]
?>