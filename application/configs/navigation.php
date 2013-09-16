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
            /*array (

                'label' => 'Wanna cookie',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'user',
                'action' => 'login',
                'resource' => 'user',
                'privilege' => 'login',
            ),*/
            array (

                'label' => 'Movie',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'movie',
                'action' => 'index',
                'resource' => 'movie',
                'privilege' => 'index',
            ),
            array (

                'label' => 'Games',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'games',
                'action' => 'index',
                'resource' => 'games',
                'privilege' => 'index',
            ),
            /*array (

                'label' => 'Archive',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'archive',
                'action' => 'index',
                'resource' => 'archive',
                'privilege' => 'index',
            ),
            array (

                'label' => 'About',
                'tag' => 'topMenu',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'about',
                'action' => 'index',
                'resource' => 'about',
                'privilege' => 'index',
            ),*/
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

                'label' => 'Movies',
                'tag' => 'admin',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'movie',
                'resource' => 'admin',
                'privilege' => 'movie',
            ),
            array (

                'label' => 'Games',
                'tag' => 'admin',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'games',
                'resource' => 'admin',
                'privilege' => 'games',
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
            ),

            //second admin menu INDEX
            array (

                'label' => 'Add new articles',
                'tag' => 'subAdminMenuIndex',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'add',
                'resource' => 'admin',
                'privilege' => 'add',
                'params'     => array('article' => ''),

            ),
            array (

                'label' => 'Work with comments',
                'tag' => 'subAdminMenuIndex',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'comments',
                'resource' => 'admin',
                'privilege' => 'comments',
            ),

            //second admin menu Movie
            array (

                'label' => 'Add new movie',
                'tag' => 'subAdminMenuMovie',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'add',
                'resource' => 'admin',
                'privilege' => 'add',
                'params'     => array('movie' => ''),
            ),

            //second admin menu Games
            array (

                'label' => 'Add new games',
                'tag' => 'subAdminMenuGames',
                'route' => 'default',
                'module' => 'default',
                'controller' => 'admin',
                'action' => 'add',
                'resource' => 'admin',
                'privilege' => 'add',
                'params'     => array('games' => ''),
            ),
        )
    )
);