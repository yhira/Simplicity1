<?php //SEO関係の関数


//Wordpress4.1からのタイトル自動作成
function theme_slug_setup() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'theme_slug_setup' );

//タイトル自動作成をフックして変更したい部分を変更する
if ( !function_exists( 'simplicity_wp_title' ) ):
function simplicity_wp_title( $title ) {
  global $paged, $page;

  if ( is_feed() ) {
    return $title;
  }

  $site_name = trim( get_bloginfo('name') );
  if(is_front_page()):
    $title = $site_name;
    if ( is_catch_phrase_to_frontpage_title() )://キャッチフレーズを追加する場合
       $title = $title. ' | ' . trim( get_bloginfo('description') );
    endif;
  elseif(is_singular()):
    $title = trim( get_the_title() );
    if ( is_site_name_to_singular_title() )://サイト名を追加する場合
       $title = $title. ' | ' . $site_name;
    endif;
  // elseif(is_category()):
  //   $title = single_cat_title( '', false ) .' | ' . $site_name;
  // elseif(is_tag()):
  //   $title = single_tag_title( '', false ) .' | ' . $site_name;
  // elseif(is_archive()):
  //   if ( is_day() ):
  //     $title = get_the_time( get_theme_text_ymd_format() ). ' | ' . $site_name;
  //   elseif ( is_month() ):
  //     $title = get_the_time( get_theme_text_ym_format() ). ' | ' . $site_name;
  //   elseif ( is_year() ):
  //     $title = get_the_time( get_theme_text_y_format() ). ' | ' . $site_name;
  //   endif;
  // elseif(is_search()):
  //   $title = get_search_query(). ' | ' . $site_name;
  // else:
  //   $title = $site_name;
  // endif;
  // if($paged >= 2 || $page >= 2):
  //   $title = $title . ' | '.sprintf('%s page',
  //   max($paged,$page));
  endif;

  return $title;
}
endif;
//Wordpress4.4以上
//add_filter( 'pre_get_document_title', 'simplicity_wp_title');
//Wordpress4.4未満
add_filter( 'wp_title', 'simplicity_wp_title');

if ( !function_exists( 'simplicity_title_separator' ) ):
function simplicity_title_separator( $sep ){
    $sep = ' | ';
    return $sep;
}
endif;
add_filter( 'document_title_separator', 'simplicity_title_separator' );

if ( !function_exists( 'simplicity_title_parts' ) ):
function simplicity_title_parts( $title ){
  $site_name = trim( get_bloginfo('name') );
  $title['tagline'] = '';
  if(is_front_page()):
    $title['title'] = $site_name;
    $title['site'] = '';
    if ( is_catch_phrase_to_frontpage_title() )://キャッチフレーズを追加する場合
      $title['tagline'] = trim( get_bloginfo('description') );
    endif;
  elseif(is_singular()):
    $title['title'] = trim( get_the_title() );
    $title['site'] = '';
    if ( is_site_name_to_singular_title() )://サイト名を追加する場合
      $title['site'] = $site_name;
    endif;
  endif;

  return $title;
}
endif;
add_filter( 'document_title_parts', 'simplicity_title_parts' );

//デフォルトのrel="next"/"prev"を消す
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

////ページネーションと分割ページ（マルチページ）タグを出力
function rel_next_prevlink_tags() {
  //1ページを複数に分けた分割ページ
  if(is_single() || is_page()) {
    global $wp_query;
    $multipage = check_multi_page();
    if($multipage[0] > 1) {
      $prev = generate_multipage_url('prev');
      $next = generate_multipage_url('next');
      if($prev) {
        echo '<link rel="prev" href="'.$prev.'" />'.PHP_EOL;
      }
      if($next) {
        echo '<link rel="next" href="'.$next.'" />'.PHP_EOL;
      }
    }
  } else{
    //トップページやカテゴリページなどの分割ページの設定
    global $paged;
    if ( get_previous_posts_link() ){
      echo '<link rel="prev" href="'.get_pagenum_link( $paged - 1 ).'" />'.PHP_EOL;
    }
    if ( get_next_posts_link() ){
      echo '<link rel="next" href="'.get_pagenum_link( $paged + 1 ).'" />'.PHP_EOL;
    }
  }
}
if ( is_rel_next_prev_link_enable() ) {
  //分割ページのみnext/prevを表示
  add_action( 'wp_head', 'rel_next_prevlink_tags' );
}

//分割ページ（マルチページ）URLの取得
//参考ページ：
//http://seophp.net/wordpress-fix-rel-prev-and-rel-next-without-plugin/
function generate_multipage_url($rel='prev') {
  global $post;
  $url = '';
  $multipage = check_multi_page();
  if($multipage[0] > 1) {
    $numpages = $multipage[0];
    $page = $multipage[1] == 0 ? 1 : $multipage[1];
    $i = 'prev' == $rel? $page - 1: $page + 1;
    if($i && $i > 0 && $i <= $numpages) {
      if(1 == $i) {
        $url = get_permalink();
      } else {
        if ('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending'))) {
          $url = add_query_arg('page', $i, get_permalink());
        } else {
          $url = trailingslashit(get_permalink()).user_trailingslashit($i, 'single_paged');
        }
      }
    }
  }
  return $url;
}

//分割ページ（マルチページ）かチェックする
function check_multi_page() {
  $num_pages    = substr_count(
      $GLOBALS['post']->post_content,
      '<!--nextpage-->'
  ) + 1;
  $current_page = get_query_var( 'page' );
  return array ( $num_pages, $current_page );
}

//デフォルトのcanonicalタグ削除
//remove_action('wp_head', 'rel_canonical');

//canonical URLの生成
function generate_canonical_url(){
  global $paged;

  //canonicalの疑問点
  //アーカイブはnoindexにしているけどcanonicalタグは必要か？
  //タグページはnoindexにしているけどcanonicalタグは必要か？
  //404ページはAll in One SEO Packはcanonicalタグを出力していないようだけど必要か？
  $canonical_url = home_url();
  if (is_home()) {
    $canonical_url = home_url();
  } elseif (is_category()) {
    $canonical_url = get_category_link(get_query_var('cat'));
  } elseif (is_page() || is_single()) {
    $canonical_url = get_permalink();
  // } elseif(is_404()) {
  //   $canonical_url =  home_url()."/404";
  }

  if ($canonical_url && ( $paged >= 2 || $page >= 2)) {
    $canonical_url = $canonical_url.'/page/'.max( $paged, $page ).'';
  }

  return $canonical_url;

}

//canonicalタグの取得
//取得条件；http://bazubu.com/seo101/how-to-use-canonical
function canonical_tag(){
  $canonical_url = generate_canonical_url();
  if ( $canonical_url ) {
    echo '<link rel="canonical" href="'.$canonical_url.'">'.PHP_EOL;
  }
}

if ( !function_exists( 'is_noindex_page' ) ):
function is_noindex_page(){
  return (is_archive() && !is_category()) || //アーカイブページはインデックスに含めない
  is_tag() || //タグページをインデックスしたい場合はこの行を削除
  is_paged()  || //ページの2ページ目以降はインデックスに含めない（似たような内容の薄いコンテンツの除外）
  is_search() || //検索結果ページはインデックスに含めない
  is_attachment(); //添付ファイルページも含めない
}
endif;



