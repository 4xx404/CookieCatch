<?php
class Hash {
	public static function Make($String = null) {
		return (($String !== null) ? md5($String) : md5(uniqid()));
	}
}