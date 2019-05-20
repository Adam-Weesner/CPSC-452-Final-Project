<?php
  $host    = "192.168.0.109";
  $port    = 4444;
  $message = "Read to Server";
  echo "Hello receiver :".$message;

  $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("ERROR - Could not create socket\n");

  $result = socket_connect($socket, $host, $port) or die("ERROR - Could not connect to server\n");

  socket_write($socket, $message, strlen($message)) or die("ERROR - Could not send data to server\n");

  $result = socket_read ($socket, 1024) or die("ERROR - Could not read server response\n");
  echo "Reply from the server:".$result;

  socket_close($socket);
?>
