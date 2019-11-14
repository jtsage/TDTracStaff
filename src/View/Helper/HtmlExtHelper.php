<?php
/* src/View/Helper/PrettyHelper.php (using other helpers) */

namespace App\View\Helper;

use Cake\View\Helper;
// use Cake\I18n\Time;
// use Cake\Core\Configure;
// use Cake\Chronos\Chronos;

class HtmlExtHelper extends Helper
{
	public $helpers = ['Html'];

	/* Make an icon, title optional */
	public function icon($icon, $title = null) {
		if ( is_null($title) ) {
			return "<i class=\"mdi mdi-{$icon}\" aria-hidden=\"true\"></i>";
		} else {
			return "<i class=\"mdi mdi-{$icon}\" title=\"{$title}\" aria-hidden=\"true\"></i>";
		}
	}

	public function gravatar($username, $size = 80) {
		return "<img class=\"rounded-circle border border-dark\" src=\"https://www.gravatar.com/avatar/" . md5( strtolower( trim( $username ) ) ) . "?s=" . $size . "\">";
	}

	public function iconBtnLink($icon, $text, $link, $options = []) {
		$defOpt = [ 'escape' => false, 'class' => 'btn btn-primary' ];

		$options = array_merge($defOpt, $options);

		return $this->Html->link(
			HtmlExtHelper::icon($icon) . "&nbsp;" . $text,
			$link,
			$options
		);
	}

	public function badgePair($values) {
		return "<span class=\"w-100 badge badge-{$values[0]}\">{$values[1]}</span>";
	}
	public function badgePaid($value) {
		return HtmlExtHelper::badgePair([
			[ "warning", "NO" ],
			[ "success", "yes"],
		][($value)]);
	}
	public function badgePass($value) {
		return HtmlExtHelper::badgePair([
			[ "success", "Valid"],
			[ "warning", "Expired" ]
		][($value)]);
	}

	public function badgeActive($value) {
		return HtmlExtHelper::badgePair([
			[ "danger", "Inactive"],
			[ "success", "Active" ]
		][($value)]);
	}

	public function badgeAdmin($value) {
		return HtmlExtHelper::badgePair([
			[ "success", "Regular"],
			[ "warning", "Admin" ]
		][($value)]);
	}
	public function hyphenNBR($text) {
		return preg_replace("/-/", "&#8209;", $text);
	}
	


	// public function money($name, $label, $value=null) {
	// 	$returns  = '<div class="form-group required">';
	// 	$returns .= '<label class="control-label" for="' . $name . '">' . $label . '</label>';
	// 	$returns .= '<div class="input-group"><div class="input-group-prepend"><div class="input-group-text">$</div></div>';
	// 	$returns .= '<input type="number" ' . ((!is_null($value)) ? "value='" . number_format($value,2,'.','') . "'" : "" ) . ' name="' . $name . '" required="required" step=".01" min="0" id="price" class="form-control">';
	// 	$returns .= "</div></div>";
	// 	return $returns;
	// }

	// public function clockPicker( $name, $label, $time=null ) {
	// 	if ( !is_null($time) ) { 
	// 		$time = Time::createFromFormat('H:i',$time,'UTC');
	// 		$val = $time->i18nFormat('H:mm', 'UTC');
	// 		$pretty_value = $time->i18nFormat('h:mm a', 'UTC');
	// 	} else {
	// 		$val = "";
	// 		$pretty_value = "";
	// 	}

	// 	$returns  = '<div class="form-group required">';
	// 	$returns .= '<label class="control-label">' . $label . '</label>';
	// 	$returns .= '<input type="text" data-role="datebox" data-datebox-mode="timebox" id="' . $name . '-dbox" class="form-control" value="' . $pretty_value . '" data-options=\'{"linkedField": "#' . $name . '", "overrideTimeFormat": 12, "overrideTimeOutput": "%-I:%M %p", "linkedFieldFormat": "%H:%M", "minuteStep": 15 }\'>';
	// 	$returns .= '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $val . '" /></div>';
	// 	return $returns;
	// }

