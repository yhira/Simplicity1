<?php //エントリーカードのコンテンツ部分のテンプレート
//通常のエントリーカードクラス
$entry_class = 'entry-card-content';
//通常のエントリーカードの場合意外
if ( is_list_style_large_cards() ||
     //最初だけ大きなエントリーカードの最初のエントリーだけ
     ( is_list_style_large_card_just_for_first() && is_list_index_first() )
   )
  $entry_class = 'entry-card-large-content';
 ?>
<div class="<?php echo $entry_class; ?>">

  <h2><a href="<?php the_permalink(); ?>" class="entry-title entry-title-link" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
  <p class="post-meta">
    <?php if ( is_create_date_visible() ): //投稿日を表示する場合?>
    <span class="post-date"><span class="fa fa-clock-o fa-fw"></span><span class="published"><?php the_time( get_theme_text_date_format() ) ;?></span></span>
    <?php endif; //is_create_date_visible?>

    <?php if ( is_category_visible() && //カテゴリを表示する場合
               get_the_category() ): //投稿ページの場合?>
    <span class="category"><span class="fa fa-folder fa-fw"></span><?php the_category(', ') ?></span>
    <?php endif; //is_category_visible?>

    <?php //コメント数を表示するか
    if ( is_comments_visible() && is_list_comment_count_visible() ):
      $comment_count_anchor = ( get_comments_number() > 0 ) ? '#comments' : '#reply-title'; ?>
      <span class="comments">
        <span class="fa fa-comment"></span>
        <span class="comment-count">
          <a href="<?php echo get_the_permalink() . $comment_count_anchor; ?>" class="comment-count-link"><?php echo get_comments_number(); ?></a>
        </span>
      </span>
    <?php endif ?>

  </p><!-- /.post-meta -->
  <p class="entry-snippet"><?php echo get_the_custom_excerpt( get_the_content(''), get_excerpt_length() ); //カスタマイズで指定した文字の長さだけ本文抜粋?></p>

  <?php if ( get_theme_text_read_entry() ): //「記事を読む」のようなテキストが設定されている時 ?>
<p class="entry-read"><a href="<?php the_permalink(); ?>" class="entry-read-link"><?php echo get_theme_text_read_entry(); //記事を読む ?></a></p>
  <?php endif; ?>

</div><!-- /.entry-card-content -->