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
    <h1 class="tittles">Cursos</h1>
</div>
<hr>


<!-- Todo el contenido -->
<div id="allcontent">
    <div class="filterCoursesContainer">
        <button class="btn btn-primary" onclick="addCourse()">
            <i class="glyphicon glyphicon-plus"></i> 
            Crear Curso
        </button>
        <button class="btn btn-primary" onclick='callCourses("<?= $carrerCourses ?>")'>
            <i class="glyphicon glyphicon-book"></i> 
            Ver cursos de carrera
        </button>
        <button class="btn btn-primary" onclick='callCourses("<?= $noCarrerCourses ?>")'>
            <i class="glyphicon glyphicon-book"></i> 
            Ver otros cursos
        </button>
    </div>