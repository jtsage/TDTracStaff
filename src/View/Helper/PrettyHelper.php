<?php
/* src/View/Helper/PrettyHelper.php (using other helpers) */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Chronos\Chronos;

class PrettyHelper extends Helper
{
	public function phone($value)
	{
		if ( $value  < 100000000 ) { return "n/a"; }
		return substr($value, 0, 3) . "." . substr($value, 3, 3) . "." . substr($value, 6, 4);
	}
	public function makeIcon($name, $icon, $text) {
		return "<span class='sr-only'>{$text}: {$name}</span><i class='fa fa-lg fa-fw fa-{$icon}' data-toggle='tooltip' data-placement='top' title='' data-original-title='{$text}: {$name}'></i></span>";
	}
	public function iconSNeed($name)
	{
		return PrettyHelper::makeIcon($name, 'user-plus', __('Needed'));
	}
	public function iconMail($name)
	{
		return PrettyHelper::makeIcon($name, 'envelope', __('E-Mail'));
	}
	public function iconSAssign($name)
	{
		return PrettyHelper::makeIcon($name, 'users', __('Assigned'));
	}
	public function iconEdit($name)
	{
		return PrettyHelper::makeIcon($name, 'pencil-square-o', __('Edit'));
	}
	public function iconTUp($name)
	{
		return PrettyHelper::makeIcon($name, 'thumbs-up', __('Yup'));
	}
	public function iconTDown($name)
	{
		return PrettyHelper::makeIcon($name, 'thumbs-down', __('No'));
	}
	public function iconSave($name)
	{
		return PrettyHelper::makeIcon($name, 'save', __('Edit'));
	}
	public function iconMark($name)
	{
		return PrettyHelper::makeIcon($name, 'check', __('Mark Paid'));
	}
	public function iconPrint($name)
	{
		return PrettyHelper::makeIcon($name, 'print', __('Print'));
	}
	public function iconLock($name)
	{
		return PrettyHelper::makeIcon($name, 'lock', __('Change Password'));
	}
	public function iconView($name)
	{
		return PrettyHelper::makeIcon($name, 'eye', __('View'));
	}
	public function iconDelete($name)
	{
		return PrettyHelper::makeIcon($name, 'trash', __('Delete'));
	}
	public function iconAdd($name)
	{
		return PrettyHelper::makeIcon($name, 'plus', __('Add'));
	}
	public function iconCopy($name)
	{
		return PrettyHelper::makeIcon($name, 'copy', __('Copy'));
	}
	public function iconPerm($name)
	{
		return PrettyHelper::makeIcon($name, 'cogs', __('User Permissions'));
	}
	public function iconDL($name)
	{
		return PrettyHelper::makeIcon($name, 'cloud-download', __('Download'));
	}
	public function iconUnpaid($name)
	{
		return PrettyHelper::makeIcon($name, 'usd', __('View Unpaid'));
	}
	public function iconPower($name)
	{
		return PrettyHelper::makeIcon($name, 'power-off', __('Login'));
	}
	public function iconNext($name)
	{
		return PrettyHelper::makeIcon($name, 'forward', __('Next'));
	}
	public function iconPrev($name)
	{
		return PrettyHelper::makeIcon($name, 'backward', __('Previous'));
	}
	public function helpButton($icon, $color = 'default', $name, $desc) {
		return '<a href="#" class="btn btn-' . $color . ' btn-sm"><i class="fa fa-fw fa-lg fa-' . $icon . '" aria-hidden="true"></i></a>' .
		' <strong>' . $name . '</strong>: ' . $desc;
	}
	public function jqButton($icon, $color = 'default', $id, $class="", $title="") {
		return '<a href="#" title="' . $title . '" class="btn btn-' . $color . ' ' . $class . ' btn-sm" id="' . $id . '"><i class="fa fa-fw fa-lg fa-' . $icon . '" aria-hidden="true"></i></a>';
	}

	public function money($name, $label, $value=null) {
		$returns  = '<div class="form-group required">';
		$returns .= '<label class="control-label" for="' . $name . '">' . $label . '</label>';
		$returns .= '<div class="input-group"><div class="input-group-prepend"><div class="input-group-text">$</div></div>';
		$returns .= '<input type="number" ' . ((!is_null($value)) ? "value='" . number_format($value,2,'.','') . "'" : "" ) . ' name="' . $name . '" required="required" step=".01" min="0" id="price" class="form-control">';
		$returns .= "</div></div>";
		return $returns;
	}

