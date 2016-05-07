<?php //コメントに関する関数


//無記名のコメント投稿者名を変更する
function rename_anonymous_name($author = '') {
  global $comment;

  if ( !$author || $author == __('Anonymous') ) {
    $author = get_theme_text_comment_anonymous_name();//匿名ユーザー名の取得
  } else {
    // if( empty( $comment->comment_author ) ) {
    //   if( !empty( $comment->user_id ) ) {
    //     $user = get_userdata( $comment->user_id );
    //     $author = $user->user_login;
    //   } else {
    //     $author = get_theme_text_comment_anonymous_name();//匿名ユーザー名の取得
    //   }
    // } else {
    //   $author = $comment->comment_author;
    // }
  }
  return $author;
}
add_filter( 'get_comment_author', 'rename_anonymous_name' );

//コメントリスト表示用カスタマイズコード
function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">
    <div class="comment-listCon">
        <div class="comment-info">
            <?php echo get_avatar( $comment, 48 );//アバター画像 ?>
            <?php printf(__('<span class="admin">名前:<cite class="fn comment-author">%s</cite></span> '), get_comment_author_link()); //投稿者の設定 ?>
            <span class="comment-datetime">投稿日：<?php printf(__('%1$s at %2$s'), get_comment_date('Y/m/d(D)'),  get_comment_time('H:i:s')); //投稿日の設定 ?></span>
            <span class="comment-id">
            ID：<?php //IDっぽい文字列の表示（あくまでIDっぽいものです。）
                $ip01 = get_comment_author_IP(); //書き込んだユーザーのIPアドレスを取得
                $ip02 = get_comment_date('jn'); //今日の日付
                $ip03 = ip2long($ip01); //IPアドレスの数値化
                $ip04 = ($ip02) * ($ip03); //ip02とip03を掛け合わせる
                echo mb_substr(sha1($ip04), 2, 9); //sha1でハッシュ化、頭から9文字まで出力
                //echo mb_substr(base64_encode($ip04), 2, 9); //base64でエンコード、頭から9文字まで出力
            ?>
            </span>
            <span class="comment-reply">
              <?php comment_reply_link(array_merge( $args, array(
                'depth'   =>$depth,
                'max_depth' =>$args['max_depth']))) ?>
            </span>
            <span class="comment-edit"><?php edit_comment_link(__('Edit'),'  ',''); //編集リンク ?></span>
        </div>
        <?php if ($comment->comment_approved == '0') : ?>
            <em><?php _e('Your comment is awaiting moderation.') ?></em>
        <?php endif; ?>
        <div class="comment-text"></div>
        <?php comment_text(); //コメント本文 ?>

        <?php //返信機能は不要なので削除 ?>
    </div>
</div>
<?php
}
