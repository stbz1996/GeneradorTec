<?php
  $button = array(
    'name' => 'submitButton',
    'value' => 'Submit'
  );
  $optionsWorkload = array(25, 50, 75, 100);
  $linkWorkload = base_url()."Form_controller/getDataFromView";
?>

<!--<a href="<?= $linkWorkload ?>"> <i class="fa fa-calendar"></i> <span>Generar Links</span> </a>-->
<!-- multistep form -->
<form id="msform" action="getDataFromView" method="post">

  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active">Información</li>
    <li> Carga </li>
    <li> Actividades </li>
    <li> Cursos </li>
    <li> Horarios </li>
    <li> Enviar </li>
  </ul>
  


  <fieldset>
    <h2 class="fs-title">Información</h2>
    <h3 class="fs-subtitle">El formulario debe ser enviado antes del <?= $dueDate ?></h3>
    <div class="infoTagBox">
      <div class="infoTag">
        <?= $professorFirstName?> <?= $professorLastName ?>
      </div>
      <div class="infoTag">
        <?= $careerName ?>
      </div>
      <div class="infoTag">
        <?= $periodNumber ?> Semestre, <?= $periodYear ?>
      </div>
      <div class="infoTag">
        Vence el <?= $dueDate ?>
      </div>

    </div>
    <input type="button" name="next" class="next action-button" value="Siguiente" />   
  </fieldset>
  

  <fieldset>
    <h2 class="fs-title">Carga</h2>
    <h3 class="fs-subtitle"> 
      Seleccione la carga de trabajo para el semestre <?= $periodNumber?> del <?= $periodYear ?>, la cual influirá en el mínimo de cursos posibles a asignar en este periodo.
    </h3>
    <div>
      <select id="workload_options" name="workload_options" class="comboBoxCarga">
        <!--<option value="25">25% (1 curso)</option>
        <option value="50">50% (2 cursos)</option>
        <option value="75">75% (3 cursos)</option>
        <option value="100">100% (4 cursos)</option>-->
        <?php 
        for($i = 0; $i < count($optionsWorkload); $i++){
          $option = $optionsWorkload[$i];
        ?>
          <option <?= $workload == $option ? 'selected="selected"' : '' ?> value="<?= $optionsWorkload[$i]?>"><?= $option ?>%</option>
        <?php }?>
      </select>
    </div>
    <input type="button" name="previous" class="previous action-button" value="Anterior"/>
    <input id="saveDataButton" type="button" name="Submit" class="submit submit-save action-button" value="Guardar">
    <input type="button" name="next" id="next-workload" class="next action-button" value="Siguiente" />
    <!--<input type='submit' name='submit' class="submit action-button" value='Submit' />-->
  </fieldset>


  <fieldset>
    <h2 class="fs-title">Actividades</h2>
    <h3 class="fs-subtitle"> 
      Ingrese las actividades que considera le reducen la carga de trabajo, por lo que afectará la carga que brindó en la sección anterior. 
    </h3>
    <div>
      <input type="button" name="add" id="add" class="btn_add action-button" value="Agregar Actividad" /></input>
      <div>
        <table id="dynamic_field" name="dynamic_field" class="dynamic_table">
        <?php 
        $totalActivities = count($activities);
        for($i = 0; $i < $totalActivities; $i++) {
          $description = $activities[$i]->getDescription();
          $workPorcent = $activities[$i]->getWorkPorcent();
        ?>
          <tr id="row<?= $i+1?>">
            <td>
              <input type="text" name="activityDescription[]" maxlength="100" id="descriptionActivity" placeholder="Ingrese actividad" value="<?= $description?>" />
            </td>
            <td>
              <input type="number" name="workPorcent[]" min="0" max="100" value="<?= $workPorcent?>" class="textnum">
            </td>
            <td>
              <input type="button" name="remove" id="<?=$i+1?>" class="btn_remove action-button" value="Eliminar" />
            </td>

          </tr>
        <?php }?>
        </table>
      
      <!--<input type="number" id="activity_porcent" min="0" value="0" class="textnum">-->
      </div>
    </div>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input id="saveDataButton" type="button" name="Submit" class="submit submit-save action-button" value="Guardar">
    <input type="button" id="next-activity" name="next" class="next action-button" value="Siguiente" />
  </fieldset>


  <fieldset>
    <h2 class="fs-title">Cursos</h2>
    <h3 class="fs-subtitle">
      Seleccione los cursos que quiere impartir, debe seleccionar un mínimo de cursos en relación a la carga de trabajo
    </h3>
    <div class="listOfcourses">
      <?php 
      $countPlans = count($plans);
      $totalCourses = 1;
      for($i = 0; $i < $countPlans; $i++) { ?>
          <div class="coursesPlan"> Plan <?= $plans[$i]->getName() ?></div>
          <div class="tablecourses">
            <?php 
            $countCourses = count($courses[$i]);
            for($j = 0; $j < $countCourses; $j++) {
              $nameRow = 'row-'.$totalCourses;
              $divCode = 'div-code-'.$totalCourses;
              $divName = 'div-name-'.$totalCourses;
              $nameSelect = 'select-'.$totalCourses;
              $nameCheckBox = 'cbox-'.$totalCourses;
              $nameIdCourse = 'course-'.$totalCourses;
              $idCourse = $courses[$i][$j]->getId(); ?>
              <div class="tablerow" id=<?=$nameRow ?> >
                <div><input type="hidden" id=<?= $nameIdCourse ?> value=<?=$idCourse?> /></div>
                <div class="tableColumCode" id=<?= $divCode ?>><?= $courses[$i][$j]->getCode() ?> </div>
                <div class="tableColumName" id=<?= $divName ?>><?= $courses[$i][$j]->getName() ?> </div>
                <div class="tableColumPriority">
                  <select id=<?=$nameSelect ?> <?= in_array($idCourse, $idCourses) ? 'disabled' : '' ?>>
                    <?php 
                    if(in_array($idCourse, $idCourses))
                    {
                    ?>
                      <option <?= $priorities[array_search($idCourse, $idCourses)] == 'A' ? 'selected="selected"' : '' ?> value="A">A</option>
                      <option <?= $priorities[array_search($idCourse, $idCourses)] == 'B' ? 'selected="selected"' : '' ?> value="B">B</option>
                      <option <?= $priorities[array_search($idCourse, $idCourses)] == 'C' ? 'selected="selected"' : '' ?> value="C">C</option>
                    <?php }
                    else
                    {
                    ?>
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                    <?php
                    }
                    ?>
                  </select>
                </div>

                <div class="tableColumCheck">
                  <label class="container">
                    <input type="checkbox" class="cbox" id=<?= $nameCheckBox ?> value="first_checkbox" <?= in_array($idCourse, $idCourses) ? 'checked' : '' ?> />
                    <span class="checkmark"></span>
                  </label>
                </div>

                <?php 
                if(in_array($idCourse, $idCourses)) {?>
                <div id="id-<?= $totalCourses ?>">
                  <input type="hidden" id="idCourse-<?= $totalCourses ?>" name="idCourses[]" value=<?= $idCourse?> />
                </div>
                <div id="priority-<?= $totalCourses ?>">
                  <input type="hidden" id="prior-<?= $totalCourses ?>" name="priorities[]" value=<?= $priorities[array_search($idCourse,$idCourses)]?> />
                </div>
                <?php } ?>

              </div>
            <?php 
              $totalCourses++;
            }?>
          </div>
      <?php }?>     
    </div>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input id="saveDataButton" type="button" name="Submit" class="submit submit-save action-button" value="Guardar">
    <input type="button" name="next" id="next-courses" class="next action-button" value="Siguiente" />
  </fieldset>


  <fieldset>
    <h2 class="fs-title">Horarios</h2>
    <h3 class="fs-subtitle">Seleccione los posibles horarios para impartir los cursos que seleccionó anteriormente</h3>
    <div>
      <div class="mainContainer">
        <div class="fileone">
          <div class="itemf1"> Hora </div>
          <div class="itemf1"> Lunes </div>
          <div class="itemf1"> Martes </div>
          <div class="itemf1"> Miercoles </div>
          <div class="itemf1"> Jueves </div>
          <div class="itemf1"> Viernes </div>
          <div class="itemf1"> Sabado </div>
        </div>

        <?php 
        for ($i=1; $i < 15; $i++) { ?>
          <div class="fileone">
          <!-- It is the hour -->
          <div class="itemCol1"> <?= $hours[$i] ?> </div>
          <?php 
          for ($k=1; $k < 7; $k++) { ?>
            <!-- It is a normal space in schedule -->
            <?php 
              $baseId = $days[$i][$k]['id'];
              $baseState = $days[$i][$k]['state'];
              $Did = 'Div-'.$baseId;
              $Mid = 'Inp-'.$baseId;
            ?>
            <div id="<?= $Did ?>" <?php if($baseState) {?>
              onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" <?php }?> 
            class="item">.
              <input class="hiddenItem" id="<?= $Mid ?>" value="<?= $baseState ?>" type="hidden" name="<?= $Mid ?>">
              <input type="hidden" id="day-<?= $baseId ?>" value="<?=$days[$i][$k]['day']?>">
              <input type="hidden" id="initialTime-<?= $baseId ?>" value="<?=$days[$i][$k]['initialTime']?>">
              <input type="hidden" id="finalTime-<?= $baseId ?>" value="<?=$days[$i][$k]['finishTime']?>">
            </div>
          <?php } ?>            
          </div>
        <?php } ?>
        <?php
        if($formSchedules){
          foreach($formSchedules as $schedule){?>
            <input type="hidden" name="oldSchedules[]" value="<?=$schedule?>">
          <?php }
        }?>

      </div>
    </div>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input id="saveDataButton" type="button" name="Submit" class="submit submit-save action-button" value="Guardar">
    <input type="button" name="next" id="next-schedules" class="next action-button" value="Siguiente" />
  </fieldset>
  



  <fieldset>
    <div id="content">
      <div id="div-information">
        <div class="showFormtxt">Información del formulario</div>
        <div class="showInfo"><?= $professorFirstName?> <?= $professorLastName ?></div>
        <div class="showInfo"><?= $careerName ?></div>
        <div class="showInfo">Periodo del <?= $periodNumber ?> Semestre, <?= $periodYear ?></div>
      </div>
      <div class="showInfo" id="div-workload"></div>
      <div class="showInfo" id="div-activities"></div>
      <div class="showInfo" id="div-courses"></div>
      <div class="showInfo" id="div-schedules"></div>
    </div>
    <div id="editor"></div>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="submit" name="submit" class="submit submit-save action-button" value="Enviar" />
  </fieldset>

</form>

<div id="loader"></div>