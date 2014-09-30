<?php

/**
 * @file
 * Valve's Source Engine server fake that responds to info requests.
 *
 * @see https://developer.valvesoftware.com/wiki/Server_queries
 */

// Bind a socket to the first default Source port. Be sure to listen on address 0.0.0.0 so that
// broadcast packets are picked up under Linux.
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
socket_bind($socket, '0.0.0.0', 27015);

// Team Fortress 2 server (with port).
$response = hex2bin('ffffffff49115465616d20466f72747265737300706c5f6261647761746572007466005465616d20466f72747265737300b801001800646c00013234323030383000b101c0023ca209541240017061796c6f616400b801000000000000');
do {
  // Block until data received.
  $from = '';
  $from_port = 0;
  socket_recvfrom($socket, $buffer, 256, 0, $from, $from_port);

  echo "Received A2S_INFO request from $from:$from_port" . PHP_EOL;

  socket_sendto($socket, $response, strlen($response), 0, $from, $from_port);
}
// Used for testing: pass any extra argument to cause loop to only execute once.
while ($argc == 1);

socket_close($socket);
