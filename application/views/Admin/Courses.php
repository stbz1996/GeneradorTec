<main class="page-content">

<h2>VISTA DE CURSOS</h2>


<div class="input-group mb-3">
<select name="codeCourses" id="codeCourses" class="form-control form-control-lg">
    <option selected value="">Seleccione el curso</option>

    <?php foreach($courses as $course): ?>
        <option><?php echo $course['code'], '&nbsp', $course['name']; ?></option>
    <?php endforeach; ?>

</select>

<a href="Courses/see/<?php echo $course['code']; ?> " data-toggle="modal" data-target="#modalEditPersona" onClick="selPersona" class="btn btn-default">Ver</a>
<a href="Courses/edit/<?php echo $course['code']; ?> " class="btn btn-default">Editar</a>
<a href="Courses/delete/<?php echo $course['code']; ?> " class="btn btn-danger">Borrar</a>

<a href="Courses/see/<?php echo $course['code']; ?> " class="btn btn-default float-right">Crear</a>

<!-- MODAL -->
<div class="modal fade" id="modalEditPersona" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">

      <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Persona</h4>
      </div>

      <div class="modal-body">
	      <form class="form-horizontal">
	      	<!-- parametros ocultos -->
	      	<input type="hidden" id="mhdnIdPersona">
	      	
			<div class="box-body">
		        <div class="form-group">
		            <label class="col-sm-3 control-label">Nombre</label>
		            <div class="col-sm-9"> 
		              <input type="text" name="mtxtNombre" class="form-control" id="mtxtNombre" placeholder="">
		            </div>
		        </div>

		        <div class="form-group">
		            <label class="col-sm-3 control-label">Ap.Paterno</label>
		            <div class="col-sm-9"> 
		              <input type="text" name="mtxtApPaterno" class="form-control" id="mtxtApPaterno" value="" >
		            </div>
		        </div>

		        <div class="form-group">
		            <label class="col-sm-3 control-label">Ap.Materno</label>
		            <div class="col-sm-9"> 
		              <input type="text" name="mtxtApMaterno" class="form-control" id="mtxtApMaterno">
		            </div>
		        </div>

		        <div class="form-group">
		            <label class="col-sm-3 control-label">Email</label>
		            <div class="col-sm-9"> 
		              <input type="text" name="mtxtEmail" class="form-control" id="mtxtEmail">
		            </div>
		        </div>

		        <div class="form-group">
		            <label class="col-sm-3 control-label">Otro</label>
		            <div class="col-sm-9">
		            	<select class="form-control" id="mcboOtro" name="mcboOtro">
		            		<option value="">:: Elija</option>
		            		<option value="3">1</option>
		            		<option value="5">2</option>
		            		<option value="7">3</option>
		            	</select>
		            </div>
		        </div>
			</div>
		  </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="mbtnCerrarModal" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-info" id="mbtnUpdPerona">Actualizar</button>
      </div>
    </div>
  </div>
</div>


</div>



</main>