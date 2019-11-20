<?php
/* src/View/Helper/PrettyHelper.php (using other helpers) */

namespace App\View\Helper;

use Cake\View\Helper;

class PrettyHelper extends Helper
{
	public function highToday($in_date, $CONFIG) {
		$today = new \DateTime("now", new \DateTimeZone($CONFIG['time-zone']) );
		if ( $today->format("Y-m-d") == $in_date->format("Y-m-d") ) {
			return "text-primary text-italic";
		} else {
			return "";
		}
	}
	public function joinAnd($values) {
		if ( empty($values) ) { return "<em><small>none</small></em>"; }
		if ( count($values) == 1 ) {
			return $values[0];
		}
		if ( count($values) == 2 ) {
			return $values[0] . " and " . $values[1];
		}
		$last_value = array_pop($values);
		return join(", ", $values) . ", and " . $last_value;
	}

	public function helpMeStart($title = "") {
		$returns  = '<div class="modal fade" id="helpMeModal" tabindex="-1" role="dialog" aria-labelledby="helpMeLabel" aria-hidden="true">';
		$returns .= '<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">';
		$returns .= '<div class="modal-content">';
		$returns .= '<div class="modal-header p-2">';
		$returns .= '<h5 class="modal-title" id="helpMeLabel">Help Information: ' . $title . "</h5>";
		$returns .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		return $returns . '</div><div class="modal-body">';
	}
	public function helpMeEnd() {
		return '</div></div></div></div>';
	}
	public function helpMeFld($name, $description) {
		return "<dl class=\"m-0\"><dt>" . $name . "</dt><dd class=\"m-0 ml-3\">" . $description . "</dd></dl>\n";
	}

}
?>
