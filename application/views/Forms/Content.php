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
    <li class="active" id="1"><div class="text-menu">Información</div></li>
    <li id="2"> <div class="text-menu">Carga</div> </li>
    <li id="3"> <div class="text-menu">Actividades</div> </li>
    <li id="4"> <div class="text-menu">Cursos</div> </li>
    <li id="5"> <div class="text-menu">Horarios</div> </li>
    <li id="6"> <div class="text-menu">Enviar</div> </li>
  </ul>
  
  <fieldset>
    <h2 class="fs-title">Información</h2>
    <h3 class="fs-subtitle">El formulario debe ser enviado antes del <?= $dueDate ?></h3>
    <div class="infoTagBox">
      <div id="nameProfessor" class="infoTag"><?= $professorFirstName?> <?= $professorLastName ?></div>
      <div id="nameCareer" class="infoTag">
        <?= $careerName ?>
      </div>
      <div id="namePeriod" class="infoTag"><?= $periodNumber ?> Semestre, <?= $periodYear ?></div>
      <div id="nameDueDate" class="infoTag">
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

    <div class="tableColumnCheckExtension" <?= $workload == 100 ? "style='display: block;'" : "style='display: none;'"  ?>>
      <p class="extension-txt">¿Ampliación?</p>
      
      <label class="container">
        <input type="checkbox" class="cbox_extension" id="cbox_extension" name="cbox_extension" value="first_checkbox" <?= $extension ? 'checked' : '' ?> />
        <span class="checkmark"></span>
      </label>

    </div>
    <input type="button" name="previous" class="previous action-button" value="Anterior"/>
    <input id="saveDataButton" type="button" name="Submit" class="submit submit-save action-button" value="Guardar">
    <input type="button" name="next" id="next-workload" class="next action-button" value="Siguiente" />
    <!--<input type='submit' name='submit' class="submit action-button" value='Submit' />-->
  </fieldset>


  <fieldset>
    <h2 class="fs-title">Actividades</h2>
    <h3 class="fs-subtitle"> 
      Estas actividades son extra a la docencia y afectan su carga de trabajo o bien son actividades que necesitan reconocimiento.
    </h3>
    <div>
      <input type="button" name="add" id="add" class="btn_add action-button" value="Agregar Actividad" /></input>
      <div>
        <table id="dynamic_field" name="dynamic_field" class="dynamic_table">
          <?php 
            $totalActivities = count($activities);?>
          <tr id="textActivities" <?= $totalActivities ? '' : 'hidden' ?>>
            <td>
              Descripción
            </td>
             <td>
              %
            </td>
          </tr>

        
        <?php
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
    <div class="showForm">
      <div class="listOfcourses">
        <?php 
            $countBlockCourses = 0;
            $totalCourses = 1;
            $countPlans = count($plans);    
            for($i = 0; $i < $countPlans; $i++) { ?>
                <div class="coursesPlan"> Plan <?= $plans[$i]->getName() ?></div>
                
                <?php
                $countBlocks = count($blocks[$i]);
                for($j = 0; $j < $countBlocks; $j++) { ?>
                  <div class="blockPlan"><?= $blocks[$i][$j]->getName() ?></div>
                  
                  <div class="tablecourses">
                    <?php 
                    $countCourses = count($courses[$countBlockCourses]);
                    for($k = 0; $k < $countCourses; $k++) { 
                      $nameRow = 'row-'.$totalCourses;
                      $divCode = 'div-code-'.$totalCourses;
                      $divName = 'div-name-'.$totalCourses;
                      $nameDivOptions = 'divOptions-'.$totalCourses;
                      $nameOption = 'option-'.$totalCourses;
                      $nameCheckBox = 'cbox-'.$totalCourses;
                      $nameIdCourse = 'course-'.$totalCourses;
                      $idCourse = $courses[$countBlockCourses][$k]->getId(); ?>

                      <div class="tablerow" id=<?=$nameRow ?> <?= in_array($idCourse, $idCourses) ? 'style="background:#27AE60; color: white;"' : ''?> >
                        <div><input type="hidden" id=<?= $nameIdCourse ?> value=<?=$idCourse?> /></div>

                        <div class="tableColumCheck">
                          <label class="container">
                            <input type="checkbox" class="cbox" id=<?= $nameCheckBox ?> value="first_checkbox" <?= in_array($idCourse, $idCourses) ? 'checked' : '' ?> />
                            <span class="checkmark"></span>
                          </label>
                        </div>
                        
                        <div class="tableColumCode" id=<?= $divCode ?>><?= $courses[$countBlockCourses][$k]->getCode() ?></div>
                        <div class="tableColumName" id=<?= $divName ?>><?= $courses[$countBlockCourses][$k]->getName() ?></div>
                        <div class="tableColumPriority" id="tableColumnPriority-<?=$totalCourses?>">

                            <?php if(in_array($idCourse, $idCourses)){ ?>
                              <div class="prioritiesOptions" id="<?=$nameDivOptions ?>" >
                                
                                <input type="radio" class="radio" id="<?= $nameOption?>-1" name="<?=$nameOption ?>" <?= $priorities[array_search($idCourse, $idCourses)] === 'A' ? 'checked' : '' ?> value="A">
                                <label for="<?= $nameOption?>-1" >A</label>

                                <input type="radio" class="radio" id="<?= $nameOption?>-2" name="<?=$nameOption ?>" <?= $priorities[array_search($idCourse, $idCourses)] === 'B' ? 'checked' : '' ?> value="B">
                                <label for="<?= $nameOption?>-2" >B</label>
                                
                                <input type="radio" class="radio" id="<?= $nameOption?>-3" name="<?=$nameOption ?>" <?= $priorities[array_search($idCourse, $idCourses)] === 'C' ? 'checked' : '' ?> value="C">
                                <label for="<?= $nameOption?>-3" >C</label>
                              
                              </div>
                            <?php }?>
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
                <?php 
                  $countBlockCourses++;
                }?>

        <?php }?>
      </div>
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
        $countSchedules = 0;
        for ($i=0; $i < 15; $i++) { ?>
          <div class="fileone">
          <!-- It is the hour -->
          <div class="itemCol1"> <?= $hours[$i] ?> </div>
          <?php 
          for ($k=1; $k < 7; $k++) { ?>
            <!-- It is a normal space in schedule -->
            <?php
              $idSchedule = $schedules[$countSchedules]['id'];
              $description = $schedules[$countSchedules]['description'];
              $baseId = $schedules[$countSchedules]['numberSchedule'];
              $baseState = $schedules[$countSchedules]['state'];
              $Did = 'Div-'.$baseId;
              $Mid = 'Inp-'.$baseId;
              $countSchedules++;
            ?>
            <div id="<?= $Did ?>" <?php if($baseState) {?>
              onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" <?php }?> 
            class="item">.
              <input class="hiddenItem" id="<?= $Mid ?>" value="<?= $baseState ?>" type="hidden" name="<?= $Mid ?>">
              <input type="hidden" id="Id<?= $Mid ?>" value="<?=$idSchedule?>">
              <input type="hidden" id="Description-<?=$Mid ?>" value="<?= $description?>">
              
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
    <div id="content" >
      <div class="showFormtxt">Información del formulario</div>
      <div class="showForm">
        <div id="div-information">
          <div class="showInfo"><?= $professorFirstName?> <?= $professorLastName ?></div>
          <div class="showInfo"><?= $careerName ?></div>
          <div class="showInfo">Periodo del <?= $periodNumber ?> Semestre, <?= $periodYear ?></div>
        </div>
        <div class="showInfo" id="div-workload"></div>
        <div class="showInfo" id="div-activities"></div>
        <div class="showInfo" id="div-courses"></div>
        <div class="showInfo" id="div-schedules"></div>
      </div>
    </div>

    <div id="editor"></div>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="submit" name="submit" class="submit submit-save action-button" value="Enviar" />
  </fieldset>

</form>

<div id="loader"></div>