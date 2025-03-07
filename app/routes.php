<?php

return [
    /* Authentication */
    '/' => 'User@index',
    '/login' => 'User@login',
    '/logout' => 'User@logout',
    '/forgotPassword' => 'User@forgotPassword',

    /* Super Admin Routes */
    '/super_admin/home' => 'SuperAdmin@index',
    '/super_admin/messages' => 'SuperAdmin@messages',
    '/super_admin/competency' => 'SuperAdmin@competency',
    '/super_admin/competency/create' => 'SuperAdmin@createEmployee',
    '/super_admin/competency/edit/{user_id}' => 'SuperAdmin@editEmployee',
    '/super_admin/competency/delete/{user_id}' => 'SuperAdmin@deleteEmployee',
    '/super_admin/forgot_requests' => 'SuperAdmin@forgot_requests',
    '/super_admin/forgot_requests/approve/{user_id}' => 'SuperAdmin@approveRequest',
    '/super_admin/forgot_requests/reject/{user_id}' => 'SuperAdmin@rejectRequest',
    '/super_admin/accounts' => 'SuperAdmin@accounts',
    '/super_admin/accounts/create' => 'SuperAdmin@createAccount',
    '/super_admin/accounts/edit/{user_id}' => 'SuperAdmin@editAccount',
    '/super_admin/accounts/delete/{user_id}' => 'SuperAdmin@deleteAccount',

    /* Admin Routes */
    '/admin/home' => 'Admin@index',
    '/admin/messages' => 'Admin@messages',
    '/admin/competency' => 'Admin@competency',
    '/admin/competency/create' => 'Admin@createEmployee',
    '/admin/competency/edit/{user_id}' => 'Admin@editEmployee',
    '/admin/competency/delete/{user_id}' => 'Admin@deleteEmployee',
    '/admin/forgot_requests' => 'Admin@forgot_requests',
    '/admin/forgot_requests/approve/{user_id}' => 'Admin@approveRequest',
    '/admin/forgot_requests/reject/{user_id}' => 'Admin@rejectRequest',

    /* Supervisor Routes */
    '/supervisor/home' => 'Supervisor@index',

    '/supervisor/messages' => 'Supervisor@messages',

    '/supervisor/modules' => 'Supervisor@modules',
    '/supervisor/modules/create' => 'Supervisor@createModule',
    '/supervisor/modules/edit/{module_id}' => 'Supervisor@editModule',
    '/supervisor/modules/delete/{module_id}' => 'Supervisor@deleteModule',
    '/supervisor/modules/{module_id}/tasks/create' => 'Supervisor@createTask',
    '/supervisor/tasks/edit/{task_id}' => 'Supervisor@editTask',
    '/supervisor/tasks/delete/{task_id}' => 'Supervisor@deleteTask',
    '/supervisor/tasks/{task_id}/questions/create' => 'Supervisor@createQuestion',
    '/supervisor/questions/edit/{question_id}' => 'Supervisor@editQuestion',
    '/supervisor/questions/delete/{question_id}' => 'Supervisor@deleteQuestion',

    /* Employee Routes */
    '/employee/home' => 'Employee@index',
    '/employee/about' => 'Employee@about',
    '/employee/modules/activate/{module_id}' => 'Employee@activateModule',

    /* Messages Routes */
    '/message/sendMessage' => 'Message@sendMessage',
    '/message/getMessages/{receiver_id}' => 'Message@getMessages',
];
