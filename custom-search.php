<?php

/*==========================================
=            Custom Search Hook            =
==========================================*/


function CustomSearchForm($recipe_only = false, $show_tags = true) {

  echo '<div class="recipe_search_style clear_group">';

  switch($recipe_only) {

    case true:
      $post_type = 'posts';
      $placeholder = 'Search all of our recipes...';
      $action_url = home_url('/');
    break;

    default:
      $post_type = 'recipes';
      $placeholder = 'Search all our site...';
      $action_url = home_url('/');

  }

  echo '
    <form role="search" action="'. $action_url .'?>" method="get" id="searchform">
        <div class="search_input">
          <input type="text" name="s" placeholder="'.$placeholder.'" value="'.get_search_query().'" />
          <input type="hidden" name="post_type" value="'.$post_type.'" /> <!-- // hidden \'recipes\' value -->
        </div>

        <div class="search_button"><button class="button" type="submit" alt="Search" >Search <i class="fa fa-search fa-flip-horizontal" aria-hidden="true"></i></button></div>
    </form>
  ';

  if($show_tags == true) { ?>

    <div class="popular_tags">
        <span>Popular: </span>
        <ul>

            <?php
            function sortByOrder($a, $b) {
              return $b->count - $a->count;
          }

            remove_all_filters('posts_orderby');

            $terms = get_terms( array(
              'taxonomy' => 'recipes-tags',
              'hide_empty' => true,
              'order_by' => 'count',
              'number' => '',
          ));

          usort($terms, 'sortByOrder');
          $count = 1;

          foreach ( (array) $terms as $tag ) {

            if ($count <= 7) {
                echo '<li><a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name . '</a></li>';
            } else {
              break;
            }

          $count++; }

        ?>
        </ul>
      </div>

    <?php }

  echo '</div>';

}

add_action('cs_framework_custom_search', 'CustomSearchForm', 10, 2);