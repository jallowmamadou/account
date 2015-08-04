<?php
/**
 * Created by mamadou.
 * User: mamadou
 * Date: 7/19/2015
 * Time: 5:08 AM
 */

namespace Sulsira\Accounts\Traits;


trait Takes {

    public static $instance;

    public function init(){
        return $this;
    }
    public static function __callStatic($name, $args){

        $args = empty($args) ? [] : $args[0];

        $instance = static::$instance;

        if ( ! $instance) $instance = static::$instance = new static;

        return $instance->$name($args);
    }

} 