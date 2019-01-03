<?php namespace Opinionated;

class AuditFormatter {
  public static function Format($item) {
    $formatted_message = AuditFormatter::GetMessage($item->action);

    //Add data to message
    $formatted_message = str_replace("{user_id}", $item->user_id, $formatted_message);
    $formatted_message = str_replace("{content}", $item->content, $formatted_message);

    $icon = '<i class="material-icons audit-icon" style="vertical-align: text-bottom;padding-right: 8px;">' . AuditFormatter::GetIcon($item->action) . '</i>';

    return '<a href="/admin/database/user?id=' . $item->user_id . '">' . $icon . $formatted_message . "</a>";
  }

  private static function GetMessage($key) {
    switch ($key) {
      case "CHANGE_PASSWORD":
        return "User #{user_id} changed their password";
      case "CHANGE_EMAIL":
        return "User #{user_id} changed their email address to {content}";
      case "CHANGE_DISPLAY_NAME":
        return "User #{user_id} changed their display name to {content}";
      case "SUBMIT_POLL":
        return "User #{user_id} submitted a poll named {content}";
      case "SUBMIT_PERSPECTIVE":
        return "User #{user_id} submitted a perspective";
    }
  }

  private static function GetIcon($key) {
    switch ($key) {
      case "CHANGE_PASSWORD":
        return "https";
      case "CHANGE_EMAIL":
        return "markunread_mailbox";
      case "CHANGE_DISPLAY_NAME":
        return "face";
      case "SUBMIT_POLL":
        return "explore";
      case "SUBMIT_PERSPECTIVE":
        return "account_circle";
    }
  }
}
