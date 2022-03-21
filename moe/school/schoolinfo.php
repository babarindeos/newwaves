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


<div class="row mt-3"><!-- beginning of row //-->
<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 border"><!-- column 1 //-->
      Column 1
      <!--Load the AJAX API-->
          <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
          <script type="text/javascript">

            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages':['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            // Callback that creates and populates a data table,
            // instantiates the pie chart, passes in the data and
            // draws it.
            function drawChart() {

              // Create the data table.
              var data = new google.visualization.DataTable();
              data.addColumn('string', 'Topping');
              data.addColumn('number', 'Slices');
              data.addRows([
                ['Head Admin', <?php echo $_GET_URL_school_id;  ?>],
                ['School Admin', 1],
                ['Teachers', 1],
                ['Students', 1],

              ]);

              // Set chart options
              var options = {'title':'Users',
                             'width':600,
                             'height':400};

              // Instantiate and draw our chart, passing in some options.
              var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
              chart.draw(data, options);
            }
          </script>

      <div id="chart_div"></div>

</div><!-- end of column 1 //-->
<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
  Column 2


</div><!-- end of column 2 //-->
</div><!-- end of row //-->



<?php


require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
