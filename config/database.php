<?php

class ConfigDatabase {
  public static function get_config_string() {
    return self::config_to_string(self::CONFIG);
  }

  const CONFIG = array(
    "user" => "vikfroberg",
    "password" => "7833",
    "dbname" => "es_dev",
    "host" => "localhost",
    "port" => "5432"
  );

  static function config_to_string($config) {
    $keys = array_keys($config);
    $values = array_values($config);

    function mapper($value, $key) {
      return $key . "=" . $value;
    };

    return join(" ", array_map(mapper, $values, $keys));
  }
}
