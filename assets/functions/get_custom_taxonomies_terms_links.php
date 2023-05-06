<?php
/**
 * （タクソノミーと）タームのリンクを取得する
 */
function custom_taxonomies_terms_links(){
  // 現在の投稿オブジェクトを取得
  $post = get_post();
  $post_type = get_post_type();

  // 投稿に付けられたタグを取得
  $terms = get_the_terms( $post->ID, 'tag-' . $post_type );

  $out = array();
  if ( !empty( $terms ) ) {
    // $out[] = "<h2>タグ</h2>\n<ul>";
    $out[] = "<ul>";
    foreach ( $terms as $term ) {
      $out[] =
        '  <li><a href="'
      .    get_term_link( $term->slug, 'tag-' . $post_type ) .'">'
      .    $term->name
      . "</a></li>\n";
    }
    $out[] = "</ul>\n";
  }

  return implode('', $out );
}