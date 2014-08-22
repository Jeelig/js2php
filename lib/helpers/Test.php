<?php
class Test {
  static $stack = array();

  static function suite($name, $fn) {
    array_push(self::$stack, $name);
    $fn(function($description, $condition) {
      Test::assert($description, $condition);
    });
    array_pop(self::$stack);
  }

  static function assert($description, $condition) {
    if ($condition instanceof Closure) {
      $condition = $condition();
    }
    if ($condition !== true) {
      $stack = array_slice(self::$stack, 0);
      array_push($stack, $description);
      throw new Exception('Test Failure: ' . join(': ', $stack));
    }
  }

}
