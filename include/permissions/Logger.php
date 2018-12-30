<?php
class Logger {
  public static function Log($conn, $user_id, $action, $content = null, $admin_id = null) {
    $sql = "INSERT INTO audit_log (user_id, action, content, admin_id) VALUES (?, ?, ?, ?);";
    $statement = $conn->prepare($sql);
    $result = $statement->execute([$user_id, $action, $content, $admin_id]);
  }
}
