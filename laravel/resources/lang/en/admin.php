<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'router' => [
        'title' => 'Routers',

        'actions' => [
            'index' => 'Routers',
            'create' => 'New Router',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'router' => [
        'title' => 'Routers',

        'actions' => [
            'index' => 'Routers',
            'create' => 'New Router',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'sapId' => 'SapId',
            'hostname' => 'Hostname',
            'loopback' => 'Loopback',
            'mac_address' => 'Mac address',
            
        ],
    ],

    'router' => [
        'title' => 'Routers',

        'actions' => [
            'index' => 'Routers',
            'create' => 'New Router',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'cisco-router' => [
        'title' => 'Cisco Routers',

        'actions' => [
            'index' => 'Cisco Routers',
            'create' => 'New Cisco Router',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'sapId' => 'SapId',
            'hostname' => 'Hostname',
            'loopback' => 'Loopback',
            'mac_address' => 'Mac address',
            
        ],
    ],

    'router' => [
        'title' => 'Routers',

        'actions' => [
            'index' => 'Routers',
            'create' => 'New Router',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'sapId' => 'SapId',
            'hostname' => 'Hostname',
            'loopback' => 'Loopback',
            'mac_address' => 'Mac address',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];