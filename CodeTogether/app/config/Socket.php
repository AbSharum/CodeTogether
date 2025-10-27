<?php

    $address = "0.0.0.0";
    $port = 8060;
    $null = NULL;

    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    socket_bind($sock, $address, $port);
    socket_listen($sock);

    echo "Listening for new connections on port {$port} \n";

    $members = [];
    $connections = [];

    $connections[] = $sock;

    while(true) {
        $reads = $connections;
        $writes = $exceptions = $null;

        socket_select($reads,$writes,$exceptions,0);

        if(in_array($sock,$reads)) {
            $new_connection = socket_accept($sock);
            $connections[] = $new_connection;
            $reply = "Connected to the chat socket server \n";
            socket_write($new_connection, $reply, strlen($reply));

            $sock_index = array_search($sock,$reads);
            unset($reads[$sock_index]);
        }

        foreach($reads as $key => $value) {
            $data = socket_read($value, 1024);

            if(!empty($data)) {
                // data has message
                foreach($connections as $ckey => $cvalue) {
                    if($ckey === 0) continue;
                    socket_write($cvalue,$data, strlen($data));
                }
            } else if ($data === '') {
                echo "Disconnectiong client $key \n";
                unset($connections[$key]);
                socket_close($value);
                // connection close request
            }
        }
    }

    socket_close($sock);