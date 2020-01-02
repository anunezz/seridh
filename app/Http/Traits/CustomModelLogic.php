<?php
namespace App\Http\Traits;
/**
 * Created by PhpStorm.
 * User: michelnogales
 * Date: 3/26/19
 * Time: 11:26 AM
 */
trait CustomModelLogic {
	/**
	 * @var bool
	 */
	public static $withoutAppends = false;

	/**
	 * Check if $withoutAppends is enabled.
	 *
	 * @return array
	 */
	protected function getArrayableAppends()
	{
		if(self::$withoutAppends){
			return [];
		}
		return parent::getArrayableAppends();
	}
}