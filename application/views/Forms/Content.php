
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
  
  <input type="Submit" name="Submit" value="Submit">
  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active">Información</li>
    <li> Carga </li>
    <li> Actividades </li>
    <li> Cursos </li>
    <li> Horarios </li>
    <li> Guardar o Enviar </li>
  </ul>
  
  <!-- fieldsets -->
  <fieldset>
    <h2 class="fs-title">Información</h2>
    <h3 class="fs-subtitle">Último día para enviar formulario: <?= $dueDate ?></h3>
    <div>
      <div>
        Profesor: <?= $professorFirstName?> <?= $professorLastName ?>
      </div>
      <div>
      Carrera: <?= $careerName ?>
      </div>
      <div>
      Periodo actual: <?= $periodNumber ?> Semestre, <?= $periodYear ?>
      </div>
    </div>
    <input type="button" name="next" class="next action-button" value="Siguiente" />
    
  </fieldset>
  
  <fieldset>
    <h2 class="fs-title">Carga</h2>
    <h3 class="fs-subtitle"> Debe seleccionar la posible carga de trabajo para el siguiente periodo*, influirá en el mínimo de cursos posibles a asignar en ese periodo. <br/><br/>
    *Nota: Se puede agregar literalmente "siguiente periodo" o agregar el periodo que sigue, ejm: I semestre del 2019.</h3>
    
    <div>
      <select name="workload_options">

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
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="button" name="next" class="next action-button" value="Siguiente" />
    <!--<input type='submit' name='submit' class="submit action-button" value='Submit' />-->
    
  </fieldset>

  <fieldset>
    <h2 class="fs-title">Actividades</h2>
    <h3 class="fs-subtitle"> Ingrese las actividades que considera le reducen la carga de trabajo que espera obtener, por lo que afectará la carga que brindó en la sección anterior. </h3>

    <div>
      <input type="button" name="add" id="add" class="btn_add action-button" value="Agregar Actividad" />
      
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
    <input type="button" name="next" class="next action-button" value="Siguiente" />
  </fieldset>

  <fieldset>
    <h2 class="fs-title">Cursos</h2>
    <h3 class="fs-subtitle"></h3>

    <div class="list-courses">

      <?php 
      $countPlans = count($plans);
      $totalCourses = 1;
      for($i = 0; $i < $countPlans; $i++) { ?>
        <table>
          <?= $plans[$i]->getName() ?>
          <tbody>
            <?php 
            $countCourses = count($courses[$i]);
            for($j = 0; $j < $countCourses; $j++) {
              $nameRow = 'row-'.$totalCourses;
              $nameSelect = 'select-'.$totalCourses;
              $nameCheckBox = 'cbox-'.$totalCourses;
              $nameIdCourse = 'course-'.$totalCourses;
              $idCourse = $courses[$i][$j]->getId(); ?>
              <tr id=<?=$nameRow ?> >
                <td><input type="hidden" id=<?= $nameIdCourse ?> value=<?=$idCourse?> /></td>
                <td><?= $courses[$i][$j]->getCode() ?> </td>
                <td><?= $courses[$i][$j]->getName() ?> </td>
                <td>
                  <select id=<?=$nameSelect ?> <?= in_array($idCourse, $idCourses) ? 'disabled' : '' ?>>
                    <?php 
                    if(in_array($idCourse, $idCourses))
                    {
                    ?>
                      <option <?= $priorities[array_search($idCourse, $idCourses)] == 'A' ? 'selected="selected"' : '' ?> value="A">A</option>
                      <option <?= $priorities[array_search($idCourse, $idCourses)] == 'B' ? 'selected="selected"' : '' ?> value="B">B</option>
                      <option <?= $priorities[array_search($idCourse, $idCourses)] == 'C' ? 'selected="selected"' : '' ?> value="C">C</option>
                    <?php 
                    }
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
                </td>
                <td><input type="checkbox" class="cbox" id=<?= $nameCheckBox ?> value="first_checkbox" <?= in_array($idCourse, $idCourses) ? 'checked' : '' ?> /></td>
                <?php 
                if(in_array($idCourse, $idCourses)) {?>
                <td id="id-<?= $totalCourses ?>">
                  <input type="hidden" name="idCourses[]" value=<?= $idCourse?> />
                </td>
                <td id="priority-<?= $totalCourses ?>">
                  <input type="hidden" name="priorities[]" value=<?= $priorities[array_search($idCourse,$idCourses)]?> />
                </td>
                <?php } ?>

              </tr>
            <?php 
              $totalCourses++;
            }?>
          </tbody>
        </table>
      <?php }?>     
    </div>

    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="button" name="next" class="next action-button" value="Siguiente" />
  </fieldset>

  <fieldset>
    <h2 class="fs-title">Horarios</h2>
    <h3 class="fs-subtitle"></h3>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="button" name="next" class="next action-button" value="Siguiente" />
  </fieldset>
  
  <fieldset>
    <h2 class="fs-title">Guardar o Enviar</h2>
    <h3 class="fs-subtitle"></h3>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="Submit" name="Submit" class="Submit action-button" onclick="Form_Controller/getDataFromView()" value="Guardar" />
    <input type="submit" name="submit" class="submit action-button" value="Enviar" />
  </fieldset>

</form>
