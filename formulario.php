<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Formulario</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    </head>
    <body>
        <br/><br/>
        <div class="container">
            <h2 id="main_title" align="center">Puntos de Monitoreo "Fundación Gaia Pacha" | Rio Rocha 2018</h2>
            <br/>
            <div>
            <div id="div_left" align="left">
                <button type="button" id="support_button"class="btn btn-warning" value="1">Ver Mapa</button>
            </div>
            
            <div id="div_right" align="right">
                <button type="button" id="add_samples_button" class="btn btn-success" data-name="">Agregar Muestras</button>
            </div>
            </div>
            <br/>
            <div id="main_table" class="table-responsive" style="clear:both">
                
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
<div id="addSampleModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span id="change_title">Agregar Muestra</span>
                </h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="add_sample_form" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="name_leader">Nombre Responsable</label>
                    <input type="text" id="name_leader" name="name_leader" required class="form-control" placeholder="Nombre del Responsable"/>
                    </div>
                    <div class="form-group">
                    <label for="bmwp_total">Total BMWP/BOL</label>
                    <input type="text" name="bmwp_total" id="bmwp_total" class="form-control" required placeholder="Total BMWP/Bol"/>
                    </div>
                    <div class="form-group">
                    <label for="date_sample">Fecha</label>
                    <input type="date" name="date_sample" id="date_sample" required class="form-control" />
                    </div>
                    <br/>
                    <input type="hidden" name="hidden_marker_id" id="hidden_marker_id"/>
                    <input type="hidden" name="hidden_marker_place" id="hidden_marker_place"/>
                    <input type="hidden" name="hidden_add_sample" id="hidden_add_sample"/>
                    <input type="submit" name="save_button" class="btn btn-info" value="Guardar"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="updateMarkerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span id="change_title">Actualizar Punto de Monitoreo</span>
                </h4>
            </div>
            <div class="modal-body">
                <form method="POST" id="update_marker_form" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="marker_place">Lugar</label>
                    <input type="text" id="marker_place" name="marker_place" required class="form-control" placeholder="Lugar"/>
                    </div>
                    <div class="form-group">
                    <label for="marker_lat">Latitud</label>
                    <input type="text" name="marker_lat" id="marker_lat" class="form-control" required placeholder="Latitud"/>
                    </div>
                    <div class="form-group">
                    <label for="marker_long">Longitud</label>
                    <input type="text" name="marker_long" id="marker_long" required class="form-control" placeholder="Longitud"/>
                    </div>
                    <br/>
                    <input type="hidden" name="hidden_id_marker" id="hidden_id_marker"/>
                    <input type="hidden" name="hidden_update_marker" id="hidden_update_marker"/>
                    <input type="submit" name="save_button" class="btn btn-info" value="Guardar"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
            $(document).ready(function(){
                load_folder_list();
                
                function load_folder_list(){
                    var action = "fetch";
                    $("#add_samples_button").hide();
                    $.ajax({
                        url : "action.php",
                        method: "POST",
                        data:{action:action},
                        success: function(data){
                            $('#main_table').html(data);
                        }
                    });
                }
                
                function load_samples_list(id_marker, place_marker){
                    var id = id_marker;
                    var place = place_marker;
                    $("#main_title").text("Tabla de Muestras | Punto " + place);
                    $("#support_button").text("Atrás");
                    $("#support_button").attr("value", 2);
                    $("#div_left").css({"float":"left", "display":"block"});
                    $("#add_samples_button").toggle(true);
                    $("#add_samples_button").attr("data-name", id+"");
                    $("#add_samples_button").attr("value", place);
                    $.ajax({
                        url : "samples.php",
                        method: "POST",
                        data:{id_point:id},
                        success: function(data){
                            $('#main_table').html(data);
                        }
                    });
                }
                
                $(document).on("click", "#support_button", function(){
                    var option = $(this).attr("value");
                    if(option == 1){
                        window.open("http://www.gaiapacha.org/riorocha/", '_blank');
                    } else {
                        //alert('hi');
                        window.location.reload(true);
                    }
                });
                
                $(document).on("click", "#view_samples", function(){
                    var id = $(this).data("name");
                    var place = $(this).attr("value");
                    load_samples_list(id, place);
                });
                
                $(document).on("click", "#add_samples_button", function(){
                    var markerId = $(this).data("name");
                    var markerPlace = $(this).attr("value");
                    $("#hidden_marker_id").val(markerId);
                    $("#hidden_marker_place").val(markerPlace);
                    $("#hidden_add_sample").val("addSample");
                    $("#addSampleModal").modal("show");
                });
                
                $("#add_sample_form").on("submit", function(e){
                    e.preventDefault();
                    var id = $("#hidden_marker_id").val();
                    var place = $("#hidden_marker_place").val();
                    $.ajax({
                        url: "action.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(msg){
                            alert(msg);
                            $("#name_leader").val("");
                            $("#bmwp_total").val("");
                            $("#date_sample").val("");
                            $("#addSampleModal").modal("hide");
                            load_samples_list(id, place);
                        }
                    });
                });
                
                $(document).on("click", ".updateMarkers", function(){
                    var markerId = $(this).data("id");
                    var place = $(this).data("place");
                    var lat = $(this).data("lat");
                    var long = $(this).data("long");
                    $("#hidden_id_marker").val("" + markerId);
                    $("#hidden_update_marker").val("updateMarker");
                    $("#marker_place").val(place);
                    $("#marker_lat").val(lat);
                    $("#marker_long").val(long);
                    $("#updateMarkerModal").modal("show");
                });
                
                $("#update_marker_form").on("submit", function(e){
                    e.preventDefault();
                    $.ajax({
                        url: "action.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(msg){
                            alert(msg);
                            window.location.reload(true);
                        }
                    });
                });
                
                $(document).on("click", ".remove", function(){
                    var id = $(this).data("name");
                    var markerId = $("#add_samples_button").data("name");
                    var place = $("#add_samples_button").attr("value");
                    var action = "remove";
                    if(confirm("Está seguro de eliminar este registro?")){
                        $.ajax({
                            url: "action.php",
                            method: "POST",
                            data: {id:id, action:action},
                            success: function(data){
                                alert(data);
                                load_samples_list(markerId, place);
                            }
                        });
                    } else {
                        return false;
                    }
                });
                
            });
            
        </script>