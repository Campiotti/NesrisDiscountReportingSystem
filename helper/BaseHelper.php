<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 25.10.2017
 * Time: 10:46
 */

namespace helper;

class BaseHelper
{

    protected $renderer;
    /**
     * BaseHelper constructor.
     */
    public function __construct(\Viewrenderer $renderer)
    {
        $this->renderer = $renderer;
    }
}