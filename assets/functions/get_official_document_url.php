<?php

function get_official_document_url() {
    // 現在のタームを取得する
    $term = get_queried_object();

    // キーと値の配列を定義する
    $term_array = array(
        'html' => 'https://developer.mozilla.org/ja/docs/Web/HTML/Element',
        'css' => 'https://developer.mozilla.org/ja/docs/Web/CSS/Reference',
        'bootstrap' => 'https://getbootstrap.jp/',
        'sass' => 'https://sass-lang.com/',
        'tailwind' => 'https://tailwindcss.com/',
        'javascript' => 'https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference',
        'typescript' => 'https://www.typescriptlang.org/',
        'jquery' => 'https://jquery.com/',
        'react' => 'https://ja.legacy.reactjs.org/',
        'nextjs' => 'https://nextjs.org/',
        'threejs' => 'https://threejs.org/',
        'wordpress' => 'https://wpdocs.osdn.jp/Main_Page',
        'php' => 'https://www.php.net/manual/ja/index.php',
        'laravel' => 'https://readouble.com/laravel/',
        'nodejs' => 'https://nodejs.org/ja',
        'illustrator' => 'https://helpx.adobe.com/jp/illustrator/tutorials.html',
        'photoshop' => 'https://helpx.adobe.com/jp/photoshop/tutorials.html',
        'git' => 'https://git-scm.com/',
        'vscode' => 'https://code.visualstudio.com/',
        'excel' => 'https://support.microsoft.com/ja-jp/excel',
        'powerpoint' => 'https://support.microsoft.com/ja-jp/powerpoint',
        'word' => 'https://support.microsoft.com/ja-jp/word',
        'regex' => 'https://developer.mozilla.org/ja/docs/Web/JavaScript/Guide/Regular_expressions',
        'docker' => 'https://docs.docker.jp/',
        'atcoder' => 'https://atcoder.jp/home',
        'quality' => '',
        'architecture' => '',
        'test' => '',
        'thinking' => '',
        'review' => '',
        'certification' => '',
    );

    // 現在のタームと一致するキーがあるかどうかを確認する
    foreach ($term_array as $key => $value) {
        if ($term->slug === $key) {
            return $value;
        }
    }

    // 一致するキーがない場合は、処理なし
    return '';
}