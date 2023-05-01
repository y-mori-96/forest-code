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
  $args = array(
    'public' => true,
    'label'  => 'フロントエンド'
  );
  register_post_type( 'frontend', $args );
}
add_action( 'init', 'codex_custom_init' );

/**
 * カスタム投稿タイプ backend を登録する
 */
add_action( 'init', 'codex_backend_init' );
function codex_backend_init() {
  $labels = array(
    // 管理画面上で表示する投稿タイプ名
    // 省略すると $post_type_object->label と同じ値
    'name'               => 'バックエンド',
  );
  
  //投稿時に使用できる投稿用のパーツを指定
  $supports = array(
    'title',      //タイトルフォーム
    'editor',     //エディター(内容の編集)
    'thumbnail',  //アイキャッチ画像
    'excerpt',    //抜粋
    'revisions',  //下書きとして保存
);

  $args = array(
    // 作成した投稿タイプのラベル名、メニュー名、新規作成画面でのラベル名などを指定
    'labels'             => $labels,

    // 公開されるかどうかを指定
    // 初期値： false
    'public'             => true,

    // アーカイブページを有効にするかどうかを指定trueで有効、falseで無効
    // 初期値： false
    'has_archive'        => true,

    // 管理画面のメニューでの表示位置を指定
    // nullで自動的に設定
    // 初期値： null - デフォルトは「コメントの下」
    'menu_position'      => 20,

    // メニューで使用するアイコン
    'menu_icon'          => 'dashicons-desktop',

    // 新エディターに対応
    // 初期値： なし
    'show_in_rest'       => true,

    // 投稿タイプでサポートする投稿フォーマットを指定
    'supports' => $supports
  );

  // カスタム投稿タイプを作成
  // register_post_type(post_type, args)
  // post_typeパラメーター：投稿タイプの名前を指定
  // argsパラメーター     ：投稿タイプの設定を含む配列
  register_post_type( 'backend', $args );
}

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