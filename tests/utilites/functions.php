<?php

function create($class, $arrributes = [])
{
    return factory($class)->create($arrributes);
}

function make($class, $arrributes = [])
{
    return factory($class)->make($arrributes);
}
