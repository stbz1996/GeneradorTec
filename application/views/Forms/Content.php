
<!-- multistep form -->
<form id="msform">
  
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
    <h3 class="fs-subtitle">Último día para enviar formulario: <?= $dueDate; ?></h3>
    <div>
      Profesor: <?= $professorFirstName?> <?= $professorLastName; ?><br/><br/>
      Carrera: <?= $careerName; ?><br/><br/>
      Periodo actual: <?= $periodNumber ?> Semestre, <?= $periodYear ?><br/><br/>
      Estado: <?= $formState; ?> <br/><br/>
    </div>
    <input type="button" name="next" class="next action-button" value="Siguiente" />
  </fieldset>
  
  <fieldset>
    <h2 class="fs-title">Carga</h2>
    <h3 class="fs-subtitle"> Debe seleccionar la posible carga de trabajo para el siguiente periodo*, influirá en el mínimo de cursos posibles a asignar en ese periodo. <br/><br/>
    *Nota: Se puede agregar literalmente "siguiente periodo" o agregar el periodo que sigue, ejm: I semestre del 2019.</h3>
    <div>
      <select>
        <option value="0">0% (0 cursos)</option>
        <option value="25">25% (1 curso)</option>
        <option value="50">50% (2 cursos)</option>
        <option value="75">75% (3 cursos)</option>
        <option value="100">100% (4 cursos)</option>
      </select>
    </div>
    <input type="button" name="previous" class="previous action-button" value="Anterior" />
    <input type="button" name="next" class="next action-button" value="Siguiente" />
  </fieldset>

  <fieldset>
    <h2 class="fs-title">Actividades</h2>
    <h3 class="fs-subtitle"> Ingrese las actividades que considera le reducen la carga de trabajo, esto afectará la carga que brindo en la sección anterior. </h3>

    <div>
      <!--TODO: Do it dynamic-->
      Actividades:<br/><br/>
      Actividad 1:
      <input type="text" name="activity1">
      <input type="number" name="activityVal1" min="0" value="0"><br/>
      
      Actividad 2:
      <input type="text" name="activity2">
      <input type="number" name="activityVal2" min="0" value="0"><br/>

      Actividad 3:
      <input type="text" name="activity3">
      <input type="number" name="activityVal3" min="0" value="0">
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