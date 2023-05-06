<?php
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
    register_taxonomy( 'category-' . $post_type, array( $post_type ), $category_taxonomy_args );
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
    register_taxonomy( 'tag-' . $post_type, $post_type, $tag_taxonomy_args );
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
    $taxonomy = 'category-' . $typenow;
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
