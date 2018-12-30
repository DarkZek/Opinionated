<?php namespace Opinionated;

class AuditFormatter {
  public static function Format($item) {
    $formatted_message = AuditFormatter::GetMessage($item->action);

    //Add data to message
    $formatted_message = str_replace("{user_id}", $item->user_id, $formatted_message);
    $formatted_message = str_replace("{content}", $item->content, $formatted_message);

    return $formatted_message;
  }

  private static function GetMessage($key) {
    switch ($key) {
      case "CHANGE_PASSWORD":
        return "User #{user_id} changed their password";
      case "CHANGE_EMAIL":
        return "User #{user_id} changed their email address to {content}";
      case "CHANGE_DISPLAY_NAME":
        return "User #{user_id} changed their display name to {content}";
      case "CHANGE_USERNAME":
        return "User #{user_id} changed their username to {content}";
      case "SUBMIT_POLL":
        return "User #{user_id} submitted a poll named {content}";
      case "SUBMIT_PERSPECTIVE":
        return "User #{user_id} submitted a perspective";
    }
  }
}
