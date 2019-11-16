<?php
/* src/View/Helper/DateboxHelper.php (using other helpers - specifically, friendsofcake bootstrap form) */

namespace App\View\Helper;

use Cake\View\Helper;
use BootstrapUI\View\Helper\FormHelper as FormHelper;
use Cake\I18n\Time;


class DateboxHelper extends FormHelper
{
	protected function _doOptions( $fieldName, $options, $theseOptions = [] ) {
		$_forcedOptions = [
			"type"                      => "text", 
			"data-role"                 => "datebox",
			"data-datebox-linked-field" => "#" . $fieldName,
			"id"                        => $fieldName . "-dbox",
			"name"                      => $fieldName . "-dbox"
		];
		
		// Add per-element option overrides and forced overrides
		return array_merge($options, $theseOptions, $_forcedOptions);
	}

	public $helpers = ['Form' => ['className' => 'BootstrapUI.Form']];

	public function calbox($fieldName, array $options = []) {
		$setValue = $this->Form->getSourceValue($fieldName);

		$modeOptions = [
			"data-datebox-mode"                 => "calbox",
			"data-datebox-linked-field-format"  => "%Y-%m-%d",
			"data-datebox-override-date-format" => "%B %-d, %Y"
		];

		if ( !is_null($setValue) ) {
			$hidden_value         = $setValue->format('Y-m-d');
			$modeOptions["value"] = $setValue->format('F j, Y');
		} else {
			$hidden_value         = date('Y-m-d');
			$modeOptions["value"] = date('F j, Y');
		}
		
		$options = $this->_doOptions($fieldName, $options, $modeOptions);

		return $this->Form->input($fieldName, $options) . $this->Form->hidden($fieldName, ["id" => $fieldName, "value" => $hidden_value]);
	}

	public function datebox($fieldName, array $options = []) {
		$setValue = $this->Form->getSourceValue($fieldName);

		$modeOptions = [
			"data-datebox-mode"                 => "datebox",
			"data-datebox-linked-field-format"  => "%Y-%m-%d",
			"data-datebox-override-date-format" => "%B %-d, %Y"
		];

		if ( !is_null($setValue) ) {
			$hidden_value         = $setValue->format('Y-m-d');
			$modeOptions["value"] = $setValue->format('F j, Y');
		} else {
			$hidden_value         = date('Y-m-d');
			$modeOptions["value"] = date('F j, Y');
		}
		
		$options = $this->_doOptions($fieldName, $options, $modeOptions);

		return $this->Form->input($fieldName, $options) . $this->Form->hidden($fieldName, ["id" => $fieldName, "value" => $hidden_value]);
	}

	public function timebox($fieldName, array $options = []) {
		$setValue = $this->Form->getSourceValue($fieldName);

		$modeOptions = [
			"data-datebox-mode"                 => "timebox",
			"data-datebox-linked-field-format"  => "%H:%M",
			"data-datebox-override-time-format" => 12,
			"data-datebox-override-time-output" => "%-I:%M %p",
			"data-datebox-minute-step"          => 15,
			"data-datebox-theme_close-btn"      => '["check","primary"]'
		];

		if ( !is_null($setValue) ) { 
			if ( gettype($setValue) == "string" ) {
				$time = Time::createFromFormat('H:i:s',$setValue);
			} else {
				$time = $setValue;
			}
			$hidden_value         = $time->i18nFormat('H:mm', 'UTC');
			$modeOptions["value"] = $time->i18nFormat('h:mm a', 'UTC');
		}
		
		$options = $this->_doOptions($fieldName, $options, $modeOptions);

		return $this->Form->input($fieldName, $options) . $this->Form->hidden($fieldName, ["id" => $fieldName, "value" => $hidden_value]);
	}
}
?>
