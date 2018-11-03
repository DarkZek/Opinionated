<?php namespace Opinionated;

if (isset($_COOKIE["TUTORIAL_SHOWN"])) {
  return;
}

setcookie(
  "TUTORIAL_SHOWN",
  "TRUE",
  time() + (10 * 365 * 24 * 60 * 60)
);

header("Location: /tutorial_slideshow");
