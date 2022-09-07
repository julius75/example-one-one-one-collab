<?php
/**
 * Created by PhpStorm
 * User: jjoek
 * Date: 12/4/20
 * Time: 10:56 pm
 */

namespace Units;


use Ignite\Settings\Entities\Settings;
use Ignite\Users\Entities\User;

class JoeTests extends \TestCase
{
    /** @test */
    public function dummyTests()
    {
        $settings =  Settings::where('value', '!=', '0')->whereNotNull('value')->select(['name', 'value'])->get()
            ->map(function($item) {
                return [
                    'name' => str_replace('::', '.', $item->name),
                    'value' => $item->value,
                ];
            })->count();


        User::

        dd($settings);
    }

}
