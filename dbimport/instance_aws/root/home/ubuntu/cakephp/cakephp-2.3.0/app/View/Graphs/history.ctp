<?php
// @company self
// @author Raymond Byczko
// @file history.ctp
// @purpose This is the history view which allows reviewing of a particular
// users upload history.
// @change_log 2013-03-09 Feb 09, RByczko, Started this file.
// Will add this to git and further refine.  Status is accurate.
// @status working
	// Debugger::dump($user_history);	
	echo '<table border>';
	echo '<tr>';
	echo '<th>id</th>';
	echo '<th>filename_xls</th>';
	echo '<th>filename_image</th>';
	echo '</tr>';
	foreach ($user_history as $history_entry)
	{
		echo '<tr>';
		echo '<td>';
		echo $history_entry['Graph']['id'];
		echo '</td>';
		echo '<td>';
		echo $history_entry['Graph']['filename_xls'];
		echo '</td>';
		echo '<td>';
		echo $history_entry['Graph']['filename_image'];
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
	echo $this->element('navigation');
?>
