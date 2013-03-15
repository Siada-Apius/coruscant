<?php

return array(
    array
    (
        'label' => 'Home',
        'id' => 'home',
        'module' => 'default',
        'controller' => 'index',
        'action' => 'index',
        'route' => 'default',

        'pages' => array
        (
            array (

                'label' => 'Master',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'index',
                'action' => 'index',
                'resource' => 'index',
                'privilege' => 'index',
            ),
            array (

                'label' => 'Wanna cookie',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'user',
                'action' => 'login',
                'resource' => 'user',
                'privilege' => 'login',
            ),
            array (

                'label' => 'Media',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'media',
                'action' => 'index',
                'resource' => 'media',
                'privilege' => 'index',
            ),
            array (
                'label' => 'Suicide',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'user',
                'action' => 'logout',
                'resource' => 'user',
                'privilege' => 'logout',
            ),
            // for admin only
            array (

                'label' => 'Master',
                'tag' => 'admin',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'index',
                'resource' => 'admin',
                'privilege' => 'index',
            ),
            array (

                'label' => 'Almighty',
                'tag' => 'admin',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'media',
                'resource' => 'admin',
                'privilege' => 'media',
            ),
            array (

                'label' => 'Kill Them All',
                'tag' => 'admin',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'user',
                'resource' => 'admin',
                'privilege' => 'user',
            ),
            array (
                'label' => 'Suicide',
                'tag' => 'admin',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'user',
                'action' => 'logout',
                'resource' => 'user',
                'privilege' => 'logout',
            )
        )
    )
);