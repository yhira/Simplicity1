<?php
////////////////////////////////
//投稿日と更新日のテンプレート
////////////////////////////////
$human_time_diff = '';
if ( is_human_time_diff_visible() )//時間差を表示するか
  $human_time_diff = '<span class="post-human-def-diff">（<span class="post-human-date-diff-in">'.human_time_diff( get_the_time('U'), current_time('timestamp') ).'前</span>）</span>';
if ( is_seo_date_update() && //検索エンジンに更新日を伝える場合
      get_mtime('c') ): //かつ更新日がある場合?>
    <?php if ( is_create_date_visible() ): //投稿日を表示する場合?>
      <span class="post-date"><span class="fa fa-clock-o fa-fw"></span><span class="entry-date date published"><?php the_time( get_theme_text_date_format() ) ;?></span><?php echo $human_time_diff; ?></span>
    <?php endif; //is_create_date_visible?>
    <?php if ( is_update_date_visible() ): //更新日を表示する場合?>
      <span class="post-update"><span class="fa fa-history fa-fw"></span><time class="entry-date date updated" datetime="<?php echo get_the_time('c') ;?>"><?php if ($mtime = get_mtime( get_theme_text_date_format() )) echo $mtime; ?></time></span>
    <?php endif; //is_update_date_visible?>
<?php else: //検索エンジンに投稿日を伝える場合?>
  <?php if ( is_create_date_visible() ): //投稿日を表示する場合?>
    <span class="post-date"><span class="fa fa-clock-o fa-fw"></span><time class="entry-date date published<?php echo ( get_mtime('c') && is_update_date_visible() ? '' : ' updated' ); ?>" datetime="<?php echo get_the_time('c');?>"><?php the_time( get_theme_text_date_format() ) ;?></time><?php echo $human_time_diff; ?></span>
  <?php endif; //is_create_date_visible?>
  <?php if ( is_update_date_visible() && //更新日を表示する場合
             get_mtime('c') ) : //更新日があるどき?>
    <span class="post-update"><span class="fa fa-history fa-fw"></span><span class="entry-date date updated"><?php if ($mtime = get_mtime( get_theme_text_date_format() )) echo $mtime; ?></span></span>
  <?php endif; //is_update_date_visible?>
<?php endif; ?>
