<?php
  $host = "192.168.0.109";
  $port = 4444;

  set_time_limit(0);

  $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("ERROR - Could not create socket\n");
  $result = socket_bind($socket, $host, $port) or die("ERROR - Could not bind to socket\n");
  $result = socket_listen($socket, 3) or die("ERROR - Could not set up socket listener\n");
  $spawn = socket_accept($socket) or die("ERROR - Could not accept incoming connection\n");
  $input = socket_read($spawn, 1024) or die("ERROR - Could not read input\n");
  $output = strrev($input) . "\n";
  socket_write($spawn, $output, strlen ($output)) or die("ERROR - Could not write output\n");

  socket_close($spawn);
  socket_close($socket);
?>
