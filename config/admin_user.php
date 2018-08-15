<?php

return [
    'roles' => [
        'admin'            => [
            'name'      => 'admin.roles.admin',
            'sub_roles' => ['coach', 'player'],
        ],
        'coach' => [
            'name'      => 'admin.roles.coach',
            'sub_roles' => ['player'],
        ],
        'player'         => [
            'name'      => 'admin.roles.player',
            'sub_roles' => [],
        ],
    ],
];
