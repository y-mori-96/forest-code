<?php

/**
 * 共通変数宣言
 * 呼び出す際は関数直下にglobal $post_types;を記述する。
 */
$post_types = array( 'development', 'design', 'frontend', 'backend', 'tool', 'essay' );

// $post_typesの各要素に'category_'を付ける
// function add_category_prefix( $post_types ) {
//   $prefixed_post_types = array();
//   foreach ( $post_types as $post_type ) {
//     $prefixed_post_types[] = 'category_' . $post_type;
//   }
//   return $prefixed_post_types;
// }
// $post_types_with_prefix = add_category_prefix( $post_types );

function add_all_posttype($where,$r){
  if( is_post_type_archive('backend')){

  $types= "'design','frontend','backend','tool'";
  return str_replace(
  "post_type = 'post' ",
  "post_type IN(". $types.")" ,
  $where
  );
  }else{
  return $where;
  }
  }
  add_filter('getarchives_where','add_all_posttype',10,2);

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
  // メインのCSSファイル
  wp_enqueue_style('main-style', get_stylesheet_uri());
  // JavaScriptファイル
  wp_enqueue_script('main-script', get_theme_file_uri() . '/assets/js/script.js', array(), '', true);
}

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

  // メニュー
  register_nav_menus(
    array(
      'main-menu' => 'メインメニュー',
    )
  );
}

/**
 * カスタム投稿
 */
add_action( 'init', 'codex_custom_init' );
function codex_custom_init() {
  global $post_types;
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
   * 階層あり（カテゴリー型）カスタムタクソノミー作成
   */
  $category_taxonomy_labels = array(
    'name'              => 'カテゴリー',
  );

  $category_taxonomy_args = array(
    'labels'            => $category_taxonomy_labels,
    'hierarchical'      => true, // 階層なし
    'show_in_rest'      => true, // ブロックエディター対応
    'show_admin_column' => true, // 管理画面に列表示
  );
  // カスタムタクソノミーを作成
  // register_taxonomy( $taxonomy, $object_type, $args );
  // $taxonomyは一意
  // $object_type：どの投稿に紐づけるか
  foreach ( $post_types as $post_type ) {
    register_taxonomy( 'category_' . $post_type, array( $post_type ), $category_taxonomy_args );
  }

  /**
   * 階層なし（タグ型）カスタムタクソノミー作成
   */
  $tag_taxonomy_labels = array(
    'name'              => 'タグ',
  );

  $tag_taxonomy_args = array(
    'labels'            => $tag_taxonomy_labels,
    'hierarchical'      => false, // 階層なし
    'show_in_rest'      => true,
    'show_admin_column' => true,
  );
  // カスタムタクソノミーを作成
  foreach ( $post_types as $post_type ) {
    register_taxonomy( 'tag_' . $post_type, $post_type, $tag_taxonomy_args );
  }

}

/**
 * カスタムタクソノミー　カテゴリー検索
 */
add_action( 'restrict_manage_posts', 'add_custom_category_filter' );
function add_custom_category_filter() {
  global $typenow;    // 現在表示されている管理画面の投稿タイプを取得
  global $post_type;  // 管理用グローバル変数
  global $post_types; // 共通宣言

  if (in_array($post_type, $post_types)) {    // 投稿タイプが配列に含まれる場合に処理を行う
    $taxonomy = 'category_' . $typenow;
    wp_dropdown_categories(
      array(
        'show_option_all' => 'カテゴリー一覧', //すべてのカテゴリを表示するために表示するテキスト
        'taxonomy'        => $taxonomy,
        'name'            => $taxonomy,
        'orderby'         => 'name',           // 名前で並べ替え
        'selected'        => get_query_var($taxonomy),
        'show_count'      => true,             // 投稿数表示
        'value_field'     => 'slug'            // フォームの option 要素の 'value' 属性へ入れるタームのフィールド
      )
    );
  }
}

/**
 * アーカイブタイトルを削除する
 */
function custom_archive_title() {
  add_action( 'after_setup_theme', 'custom_archive_title' );
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