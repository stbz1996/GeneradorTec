<table id="table_id" class="table table-bordered table-hover table-condensed table-striped" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th class="col-sm-1" id="textCenter">Codigo</th>
                  <th class="col-sm-2" id="textCenter">Nombre</th>
                  <th class="col-sm-1" id="textCenter">Bloque</th>
                  <th class="col-sm-1" id="textCenter">Plan</th>
                  <th class="col-sm-1" id="textCenter">Estado</th>
                  <th class="col-sm-1" id="textCenter">Lecciones</th>
                  <th class="col-sm-1" id="textCenter">Opciones</th>
              </tr>
          </thead>
          <tbody>
              <?php 
              foreach($courses as $course){
                if ($course->isCareer == 1){?>
                  <tr>
                    <td><?php echo $course->code;?></td>
                    <td><?php echo $course->name;?></td>
                    <td><?php echo $course->blockName;?></td>
                    <td><?php echo $course->planName;?></td>
                    <td id="textCenter">
                      <div class="btn-group" data-toggle="buttons">
                      <?php if($course->state): ?>
                          <label class="btn btn-success active" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $course->idCourse ?>)'>
                            <input type="radio" name="radioActivate" id="option2" autocomplete="off" checked>
                            <span class="glyphicon glyphicon-ok"></span>
                          </label>
                          <label class="btn btn-danger" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $course->idCourse ?>)'>
                            <input type="radio" name="radioDesactivate" id="option2" autocomplete="off">
                            <span class="glyphicon glyphicon-ok"></span>
                          </label>
                      <?php else: ?>
                          <label class="btn btn-success" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $course->idCourse ?>)'>
                            <input type="radio" name="radioActivate" id="option2" autocomplete="off" >
                            <span class="glyphicon glyphicon-ok"></span>
                          </label>
                        
                          <label class="btn btn-danger active" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $course->idCourse ?>)'>
                            <input type="radio" name="radioDesactivate" id="option2" autocomplete="off" checked>
                            <span class="glyphicon glyphicon-ok"></span>
                          </label>
                      <?php endif; ?>

                      </div>
                    </td>
                    <td id="textCenter"><?php echo $course->lessonNumber; ?></td>
                    <td id="textCenter">

                      <button class="btn btn-primary" onclick='editCourse("<?= base_url($ADD['ADDRESS_3']) ?>", <?= $course->idCourse ?>)'>
                      
                        <i class="glyphicon glyphicon-pencil"></i>
                      </button>
                      
                      <button class="btn btn-danger" onclick='deleteCourse("<?=base_url().$ADD['ADDRESS_4']?>", <?= $course->idCourse ?>)'>
                        <i class="glyphicon glyphicon-trash"></i>
                      </button>

                    </td>
                  </tr>
                <?php }
              }?>
          </tbody>
      </table>