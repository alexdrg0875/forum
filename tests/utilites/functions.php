<?php

function create($class, $arrributes = [], $times = null)
{
    return factory($class, $times)->create($arrributes);
}

function make($class, $arrributes = [], $times = null)
{
    return factory($class, $times)->make($arrributes);
}
