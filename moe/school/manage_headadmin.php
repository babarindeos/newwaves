<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_message
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 // Get School Id
 if (!isset($_GET['q']) || $_GET['q']==''){
        redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
 }

  $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_school_id = $_GET_URL_school_id[1];



 require_once(__DIR__.'/../../../../config.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');

 global $DB;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/schoolinfo.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('School Information');

 echo $OUTPUT->header();
 echo "<h2>School Information</h2>";


 // nav bar
 include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');


 // retrieve school information from DB
 $sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
 $school =  $DB->get_records_sql($sql);

 foreach($school as $row){
    $school_name = $row->name;
    $school_type = schoolTypes($row->type);
    $lga = $row->lga;
    $address = $row->address;
    echo "<h4>{$school_name}</h4>";
    echo "<div>{$address}, {$lga}</div>";
 }


 ?>

 <hr/>
 <!-- Navigation //-->
 <?php
    include_once($CFG->dirroot.'/local/newwaves/nav/moe_school_nav.php');
 ?>
 <!-- end of navigation //-->

 <div class="row d-flex justify-content-right mt-2">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php
           $create_head_href = "create_school_head.php?q=".mask($_GET_URL_school_id);
        ?>
        <button onClick="window.location='<?php echo $create_head_href; ?>'" class='btn btn-sm btn-primary rounded'>Create School Head</button>
    </div>
 </div>





 <?php
  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
?>
