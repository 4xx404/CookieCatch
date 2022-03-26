<?php
class Hash {
	public static function Make($String = null) {
		return md5(uniqid());
	}
}