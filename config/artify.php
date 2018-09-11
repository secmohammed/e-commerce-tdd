<?php

 return [
  'models' => 
  [
    'role' => 'Role',
    'user' => 'User',
    'namespace' => '\\App\\',
  ],
  'permissions_column' => 'permissions',
  'cache' => 
  [
    'enabled' => true,
    'duration' => 20,
  ],
];