<?php

$settings = array(
   /**
    * Base forum name
    *
    * Specify the name of the forum. One might use domain name or site name.
    * Default: ZF2 DlForum
    */
    'forum_base_name' => 'the De Montfort Video Gaming Society Forums',

    /**
     * Zend\Db\Adapter\Adapter DI Alias
     *
     * Please specify the DI alias for the configured Zend\Db\Adapter\Adapter
     * instance that DlForum should use.
     */
    'zend_db_adapter' => 'Zend\Db\Adapter\Forum',
);


return array(
    'dlforum' => $settings,
    'service_manager' => array(
        'aliases' => array(
            'dlforum_zend_db_adapter' => (isset($settings['zend_db_adapter'])) ? $settings['zend_db_adapter']: 'Zend\Db\Adapter\Adapter',
        ),
    ),
);
