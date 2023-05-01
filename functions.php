<?php

/**
 * ファイルの読み込み
 */
function add_files()
{
  // リセットCSS
  wp_enqueue_style('reset-style', get_theme_file_uri('/assets/css/reset.css'));
  // メインのCSSファイル
  wp_enqueue_style('main-style', get_stylesheet_uri());
  // JavaScriptファイル
  wp_enqueue_script('main-script', get_theme_file_uri() . '/assets/js/script.js', array(), '', true);
}
add_action('wp_enqueue_scripts', 'add_files');

/**
 * テーマ設定
 */
function theme_setup()
{
  // titleタグ
  add_theme_support('title-tag');

  // アイキャッチ画像
  add_theme_support('post-thumbnails');

  // メニュー
  register_nav_menus(
    array(
      'main-menu' => 'メインメニュー',
    )
  );
}
add_action('after_setup_theme', 'theme_setup');

/**
 * カスタム投稿
 */
function codex_custom_init() {
  /**
   * カスタム投稿作成
   */
  function register_custom_post_type($name, $label, $icon) {
    $custom_post_labels = array(
      'name' => $label
    );

    //投稿時に使用できる投稿用のパーツを指定
    $custom_post_supports = array(
      'title',      //タイトルフォーム
      'editor',     //エディター(内容の編集)
      'thumbnail',  //アイキャッチ画像
      'excerpt',    //抜粋
      'revisions',  //下書きとして保存
    );

    $custom_post_args = array(
      // 作成した投稿タイプのラベル名、メニュー名、新規作成画面でのラベル名などを指定
      'labels'             => $custom_post_labels,

      // 公開されるかどうかを指定(初期値： false)
      'public'             => true,

      // アーカイブページを有効にするかどうかを指定(初期値： false)
      'has_archive'        => true,

      // メニューで使用するアイコン
      'menu_icon'          => $icon,

      // 新エディターに対応(初期値： なし)
      'show_in_rest'       => true,

      // 投稿タイプでサポートする投稿フォーマットを指定
      'supports' => $custom_post_supports
    );

    // カスタム投稿タイプを作成
    // register_post_type(post_type, args)
    // post_typeパラメーター：投稿タイプの名前を指定
    // argsパラメーター     ：投稿タイプの設定を含む配列
    register_post_type($name, $custom_post_args);
  }

  register_custom_post_type('development', '開発', 'dashicons-feedback');
  register_custom_post_type('design', 'デザイン', 'dashicons-admin-customizer');
  register_custom_post_type('frontend', 'フロントエンド', 'dashicons-laptop');
  register_custom_post_type('backend', 'バックエンド', 'dashicons-desktop');
  register_custom_post_type('tool', 'ツール', 'dashicons-admin-tools');
  register_custom_post_type('essay', 'エッセイ', 'dashicons-admin-users');

  /**
   * カスタムタクソノミー作成
   */
  $taxonomy_labels = array(
    'name'              => 'タクソノミー',
  );

  $taxonomy_args = array(
    'labels'            => $taxonomy_labels,
    'hierarchical'      => true,
    'show_in_rest'      => true,
    'show_admin_column' => true,
  );
  // カスタムタクソノミーを作成
  // register_taxonomy( $taxonomy, $object_type, $args );
  // $taxonomyは一意
  $post_types = array( 'development', 'design', 'frontend', 'backend', 'tool', 'essay' );

  foreach ( $post_types as $post_type ) {
    register_taxonomy( $post_type, array( $post_type ), $taxonomy_args );
  }
}
add_action( 'init', 'codex_custom_init' );

/**
 * アーカイブタイトルを削除する
 */
function custom_archive_title() {
  add_filter( 'get_the_archive_title', function ($title) {
      if (is_category()) {
          $title = single_cat_title('',false);
      // } elseif (is_tag()) {
      //     $title = single_tag_title('',false);
      // } elseif (is_tax()) {
      //     $title = single_term_title('',false);
      } elseif (is_post_type_archive() ){
          $title = post_type_archive_title('',false);
      // } elseif (is_date()) {
      //     $title = get_the_time('Y年n月');
      // } elseif (is_search()) {
      //     $title = '検索結果：'.esc_html( get_search_query(false) );
      // } elseif (is_404()) {
      //     $title = '「404」ページが見つかりません';
      } else {

      }
      return $title;
  });
}
add_action( 'after_setup_theme', 'custom_archive_title' );