	public function clockPicker( $name, $label, $time=null ) {
		if ( !is_null($time) ) { 
			$time = Time::createFromFormat('H:i',$time,'UTC');
			$val = $time->i18nFormat('H:mm', 'UTC');
			$pretty_value = $time->i18nFormat('h:mm a', 'UTC');
		} else {
			$val = "";
			$pretty_value = "";
		}

		$returns  = '<div class="form-group required">';
		$returns .= '<label class="control-label">' . $label . '</label>';
		$returns .= '<input type="text" data-role="datebox" data-datebox-mode="timebox" id="' . $name . '-dbox" class="form-control" value="' . $pretty_value . '" data-options=\'{"linkedField": "#' . $name . '", "overrideTimeFormat": 12, "overrideTimeOutput": "%-I:%M %p", "linkedFieldFormat": "%H:%M", "minuteStep": 15 }\'>';
		$returns .= '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $val . '" /></div>';
		return $returns;
	}

	public function calPicker( $name, $label, $time=null ) {
		if ( !is_null($time) ) { 
			$val = $time->format('Y-m-d');
			$pretty_value = $time->format('F j, Y');
		} else {
			$val = date('Y-m-d');
			$pretty_value = date('F j, Y');
		}
		$returns  = '<div class="form-group required">';
		$returns .= '<label class="control-label">' . $label . '</label>';
		$returns .= '<input class="form-control" data-role="datebox" data-datebox-mode="calbox" type="text" id="'.$name.'-dbox" value="' . $pretty_value . '" data-options=\'{"linkedField": "#' . $name . '", "overrideDateFormat": "%B %-d, %Y", "linkedFieldFormat": "%Y-%m-%d" }\'>';
		$returns .= '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $val . '" /></div>';
		return $returns;
	}

	public function datePicker( $name, $label, $time=null ) {
		if ( !is_null($time) ) { 
			$val = $time->i18nFormat('YYYY-MM-dd');
			$pretty_value = $time->i18nFormat('MMMM d, YYYY');
		} else {
			$val = date('Y-m-d');
			$pretty_value = date('F j, Y');
		}

		$returns  = '<div class="form-group required">';
		$returns .= '<label class="control-label">' . $label . '</label>';
		$returns .= '<input class="form-control" data-role="datebox" data-datebox-mode="calbox" type="text" id="'.$name.'-dbox" value="' . $pretty_value . '" data-options=\'{"linkedField": "#' . $name . '", "overrideDateFormat": "%B %-d, %Y", "linkedFieldFormat": "%Y-%m-%d" }\'>';
		$returns .= '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $val . '" /></div>';
		return $returns;
	}

	public function checkVal($name, $value=0, $check=false, $other=null, $size="normal", $dis=false) {
		$returns  = '<div class="form-group text-center">';
		$returns .= '<input type="checkbox" name="' . $name . '" ';
		$returns .= 'class="bootcheck" data-animate="false" data-size="' . $size . '" ';
		$returns .= "value='" . $value . "' ";
		$returns .= ($check) ? "checked " : "";
		if ( is_array($other) ) {
			foreach ( $other as $key => $value ) {
				$returns .= "data-" . $key . '="' . $value . '" ';
			}
		}
		$returns .= ($dis ? " disabled" : "") . '></div>';
		return $returns;
	}
	
	public function check($name, $check=false, $other=null, $size="normal", $dis=false) {
		$returns  = '<div class="form-group">';
		$returns .= '<input type="hidden" name="' . $name . '" value="0">';
		$returns .= '<input type="checkbox" name="' . $name . '" ';
		$returns .= 'class="bootcheck" data-size="' . $size . '" ';
		$returns .= "value='1' ";
		$returns .= ($check) ? "checked " : "";
		if ( is_array($other) ) {
			foreach ( $other as $key => $value ) {
				$returns .= "data-" . $key . '="' . $value . '" ';
			}
		}
		$returns .= ($dis ? " disabled" : "") . '></div>';
		return $returns;
	}

}
?>
