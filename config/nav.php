<?php
return [
    'dashboard' => [
        'title'=> 'Dashboard',
        'icon'=> 'fa fa-shower',
        'route'=>'/dashboard',
    ],
    'categories' => [
        'title'=> 'Categories',
        'icon'=> 'for fa-circle nav-icon',
        'route'=>'/dashboard/categories',
        'badge'=>[
            'class'=> 'warning',
            'label'=>'New'
        ],
    ],


    'create' => [
        'title'=> 'Create Category',
        'icon'=> 'fa fa-shopping-basket',
        'route'=>'/dashboard/categories/create',
        'badge'=>[
            'class'=> 'success',
            'label'=>'Add'
        ],
    ],


    'orders' => [
        'title'=> 'Orders',
        'icon'=> 'fa fa-shopping-basket',
        'route'=>'/dashboard/orders',
    ],

    'profiles' => [
        'title'=> 'Update Profile',
        'icon'=> 'fa fa-user',
        'route'=>'/profile',
    ],

    'Change Password' => [
        'title'=> 'Change Password',
        'icon'=> 'fa fa-key',
        'route'=>'/change-password',
    ],


    'products' => [
        'title'=> 'Product',
        'icon'=> 'fa fa-podcast',
        'route'=>'/dashboard/products',
        'badge'=>[
            'class'=> 'danger',
            'label'=>'main'
        ],
    ],

    'product' => [
        'title'=> 'Create Product',
        'icon'=> 'fa fa-podcast',
        'route'=>'/dashboard/products/create',
        'badge'=>[
            'class'=> 'success',
            'label'=>'Add'
        ],
    ],

    'products' => [
        'title'=> ' Product',
        'icon'=> 'fa fa-podcast',
        'route'=>'/dashboard/products',
        'badge'=>[
            'class'=> 'info',
            'label'=>'main'
        ],
    ],
];
