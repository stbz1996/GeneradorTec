function realizaProceso(idReceived){
        var parametros = {
                "idReceived" : idReceived
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   "<?=base_url()?>/index.php/Administrator_controller/editPlan", //archivo que recibe la peticion
                type:  'post', //método de envio
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        $("#resultado").html(response);
                }
        });
}