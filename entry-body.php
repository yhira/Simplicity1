<?php //投稿本文 ?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="article<?php if ( !is_single() ) echo ' article-list'; ?>">
  <?php  if ( is_single() ) get_template_part('sns-buttons-sharebar'); //スクロール追従シェアバー ?>

  <h1 class="entry-title">
    <?php if ( !is_single() ) echo '<a href="'.get_permalink().'">'; //投稿ページ以外ではタイトルにリンクを貼る?>
    <?php the_title(); //投稿のタイトル?>
    <?php if ( !is_single() ) echo '</a>'; //投稿ページ以外ではタイトルにリンクを貼る?>
  </h1>
  <p class="post-meta">
    <?php get_template_part('datetime') //投稿日と更新日?>
    <?php if ( is_category_visible() && //カテゴリを表示する場合
               get_the_category() ): //投稿ページの場合?>
    <span class="category"><span class="fa fa-folder fa-fw"></span><?php the_category(', ') ?></span>
    <?php endif; //is_category_visible?>

    <?php //コメント数
    if ( is_comments_visible() && is_comment_count_visible() ):
      $comment_count_anchor = ( get_comments_number() > 0 ) ? '#comments' : '#reply-title'; ?>
      <span class="comments">
        <span class="fa fa-comment"></span>
        <span class="comment-count">
          <a href="<?php echo get_permalink().$comment_count_anchor; ?>" class="comment-count-link"><?php echo get_comments_number(); ?></a>
        </span>
      </span>
    <?php endif //is_comment_count_visible?>

    <?php if ( is_single() ) get_template_part('edit-link'); //編集リンク?>

    <?php wlw_edit_post_link('WLWで編集', '<span class="wlw-edit"><span class="fa fa-pencil-square-o fa-fw"></span>', '</span>'); ?>
  </p>

  <?php if ( is_single() ) get_template_part('ad-top');//記事トップ広告 ?>

  <?php if ( is_single() ) get_template_part('sns-buttons-top');//タイトル下の小さなシェアボタン?>

  <?php //投稿本文上ウイジェット
  if ( is_single() && is_active_sidebar( 'widget-over-article' ) ): ?>
    <div id="widget-over-article" class="widgets">
    <?php dynamic_sidebar( 'widget-over-article' ); ?>
    </div>
  <?php endif; ?>

  <?php if ( has_post_thumbnail() && is_eye_catch_visible() ): // サムネイルを持っているときの処理 ?>
  <div class="eye-catch">
      <?php
          //the_post_thumbnail('large');
          //アイキャッチの表示
          the_post_thumbnail('large');
          //アイキャッチのキャプション機能が有効のとき
          if( is_eye_catch_caption_visible() &&
            //アイキャッチにキャプションが設定されているとき
            get_post( get_post_thumbnail_id() )->post_excerpt ) {
              echo '<div class="eye-catch-caption">' . get_post( get_post_thumbnail_id() )->post_excerpt . '</div>';
          }
      ?>
  </div>
  <?php endif; ?>

  <div id="the-content" class="entry-content">
  <?php //記事本文の表示
    the_content( get_theme_text_read_more() ); //デフォルト：続きを読む?>
  </div>

  <?php if ( is_single() ) get_template_part('pager-page-links');//ページリンクのページャー?>

  <?php //投稿本文下ウイジェット
  if ( is_single() && is_active_sidebar( 'widget-under-article' ) ): ?>
    <div id="widget-under-article" class="widgets">
    <?php dynamic_sidebar( 'widget-under-article' ); ?>
    </div>
  <?php endif; ?>

  <?php if ( is_single() ) get_template_part('ad-article-footer');?>


  <?php //投稿SNSボタン上ウイジェット
  if ( is_single() && is_active_sidebar( 'widget-over-sns-buttons' ) ): ?>
    <div id="widget-over-sns-buttons" class="widgets">
    <?php dynamic_sidebar( 'widget-over-sns-buttons' ); ?>
    </div>
  <?php endif; ?>

  <div id="sns-group" class="sns-group sns-group-bottom">
  <?php if ( is_single() && is_bottom_sns_btns_visible() )
    get_template_part('sns-buttons'); //SNSシェアボタンの取得?>

  <?php if ( is_single() &&
             is_body_bottom_follows_visible() ) //記事下フォローボタン表示のとき
               get_template_part('sns-pages'); //SNSフォーローボタンの取得?>
  </div>

  <?php //投稿SNSボタン下ウイジェット
  if ( is_single() && is_active_sidebar( 'widget-under-sns-buttons' ) ): ?>
    <div id="widget-under-sns-buttons" class="widgets">
    <?php dynamic_sidebar( 'widget-under-sns-buttons' ); ?>
    </div>
  <?php endif; ?>

  <p class="footer-post-meta">

    <?php if (is_tag_visible()): ?>
    <span class="post-tag"><?php the_tags('<span class="fa fa-tag fa-fw"></span>',', '); ?></span>
    <?php endif; ?>

    <?php if ( is_single() ) get_template_part('author-link') //投稿者リンク?>

    <?php if ( is_single() ) get_template_part('edit-link') //編集リンク?>

    <?php if ( is_single() ) wlw_edit_post_link('WLWで編集', '<span class="wlw-edit"><span class="fa fa-pencil-square-o fa-fw"></span>', '</span>'); ?>
  </p>

  </div><!-- .article -->
  <?php if ( is_list_style_bodies() ): //本文リストスタイルの時?>
  <hr class="sep" />
  <?php endif; ?>
</div><!-- .post -->