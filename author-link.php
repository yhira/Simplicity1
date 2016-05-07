<?php if ( is_author_visible() && //表示設定されているとき
           is_singular() ): //投稿・固定ページのとき ?>
<span class="post-author vcard author"><span class="fn"<?php is_single() ? '' : ''; ?>><span class="fa fa-user fa-fw"></span><?php
if ( is_twitter_follow_id_author_visible() && get_twitter_follow_id() ): //TwitterID表示の場合 ?>
<a href="https://twitter.com/<?php echo esc_html( get_twitter_follow_id() ); ?>" target="_blank" rel="nofollow">@<?php echo esc_html( get_twitter_follow_id() ); ?></a>
<?php //セキュリティー上の注意表示
elseif ( is_login_name_and_display_name_same() && //ログイン名と表示名が同じ時
           is_user_logged_in() ): //ログインユーザーのとき ?>
<span style="color:red;"><a href="<?php echo site_url('/wp-admin/profile.php'); ?>">プロフィール設定</a>から、「ユーザー名」と「表示名」は異なるものになるよう変更することをお勧めします。（<a href="//wp-simplicity.com/hide-user-name/">詳細</a>）このメッセージは、通常の訪問者には表示されません。</span>
<?php
else: //通常の投稿者表示 ?>
<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a>
<?php endif ?></span></span>
<?php endif; ?>
