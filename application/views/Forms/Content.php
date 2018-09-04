
<?php

  $button = array(
    'name' => 'submitButton',
    'value' => 'Submit'
  );

  $linkWorkload = base_url()."index.php/Form_controller/getDataFromView";

?>

<!--<a href="<?= $linkWorkload ?>"> <i class="fa fa-calendar"></i> <span>Generar Links</span> </a>-->

<!-- multistep form -->
<form id="msform" action="Form_controller/getDataFromView" method="post">
  
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
      <div>
      Estado: <?= $formState ?>
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
        <option value="25">25% (1 curso)</option>
        <option value="50">50% (2 cursos)</option>
        <option value="75">75% (3 cursos)</option>
        <option value="100">100% (4 cursos)</option>
      </select>
    </div>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="button" name="next" class="next action-button" value="Siguiente" />
    <!--<input type='submit' name='submit' class="submit action-button" value='Submit' />-->
    
  </fieldset>

  <fieldset>
    <h2 class="fs-title">Actividades</h2>
    <h3 class="fs-subtitle"> Ingrese las actividades que considera le reducen la carga de trabajo, esto afectará la carga que brindo en la sección anterior. </h3>

    <div>
      <!--TODO: Do it dynamic-->
      <div>
      <!--Actividad 1:-->
      <table id="dynamic_field" name="dynamic_field">
        <tr>
          <td><input type="text" name="name1" id="name" placeholder="Ingrese actividad" /></td>
          <td><input type="number" name="porcentWork1" class="textnum" min="0" max="100" value="0"></td>
        </tr>
      </table>
      <td><input type="button" name="add" id="add" class="btn_add" value="+" /></td>
      
      <!--<input type="number" id="activity_porcent" min="0" value="0" class="textnum">-->
      
      </div>
      <!--<div>
      Actividad 2:
      <input type="text" name="activity2" class="textbox">
      <input type="number" name="activityVal2" min="0" value="0" class="textnum">
      </div>
      <div>
      Actividad 3:
      <input type="text" name="activity3" class="textbox">
      <input type="number" name="activityVal3" min="0" value="0" class="textnum">
      </div>-->
    </div>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="button" name="next" class="next action-button" value="Siguiente" />
  </fieldset>

  <fieldset>
    <h2 class="fs-title">Cursos</h2>
    <h3 class="fs-subtitle"></h3>
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
    <input type="submit" name="submit" class="submit action-button" value="Guardar" />
    <input type="submit" name="submit" class="submit action-button" value="Enviar" />
  </fieldset>

</form>
