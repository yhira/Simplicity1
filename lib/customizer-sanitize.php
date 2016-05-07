<?php //テーマカスタマイザーのサニタイズ関数


function sanitize_text( $str ) {
  return sanitize_text_field( $str );
}

function sanitize_html_text( $str ) {
  $str = trim(strip_tags( $str ));
  $str = htmlspecialchars($str);
  return sanitize_text_field( $str );
}

//ID入力用のカンマ区切りテキストから余計な文字を取り除く
function sanitize_id_comma_text( $comma_text ) {
  $removed_comma_text = trim( sanitize_text_field( $comma_text ) );
  $removed_comma_text = preg_replace('/[^\d,]/i', '', $removed_comma_text);
  return $removed_comma_text;
}

function sanitize_textarea( $text ) {
  return esc_textarea( $text );
}

function sanitize_number( $int ) {
  return absint( $int );
}

function sanitize_check( $value ) {
  return $value;
}

function sanitize_file_url( $url ) {
  $output = '';
  $filetype = wp_check_filetype( $url );
  if ( $filetype["ext"] ) {
    $output = esc_url( $url );
  }
  return $output;
}