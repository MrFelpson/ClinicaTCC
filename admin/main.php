<?php 
require_once "../init.php";
require_once DIR."includes/header/header.php";
require_once DIR."/classes/DB.php";
require_once DIR."/classes/admin.php";
$admin = new Admin("","","","","");
$admin->validaSessao($db);
$query_consultas = "SELECT *,a.id AS idConsulta FROM `consulta` AS `a` INNER JOIN `tipoconsulta` AS `b` ON `a`.`idTipoConsulta` = `b`.`id` WHERE 1";
$result = $db->consultar($query_consultas,$db);
while($ln = $result->fetch_assoc()){
    $response[] = array("title"=>$ln['descricao'],"start"=>$ln['data_inicio'],"end"=>$ln['data_fim'],"id"=>$ln['idConsulta']);
}    
$json = json_encode($response);
include_once "menu.php";
?>

<div class="separador"></div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-8">
            <div id="calendario">            
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="row" id="div-botao-cadastrar">
                <button class="btn btn-primary cadastrar-consulta botao ">+ Cadastrar Consulta</button>                
            </div>
            <div class="row" id="div-botao-cancelar">
                <button class="btn btn-primary botao" id="voltar-editar">Voltar</button>                
            </div>
            <br>
            <div class="row">
                <div class="cadastro-consulta">
                    <form id="cadastro-consulta" method="POST" action="<?= URL_BASE ?>controler/controler.php">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h3>Cadastrar Consulta</h3>
                                <h6  id="tipo_clinica">(Fisioterapia)</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="data">Data da consulta:</label><br>
                                <input type="date" name="data" class="form-control campo-texto">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="periodo">Período:</label><br>
                                <select name="periodo" id="periodo" class="form-control campo-texto">
                                    <option value="Manhã">Manhã</option>
                                    <option value="Tarde">Tarde</option>
                                    <option value="Noite">Noite</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">                            
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="horario">Horário:</label><br>
                                <div id="horario">
                                    
                                </div>
                            </div>                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="tipo-consulta">Tipo da consulta</label>
                                <div id="tipo-consulta">
                                    
                                </div>                                
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="nome_paciente">Nome do Paciente</label>
                                <select id="paciente" name="paciente" class="form-control" required>
                                    <option value="">Selecione um usuário</option>
                                    <?php                              
                                        $query_pacientes = "SELECT * FROM `usuario` WHERE 1" ;
                                        $result_pacientes = $db->consultar($query_pacientes,$db);    
                                        while($ln_pacientes = $result_pacientes->fetch_assoc()){ 
                                    ?>
                                        <option value="<?= $ln_pacientes['id'] ?>"><?= $ln_pacientes['nome']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                            <input type="hidden" name="clinica-consulta-admin" class="form-control campo-texto" value="fisioterapia">
                                <input type="hidden" name="acao" value="clinica-consulta-admin">
                                <input type="hidden" name="usuario" class="form-control campo-texto" value="<?php echo $_SESSION['id']; ?>">
                                <input type="submit" name="cadastrar-consulta" class="btn btn-primary botao" value="Cadastrar">
                            </div>
                        </div>
                    </form>                    
                </div>
                <div class="editar-consulta" class="row">
                    <form id="edita-consulta" method="POST" action="<?= URL_BASE ?>controler/controler.php">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <h3>Editar Consulta</h3>                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="data">Data da consulta:</label><br>
                                <input type="date" id="editar-data" name="data" class="form-control campo-texto">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="periodo">Período:</label><br>
                                <select name="periodo" id="editar-periodo" class="form-control campo-texto">
                                    <option value="Manhã">Manhã</option>
                                    <option value="Tarde">Tarde</option>
                                    <option value="Noite">Noite</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">                            
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="editar-horario">Horário:</label><br>
                                <div id="editar-horario">
                                    
                                </div>
                            </div>                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label for="tipo-consulta">Tipo da consulta</label>
                                <div id="editar-tipo-consulta">
                                    
                                </div>  
                            </div>
                        </div>
                        <br>                                       
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <button class="btn btn-danger botao" id="cancelar-editar">Cancelar consulta</button>  
                                <br>      
                                <input type="hidden" name="clinica-consulta-usuario" value="fisioterapia">
                                <input type="hidden" name="acao" value="editar-consulta-admin">
                                <input type="hidden" id="idConsulta" name="idConsulta">
                                <input type="hidden" name="usuario" class="form-control campo-texto" value="<?php echo $_SESSION['id']; ?>">
                                <br>
                                <input type="submit" name="editar-consulta" class="btn btn-primary botao" value="Editar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link href='../../includes/fullCalendar/packages/core/main.css' rel='stylesheet' />
<link href='../../includes/fullCalendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='../../includes/fullCalendar/packages/timegrid/main.css' rel='stylesheet' />


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src='../../includes/fullCalendar/packages/core/main.js'></script>
<script src='../../includes/fullCalendar/packages/daygrid/main.js'></script>
<script src='../../includes/fullCalendar/packages/timegrid/main.js'></script>
<script src='../../includes/fullCalendar/packages/core/locales/pt-br.js'></script>
<script src='../../includes/fullCalendar/packages/interaction/main.js'></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    clinica = $("#tipo_clinica").html();
    $("#periodo").on("change",function(){
        periodo = $(this).val();
        clinica = $("#tipo_clinica").html();
        getHorario(periodo,clinica);
    });
    $("#editar-periodo").on("change",function(){
        periodo = $(this).val();
        clinica = $("#tipo_clinica").html();
        getEditHorario(periodo,clinica);
    });
    var calendarEl = document.getElementById('calendario');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction','dayGrid','timeGrid' ],
        selectable:true,
        header: {
            left: 'title',
            center: 'Fisioterapia,Enfermagem',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        customButtons: {
            Fisioterapia: {
                text: 'Fisioterapia',
                click: function() {
                    $("#tipo_clinica").html("(Fisioterapia)");
                    $("#button-tipo-clinica").val("fisioterapia");
                    if($(".cadastro-consulta").is(':visible')){
                        $(".cadastrar-consulta").click();
                        setTimeout(function(){$(".cadastrar-consulta").click()},500);                           
                    }                    
                }
            },
            Enfermagem: {
                text: 'Enfermagem',
                click: function() {
                    $("#tipo_clinica").html("(Enfermagem)");
                    $("#button-tipo-clinica").val("enfermagem");
                    if($(".cadastro-consulta").is(':visible')){
                        $(".cadastrar-consulta").click();
                        setTimeout(function(){$(".cadastrar-consulta").click()},500);
                    }                    
                }                
            }
        },
        events:<?php echo $json; ?>,
        dayClick: function() {
        },
        eventClick: function(info) {
            editarConsulta(info.event.id);
            if($(".cadastro-consulta").is(':visible')){
                $(".cadastrar-consulta").click();
            };
            $("#div-botao-cadastrar").hide(500);
            setTimeout(function(){
                $("#div-botao-cancelar").show(500);
            },100);
            // change the border color just for fun
            info.el.style.borderColor = 'red';
        }
    });    
    calendar.render();
    calendar.setOption('locale', 'pt-br');
    $(".cadastrar-consulta").on("click",function(){
        if($(".cadastro-consulta").is(':visible')){
            $(".cadastro-consulta").hide(500);            
        }else{
            $(".cadastro-consulta").show(500);
            clinica = $("#tipo_clinica").html();
            periodo = $("#periodo").val();
            $.post("../../getPeriodo.php",{periodo:periodo,clinica:clinica},function(data){
                $("#horario").html(data);
            });
            $.post("../../getTipoConsulta.php",{clinica:clinica},function(data){
                $("#tipo-consulta").html(data);
            });
        }
    });
    $("#voltar-editar").on("click",function(){
        $("#div-botao-cancelar").hide(500);
        setTimeout(function(){
            $("#div-botao-cadastrar").show(500);
        },100);
        $(".editar-consulta").hide(500);     
    });
    $("#cancelar-editar").on("click",function(){
        if(confirm("Tem certeza que deseja cancelar a consulta?")){
            id = $("#idConsulta").val();
            $.post("../../controler/controler.php",{idConsulta:id,acao:"excluir-consulta"},function(){
                return 1;
            });
        }else{
            return 0;
        }
    });
    function getHorario(periodo,clinica){        
        $.post("../../getPeriodo.php",{periodo:periodo,clinica:clinica},function(data){
            $("#horario").html(data);
        });
    }
    function getEditHorario(periodo,clinica,horario){        
        $.post("../../getPeriodo.php",{periodo:periodo,clinica:clinica,horario:horario},function(data){
            $("#editar-horario").html(data);            
        });
    }
    function editarConsulta(id){
        $.ajax({
            url: '../../getConsulta.php',
            type: 'POST',
            data: {id:id},
            dataType: 'JSON',
            success: function(data){
                $("#editar-data").val(data[0].data_inicio) ;  
                $("#editar-periodo").val(data[0].periodo) ;
                getEditHorario(data[0].periodo,data[0].clinica,data[0].horario);
                $.post("../../getTipoConsulta.php",{clinica:data[0].clinica,tipo:data[0].idTipo},function(data){
                    $("#editar-tipo-consulta").html(data);
                });
                $("#editar-tipo-consulta").val(data[0].idTipo);
                $("#idConsulta").val(data[0].id);
                $(".editar-consulta").show(500);     
            }                               
        });
    }
});

</script>