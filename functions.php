<?php
/**
 * 共通変数宣言
 * 呼び出す際は関数直下にglobal $post_types;を記述する。
 */
$post_types = array( 'development', 'design', 'frontend', 'backend', 'tool', 'essay' );

/**
 * ファイルの読み込み
 * wp_enqueue_style( $handle, $src, $deps, $ver, $media )
 * $handle:ユニーク
 */
add_action('wp_enqueue_scripts', 'add_files');
function add_files()
{
  // リセットCSS
  wp_enqueue_style('reset-style', get_theme_file_uri('/assets/css/reset.css'));
  // 各CSS
  wp_enqueue_style('common-style', get_theme_file_uri('/assets/css/common.css'));
  wp_enqueue_style('header-style', get_theme_file_uri('/assets/css/header.css'));
  wp_enqueue_style('footer-style', get_theme_file_uri('/assets/css/footer.css'));
  wp_enqueue_style('sidebar-style', get_theme_file_uri('/assets/css/sidebar.css'));
  wp_enqueue_style('post-list-style', get_theme_file_uri('/assets/css/post_list.css'));
  wp_enqueue_style('single-style', get_theme_file_uri('/assets/css/single.css'));
  wp_enqueue_style('block-style', get_theme_file_uri('/assets/css/block.css'));
  wp_enqueue_style('tag-list-style', get_theme_file_uri('/assets/css/tag_list.css'));
  wp_enqueue_style('form-style', get_theme_file_uri('/assets/css/form.css'));
  wp_enqueue_style('comments-style', get_theme_file_uri('/assets/css/comments.css'));
  wp_enqueue_style('button-style', get_theme_file_uri('/assets/css/components/button.css'));
  // メインのCSSファイル
  wp_enqueue_style('main-style', get_stylesheet_uri());
  // JavaScriptファイル
  wp_enqueue_script('main-script', get_theme_file_uri() . '/assets/js/script.js', array(), '', true);
  wp_enqueue_script('page-top-script', get_theme_file_uri() . '/assets/js/page_top.js', array(), '', true);

}

/**
 * functionファイル読込み
 */
get_template_part( '/assets/functions/create_custom_post' );
get_template_part( '/assets/functions/delete_archive_title' );
get_template_part( '/assets/functions/get_official_document_url');
get_template_part( '/assets/functions/get_custom_taxonomies_terms_links');

/**
 * テーマ設定
 */
add_action('after_setup_theme', 'theme_setup');
function theme_setup()
{
  // titleタグ
  add_theme_support('title-tag');
  // アイキャッチ画像
  add_theme_support('post-thumbnails');
  // 検索
  add_theme_support('html5', array( 'search-form'));


  // メニュー
  register_nav_menus(
    array(
      'main-menu' => 'メインメニュー',
      'footer-menu' => 'フッターメニュー',
    )
  );
}