<?php

namespace Modules\Core\Events;

class ModuleDisabled
{
    public $moduleName;

    public function __construct($moduleName)
    {
        $this->moduleName = $moduleName;
    }
} 