<?php

class Factory
{
    public static function Model($model_name)
    {
        $model = ucwords($model_name) . "Model";
        return new $model;
    }

    public static function Library($library_name)
    {
        return new $library_name;
    }
}