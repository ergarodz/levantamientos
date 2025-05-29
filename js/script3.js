

function delete_reg(id){
  //alert('-- MENSAJE DE PRUEBA -- Se elimina el registro '+id);


  $.ajax({
    url:'../../Ops2.php',
    dataType:'json',
    type:'post',
    data:{action:'delete_reg', id:id},
    //beforeSend:function(){alert('entra');},
    success:function(a){
      //alert(a);
      if(a==true){
        alert('Registro borrado');
        location.href='admon_delete.php';
      }else{
        alert('No se pudo eliminar el registro');
      }
    }
  });


}


function update_valores_borrar(id){
  $("#actualizar_id_borrado").html('<button type="button" class="btn btn-primary" data-dismiss="modal" onclick=" delete_reg('+id+'); " >Ok</button>');
}