	// public function calPicker( $name, $label, $time=null ) {
	// 	if ( !is_null($time) ) { 
	// 		$val = $time->format('Y-m-d');
	// 		$pretty_value = $time->format('F j, Y');
	// 	} else {
	// 		$val = date('Y-m-d');
	// 		$pretty_value = date('F j, Y');
	// 	}
	// 	$returns  = '<div class="form-group required">';
	// 	$returns .= '<label class="control-label">' . $label . '</label>';
	// 	$returns .= '<input class="form-control" data-role="datebox" data-datebox-mode="calbox" type="text" id="'.$name.'-dbox" value="' . $pretty_value . '" data-options=\'{"linkedField": "#' . $name . '", "overrideDateFormat": "%B %-d, %Y", "linkedFieldFormat": "%Y-%m-%d" }\'>';
	// 	$returns .= '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $val . '" /></div>';
	// 	return $returns;
	// }

	// public function datePicker( $name, $label, $time=null ) {
	// 	if ( !is_null($time) ) { 
	// 		$val = $time->i18nFormat('YYYY-MM-dd');
	// 		$pretty_value = $time->i18nFormat('MMMM d, YYYY');
	// 	} else {
	// 		$val = date('Y-m-d');
	// 		$pretty_value = date('F j, Y');
	// 	}

	// 	$returns  = '<div class="form-group required">';
	// 	$returns .= '<label class="control-label">' . $label . '</label>';
	// 	$returns .= '<input class="form-control" data-role="datebox" data-datebox-mode="calbox" type="text" id="'.$name.'-dbox" value="' . $pretty_value . '" data-options=\'{"linkedField": "#' . $name . '", "overrideDateFormat": "%B %-d, %Y", "linkedFieldFormat": "%Y-%m-%d" }\'>';
	// 	$returns .= '<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $val . '" /></div>';
	// 	return $returns;
	// }

	// public function checkVal($name, $value=0, $check=false, $other=null, $size="normal", $dis=false) {
	// 	$returns  = '<div class="form-group text-center">';
	// 	$returns .= '<input type="checkbox" name="' . $name . '" ';
	// 	$returns .= 'class="bootcheck" data-animate="false" data-size="' . $size . '" ';
	// 	$returns .= "value='" . $value . "' ";
	// 	$returns .= ($check) ? "checked " : "";
	// 	if ( is_array($other) ) {
	// 		foreach ( $other as $key => $value ) {
	// 			$returns .= "data-" . $key . '="' . $value . '" ';
	// 		}
	// 	}
	// 	$returns .= ($dis ? " disabled" : "") . '></div>';
	// 	return $returns;
	// }
	
	// public function check($name, $check=false, $other=null, $size="normal", $dis=false) {
	// 	$returns  = '<div class="form-group">';
	// 	$returns .= '<input type="hidden" name="' . $name . '" value="0">';
	// 	$returns .= '<input type="checkbox" name="' . $name . '" ';
	// 	$returns .= 'class="bootcheck" data-size="' . $size . '" ';
	// 	$returns .= "value='1' ";
	// 	$returns .= ($check) ? "checked " : "";
	// 	if ( is_array($other) ) {
	// 		foreach ( $other as $key => $value ) {
	// 			$returns .= "data-" . $key . '="' . $value . '" ';
	// 		}
	// 	}
	// 	$returns .= ($dis ? " disabled" : "") . '></div>';
	// 	return $returns;
	// }

	// public function joinAnd($values) {
	// 	if ( empty($values) ) { return "<em><small>none</small></em>"; }
	// 	if ( count($values) == 1 ) {
	// 		return $values[0];
	// 	}
	// 	if ( count($values) == 2 ) {
	// 		return $values[0] . " and " . $values[1];
	// 	}
	// 	$last_value = array_pop($values);
	// 	return join(", ", $values) . ", and " . $last_value;
	// }

	// public function helpMeStart($title = "") {
	// 	$returns  = '<div class="modal fade" id="helpMeModal" tabindex="-1" role="dialog" aria-labelledby="helpMeLabel" aria-hidden="true">';
	// 	$returns .= '<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">';
	// 	$returns .= '<div class="modal-content">';
	// 	$returns .= '<div class="modal-header p-2">';
	// 	$returns .= '<h5 class="modal-title" id="helpMeLabel">Help Information: ' . $title . "</h5>";
	// 	$returns .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	// 	return $returns . '</div><div class="modal-body">';
	// }
	// public function helpMeEnd() {
	// 	return '</div></div></div></div>';
	// }
	// public function helpMeFld($name, $description) {
	// 	return "<dl class=\"m-0\"><dt>" . $name . "</dt><dd class=\"m-0 ml-3\">" . $description . "</dd></dl>\n";
	// }

}
?>
