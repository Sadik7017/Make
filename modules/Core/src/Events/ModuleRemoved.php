<?php

namespace Modules\Core\Events;

class ModuleRemoved
{
    public $moduleName;

    public function __construct($moduleName)
    {
        $this->moduleName = $moduleName;
    }
} 