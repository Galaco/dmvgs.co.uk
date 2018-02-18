<?php
return array(
    'db' => array(
     	'blog' => array(
            'database'       => 'dmvgs_blog',
            'hostname'       => 'database',
            'port'	         => getenv('MYSQL_PORT_3306_TCP_ADDR'),
            'username'       => 'root',
            'password'       => getenv('MYSQL_ENV_MYSQL_ROOT_PASSWORD'),
	    ),
        'forum' => array(
	        'database'       => 'dmvgs_forum',
            'hostname'       => 'database',
            'port'  	     => getenv('MYSQL_PORT_3306_TCP_ADDR'),
            'username'       => 'root',
            'password'       => getenv('MYSQL_ENV_MYSQL_ROOT_PASSWORD'),
	    ),
    ),
);
