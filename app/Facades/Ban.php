<?php namespace Verein\Facades;

use Illuminate\Support\Facades\Facade;

class Ban extends Facade
{
    protected static function getFacadeAccessor()
    {
    	return 'sentinel.bans';
    }
}
