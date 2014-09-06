<?php


namespace MaxBrokman\GitChangeLog;


class ChangeLogEntry {

    /** @var array */
    protected $attributes = [];

    public function __construct($attributes = null)
    {
        if($attributes) {
            $this->fill($attributes);
        }
    }

    public function fill($attributes)
    {
        $this->attributes = $attributes;
    }

    public function __get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }
} 