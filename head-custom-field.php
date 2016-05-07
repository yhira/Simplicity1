<?php
///////////////////////////////////////
// ヘッダーのカスタムフィールドを挿入
// ヘッダーで呼び出すCSSやスクリプトなど
// カスタムフィールドに「head_custom」と入力することで使用。
///////////////////////////////////////
if ( is_singular() ){//投稿・固定ページの場合
  $head_custom = get_post_meta($post->ID, 'head_custom', true);
  if ( $head_custom ) {
    echo replace_directory_uri($head_custom);
  }
}
?>