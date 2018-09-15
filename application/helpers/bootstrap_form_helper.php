<?php
if(!function_exists("frm_input")){
	function frm_input($type, $name, $label,$auto_complete = 'nope', $isrequired=FALSE){
		$require = '';
		if($isrequired){
			$require = '<span style="color:red;">*</span>';
		}
		$return = '
			<label for="'.$name.'" class="form-control-label col-md-6">'.$label.' '.$require.'</label>
			<div class="col-md-6">
				<input type="'.$type.'" name="'.$name.'" id="'.$name.'" class="form-control" autocomplete="'.$auto_complete.'" />
				<div id="message_'.$name.'"></div>
			</div>';
		return $return;
	}
}

