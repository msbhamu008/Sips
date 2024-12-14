    <form id="form1" class="spaceb60 spacet40" action="<?php echo current_url() ?>" id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">


       <h3 class="entered pb20"> <?php echo $this->lang->line('exam_result'); ?></h3>
       <div class="row">
          <div class="col-lg-6 col-md-5 col-sm-6">
             <div class="form-group">
                <label for="email"><?php echo $this->lang->line('exam'); ?><small class="req"> *</small> </label>

                <select class="form-control" name="exam_id">
                   <option value=""><?php echo $this->lang->line('select'); ?></option>
                   <?php
                     foreach ($exams as $exam_key => $exam_value) {
                     ?>
                      <option value="<?php echo $exam_value['id']; ?>" <?php echo set_select('exam_id', $exam_value['id'], set_value('exam_id')); ?>><?php echo $exam_value['name']; ?></option>
                   <?php
                     }
                     ?>
                </select>
                <span class="text-danger">
                   <?php echo form_error('exam_id'); ?>
                </span>
             </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-3">
             <div class="form-group">
                <label for="email"><?php echo $this->lang->line('admission_no'); ?><small class="req"> *</small> </label>
                <input type="text" class="form-control" name="roll_no" value="<?php echo set_value('roll_no'); ?>" />
                <span class="text-danger">
                   <?php echo form_error('roll_no'); ?>
                </span>
             </div>
          </div>
          <div class="col-lg-2 col-md-3 col-sm-3">

             <button type="submit" class="onlineformbtn search-top-space"><?php echo $this->lang->line('search'); ?></button>

          </div>
       </div>

    </form>

    <div class="spaceb60 table-responsive">
       <?php
         if (isset($student_result)) {
            if (!empty($student_result)) {
         ?>

             <button type="button" class="btn btn-default btn-xs mb10 pull-right" title="<?php echo $this->lang->line('print'); ?>" onclick="printDiv('div_print')"><i class="fa fa-print"></i></button>
             <div class="clearfix">

             </div>

             <div class="" id="div_print">
                <h4 class="text text-center"><?php echo $exam->name; ?> </h4>
                <div class="row mb10"></div>

                <div class="row mb10">
                   <div class="col-md-3">
                      <b><?php echo $this->lang->line('student_name'); ?> : </b>
                      <?php echo $student['firstname'] . " " . $student['middlename'] . " " . $student['lastname']; ?>
                   </div>
                   <div class="col-md-3">
                      <b><?php echo $this->lang->line('roll_no'); ?> : </b>
                      <?php echo $student['roll_no']; ?>
                   </div>
                   <div class="col-md-3">
                      <b><?php echo $this->lang->line('class'); ?> : </b>
                      <?php echo $student['class'] . " (" . $student['section'] . ")";  ?>
                   </div>
                   <div class="col-md-3">
                      <b><?php echo $this->lang->line('admission_no'); ?> : </b>
                      <?php echo $student['admission_no']; ?>
                   </div>
                </div>
                <div class="row mb10"></div>


                <table class="table table-hover table-bordered">
                   <thead class="bggray">

                      <tr>
                         <th class="valign-top">
                            <?php echo $this->lang->line('subject'); ?>
                         </th>
                         <?php

                           foreach ($exam_assessments as $subject_assesment_key => $subject_assesment_value) {

                           ?>
                            <th class="text-center valign-top">
                               <?php
                                 $subject_assesment_code = ($subject_assesment_value->code != "") ? " (" . $subject_assesment_value->code . ")" : "";
                                
                                echo $subject_assesment_value->name . $subject_assesment_code;
                                 echo "<br/>";

                                 echo  "(" . $this->lang->line('max_marks') . ' ' . $subject_assesment_value->maximum_marks . ")";

                                 ?>
                            </th>
                         <?php
                           }

                           ?>


                         <th class="text-center valign-top">
                            <?php echo $this->lang->line('total'); ?>
                         </th>
                         <th class="text-center valign-top">
                            <?php echo $this->lang->line('grade'); ?>
                         </th>

                      </tr>
                   </thead>
                   <tbody>
                      <?php
                        $total_marks = 0;
                        $total_max_marks = 0;
                        foreach ($subjects as $subject_key => $subject_value) {
                           $subject_total = 0;
                           $subject_max_total = 0;
                        ?>
                         <tr>
                            <td>
                               <?php 
                                $subjectcode = ($subject_value->subject_code != "") ? " (" . $subject_value->subject_code . ")" : "";
                                
                                echo $subject_value->subject_name . $subjectcode; ?>
                            </td>

                            <?php

                              foreach ($exam_assessments as $subject_assessment_key => $subject_assessment_value) {
                              ?>
                               <td class="text-center">
                                  <?php

                                    $assessment_exists =  find_subject_assessment_exists($subject_assessments, $subject_value->id, $subject_assessment_value->id);



                                    if ($assessment_exists) {
                                       $assessment_array = findAssessmentValue($subject_value->subject_id, $subject_assessment_value->id, $student_result);
                                       echo ($assessment_array['is_absent']) ? $this->lang->line('abs') : $assessment_array['marks'];
                                       if ($assessment_array['marks'] == "N/A") {
                                          $assessment_array['marks'] = 0;
                                       }
                                       $total_max_marks += $assessment_array['maximum_marks'];
                                       $subject_max_total += $assessment_array['maximum_marks'];
                                       $total_marks += $assessment_array['marks'];
                                       $subject_total += $assessment_array['marks'];
                                    } else {
                                       echo "<b>xx</b>";
                                    }




                                    ?>
                               </td>
                            <?php
                              }

                              ?>
                            <td valign="top" class="text-center">
                               <?php echo $subject_total; ?>
                            </td>
                            <td valign="top" class="text-center">
                               <?php
                                 $subject_percentage = getPercent($subject_max_total, $subject_total);
                                 echo getGrade($exam, $subject_percentage);

                                 ?>

                            </td>
                         </tr>
                      <?php
                        }

                        ?>
                   </tbody>
                </table>


                <table class="table table-hover table-bordered bggray">
                   <tbody>
                      <tr>
                         <td class="fontbold">
                            <?php echo $this->lang->line('overall_marks'); ?> :
                            <?php echo two_digit_float($total_marks, 2) . "/" . $total_max_marks ?>
                         </td>
                         <td class="fontbold">
                            <?php echo $this->lang->line('percentage'); ?> :
                            <?php
                              $exam_percentage = getPercent($total_max_marks, $total_marks);
                              echo two_digit_float($exam_percentage, 2) . "%";
                              ?>
                         </td>
                         <td class="fontbold">
                            <?php echo $this->lang->line('grade'); ?> :
                            <?php echo getGrade($exam, $exam_percentage) ?>
                         </td>
                         <td class="fontbold">
                            <?php echo $this->lang->line('rank'); ?> :
                            <?php echo $student_result['rank']; ?>
                         </td>


                      </tr>
                   </tbody>
                </table>

             </div>
          <?php

            } else {
            ?>
             <div class="alert alert-danger">
                <?php echo $this->lang->line('no_record_found'); ?>
             </div>
       <?php
            }
         }

         ?>

    </div>





    <?php

      function find_subject_assessment_exists($subject_assessments, $cbse_exam_timetable_id, $cbse_exam_assessment_type_id)
      {

         if (!empty($subject_assessments)) {
            foreach ($subject_assessments as $key => $value) {
               if ($value->id == $cbse_exam_timetable_id) {
                  if (!empty($value->subject_assessments)) {
                     foreach ($value->subject_assessments as $askey => $asvalue) {
                        if ($asvalue->cbse_exam_timetable_id == $cbse_exam_timetable_id  && $asvalue->cbse_exam_assessment_type_id == $cbse_exam_assessment_type_id) {
                           return true;
                           break;
                        }
                     }
                  }
               }
            }
         }
         return false;
      }



      function findAssessmentValue($find_subject_id, $find_cbse_subject_assessment_type_id, $student_value)
      {

         $return_array = [
            'maximum_marks' => "",
            'marks' => "",
            'note' => "",
            'is_absent' => "",
         ];


         if (array_key_exists('subjects', $student_value)) {

            if (array_key_exists($find_subject_id, $student_value['subjects'])) {
               $result_array = ($student_value['subjects'][$find_subject_id]['exam_assessments'][$find_cbse_subject_assessment_type_id]);




               $return_array = [
                  'maximum_marks' => $result_array['maximum_marks'],
                  'marks' => is_null($result_array['marks']) ? "N/A" : $result_array['marks'],
                  'note' => $result_array['note'],
                  'is_absent' => $result_array['is_absent'],
               ];
            }
         }


         return $return_array;
      }

      function getGrade($grade_array, $Percentage)
      {

         if (!empty($grade_array->grades)) {
            foreach ($grade_array->grades as $grade_key => $grade_value) {

               if ($grade_value->minimum_percentage <= $Percentage) {
                  return $grade_value->name;
                  break;
               } elseif (($grade_value->minimum_percentage >= $Percentage && $grade_value->maximum_percentage <= $Percentage)) {

                  return $grade_value->name;
                  break;
               }
            }
         }
         return "-";
      }


      ?>

    <script type="text/javascript">
       function printDiv(tagid) {

          var hashid = "#" + tagid;
          var tagname = $(hashid).prop("tagName").toLowerCase();
          var attributes = "";
          var attrs = document.getElementById(tagid).attributes;
          $.each(attrs, function(i, elem) {
             attributes += " " + elem.name + " ='" + elem.value + "' ";
          })
          var divToPrint = $(hashid).html();
          var head = "<html><head>" + $("head").html() + "</head>";
          var allcontent = head + "<body  onload='window.print()' >" + "<" + tagname + attributes + ">" + divToPrint + "</" + tagname + ">" + "</body></html>";
          var newWin = window.open('', 'Print-Window');
          newWin.document.open();
          newWin.document.write(allcontent);
          newWin.document.close();

          setTimeout(function() {
             newWin.close();
          }, 10);

       }
    </script>