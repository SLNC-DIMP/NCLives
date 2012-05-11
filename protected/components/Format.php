<?php
class Format {
	public function formatQuery(array $fields) {
		array_pop($fields);
		$field_values = '';
		foreach($fields as $key => $field) {
			$field_values .= "$key = ?,";
		}
			 
		return $this->commaReplace($field_values);
	}
		
	protected function commaReplace($string) {
		return substr_replace($string, '', -1);
	}
}