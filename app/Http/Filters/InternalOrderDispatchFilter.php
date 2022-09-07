<?php

namespace Dervis\Http\Filters;

use Agog\Osmose\Library\FormFilter;
use Agog\Osmose\Library\FilterInterface;

class InternalOrderDispatchFilter extends FormFilter implements FilterInterface
{
    /**
     * Defines form elements and sieve values
     * @return array
     */
    public function residue()
    {
        return [

        ];
    }
}