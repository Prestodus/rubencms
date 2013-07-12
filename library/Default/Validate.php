<?php

class Default_Validate {
	
	public static function validate_email($address) {
		return filter_var($address, FILTER_VALIDATE_EMAIL);
	}
	
}