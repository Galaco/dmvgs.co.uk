<?php
return array(
'service_manager' => array(
    'factories' => array(
	    'Zend\Db\Adapter\Blog' => function ($sm) {
	        $config   = $sm->get('config');
	        $dbParams = $config['db']['blog'];

	        $adapter = new \Zend\Db\Adapter\Adapter(array(
	            'driver'    => 'pdo',
                'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'].';port='.$dbParams['port'],
                'database'  => $dbParams['database'],
                'username'  => $dbParams['username'],
                'password'  => $dbParams['password'],
                'hostname'  => $dbParams['hostname'],
                'driver_options' => array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ),
            ));

	        return $adapter;
	        },
        'Zend\Db\Adapter\Forum' => function ($sm) {
                $config   = $sm->get('config');
                $dbParams = $config['db']['forum'];

                $adapter = new \Zend\Db\Adapter\Adapter(array(
                    'driver'    => 'pdo',
                    'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'].';port='.$dbParams['port'],
                    'database'  => $dbParams['database'],
                    'username'  => $dbParams['username'],
                    'password'  => $dbParams['password'],
                    'hostname'  => $dbParams['hostname'],
                    'driver_options' => array(
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                    ),
                ));

                return $adapter;
            },
    ),
),);
