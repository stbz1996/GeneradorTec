<?php
  $carrerCourses   = base_url()."/Administration/Courses_controller/callCarrerCourses";
  $noCarrerCourses = base_url()."/Administration/Courses_controller/callNoCarrerCourses";
?>

<script>
    // Variables
    var base_url = '<?php echo base_url() ?>';
    // Functions
    function callCourses(dir){
        location.href = dir;
    }
</script>

<!-- Los titulos -->
<div>
    <h1>Cursos</h1>
</div>
<hr>


<!-- Todo el contenido -->
<div id="allcontent">
    <button class="btn btn-primary" onclick="addCourse()">
        <i class="glyphicon glyphicon-plus"></i> 
        Crear Curso
    </button>

    <div class="filterCoursesContainer">
        <div class="filterCoursesButton" onclick='callCourses("<?= $carrerCourses ?>")'>
            Cursos de carrera
        </div>
        <div class="filterCoursesButton" onclick='callCourses("<?= $noCarrerCourses ?>")'>
            Otros cursos
        </div>
    </div>