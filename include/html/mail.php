<?php namespace Opinionated;

class Mail_Utils {
  public static $start_mail_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">".
  "<html xmlns=\"http://www.w3.org/1999/xhtml\">".
  "    <head>".
  "        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />".
  "        <title>A Simple Responsive HTML Email</title>".
  "        <style type=\"text/css\">".
  "        body {margin: 0; padding: 0; min-width: 100%; !important;}".
  "        .content {width: 100%; max-width: 600px;}".
  "        .center {text-align: center; width: 100%;}".
  "        a {display: block; padding-top: 0px;}".
  "        </style>".
  "    </head>".
  "    <body yahoo bgcolor=\"#f6f8f1\">";


  public static $end_mail_html = "</body></html>";
}


function createEmail($contents) {
  $message = Mail_Utils::$start_mail_html;

  foreach ($contents as $fragment) {

    if (isset($fragment->href)) {
      $href = "href=\"" . $fragment->href . "\"";
    } else {
      $href = "";
    }

    if (isset($fragment->type)) {
      $type = $fragment->type;
    } else {
      $type = "a";
    }

    if (isset($fragment->style)) {
      $style = "style=\"" . $fragment->style . "\"";
    } else {
      $style = "";
    }

    $message .= "<" . $type . " " . $style . " " . $href . ">" . $fragment->content . "</" . $type . "><br>";
  }

  $message .= Mail_Utils::$end_mail_html;

  return $message;
}
