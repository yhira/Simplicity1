<?php
////////////////////////////
//パンくずリスト
////////////////////////////
  if (is_category()) {
    get_template_part('breadcrumbs');
  }
?>

<?php
////////////////////////////
//アーカイブのタイトル
////////////////////////////
if (!is_home() && !is_search()) { ?>
  <h1 id="archive-title">「
    <?php if( is_category() ) { ?>
    <?php single_cat_title(); ?>
    <?php } elseif( is_tag() ) { ?>
    <?php single_tag_title(); ?>
    <?php } elseif( is_tax() ) { ?>
    <?php single_term_title(); ?>
    <?php } elseif (is_day()) { ?>
    <?php echo get_the_time( get_theme_text_ymd_format() );//年月日のフォーマットを取得 ?>
    <?php } elseif (is_month()) { ?>
    <?php echo get_the_time( get_theme_text_ym_format() );//年と月のフォーマットを取得 ?>
    <?php } elseif (is_year()) { ?>
    <?php echo get_the_time( get_theme_text_y_format() );//年のフォーマットを取得 ?>
    <?php } elseif (is_author()) { ?>
    <?php echo esc_html(get_queried_object()->display_name); ?>
    <?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    Archives
    <?php } else { ?>
    Archives
    <?php } ?>
  」<?php echo get_theme_text_list();//「一覧」部分の取得 ?>
  </h1>
<?php } ?>


<?php
////////////////////////////
//トップの広告
////////////////////////////
if (!is_home() || is_ads_top_page_visible())//メインページ以外は広告を出す
  get_template_part('ad-top');//記事トップ広告 ?>

<?php
////////////////////////////
//インデックスリストトップウィジェット
////////////////////////////
if ( is_active_sidebar( 'widget-index-top' ) ):
  echo '<div id="widget-index-top" class="widgets">';
  dynamic_sidebar( 'widget-index-top' );
  echo '</div>';
endif; ?>

<?php
////////////////////////////
//カテゴリ説明文の挿入
////////////////////////////
if (is_category() && //カテゴリページの時
          !is_paged() &&   //カテゴリページのトップの時
          category_description()) : //カテゴリの説明文が空でない時 ?>
<!-- カテゴリの説明文 -->
<div class="category-description"><?php echo category_description(); ?></div>
<?php endif; ?>

<?php
////////////////////////////
//タグ説明文の挿入
////////////////////////////
if (is_tag() && //タグページの時
          !is_paged() &&   //タグページのトップの時
          tag_description()) : //タグの説明文が空でない時 ?>
<!-- カテゴリの説明文 -->
<div class="category-description tag-description"><?php echo tag_description(); ?></div>
<?php endif; ?>

<div id="list">
<!-- 記事一覧 -->
<?php
////////////////////////////
//一覧の繰り返し処理
////////////////////////////
if (have_posts()) : // WordPress ループ
  $count = 0;
  while (have_posts()) : the_post(); // 繰り返し処理開始
    $count += 1;
    global $g_list_index;
    $g_list_index = $count-1;//インデックスなので-1

    //一覧リストのスタイル
    if ( is_list_style_bodies() ) {//一覧表示スタイルが本文表示
      get_template_part('entry-body');//一覧表示スタイルが本文表示の場合
    } else if ( is_list_style_large_cards() ){//大きなエントリーカードの場合
      get_template_part('entry-card-large');
    } else if ( is_list_style_large_card_just_for_first() ){//最初だけ大きなエントリーカードの場合
      //最初だけ大きなものであとは普通のエントリーカード
      if ( is_home() && !is_paged() && $count == 1 ) {
        get_template_part('entry-card-large');
      } else {
        get_template_part('entry-card');
      }
    } else if ( is_list_style_body_just_for_first() ){//最初だけ本文表示の場合
      //最初だけ本文表示であとは普通のエントリーカード
      if ( is_home() && !is_paged() && $count == 1 ) {
        get_template_part('entry-body');
      } else {
        get_template_part('entry-card');
      }
    } else {//エントリーカードか、大きなサムネイルカードの場合
      //一覧表示スタイルがカードor大きなサムネイルカード表示の場合
      get_template_part('entry-card');
    }

    //トップページ中間に広告を表示できるかどうか（表示するかどうか）
    if ( is_ads_list_in_middle_on_top_page_enable($count) ) {
      get_template_part('ad');
    }

    //3つ目のアイテムの下にインデックスリストミドルウィジェットを表示するか
    if ( $count == 3 && is_list_style_entry_cards() && is_active_sidebar( 'widget-index-middle' ) ) {
      echo '<div id="widget-index-middle" class="widgets">';
      dynamic_sidebar( 'widget-index-middle' );
      echo '</div>';

    }

  endwhile; // 繰り返し処理終了 ?>
  <div class="clear"></div>
<?php else : // ここから記事が見つからなかった場合の処理  ?>
    <div class="post">
      <h2>NOT FOUND</h2>
      <p><?php echo get_theme_text_not_found_message();//見つからない時のメッセージ ?></p>
    </div>
<?php
endif;
?>
</div><!-- /#list -->

<?php
////////////////////////////
//ボトムの広告
////////////////////////////
if (!is_home() || is_ads_top_page_visible()) ://メインページ以外は広告を出す
  get_template_part('ad-article-footer' );
endif; ?>

<?php
////////////////////////////
//インデックスリストボトムウィジェット
////////////////////////////
if ( is_active_sidebar( 'widget-index-bottom' ) ):
  echo '<div id="widget-index-bottom" class="widgets">';
  dynamic_sidebar( 'widget-index-bottom' );
  echo '</div>';
endif; ?>

<?php
////////////////////////////
//エントリーのページャー
////////////////////////////
if ( is_list_pager_type_responsive() ) {
  //レスポンシブタイプのページャー関数の呼び出し
  responsive_pagination();
} else {
  //旧タイプのページャー
  get_template_part('pager-paginate-links');
}
?>