<?php

function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

function make($class, $attributes = [])
{
    return factory($class)->make($attributes);
}

function createAdmin(){
    return create(\App\User::class, [
        'role' => 'admin'
    ]);
}