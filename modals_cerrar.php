<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content" >
			<div class="modal-header" >
				<h4 class="modal-title"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body"  align="center">
				<h4><b>¿Desea cerrar sesión?</b></h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="cerrar_sesion();">Ok</button>
			</div>
		</div>

	</div>
</div>

<script>
	function cerrar_sesion(){
	      
	    $.post("acceso/route.php",{acceess:99},function(yz){
	    	//document.getElementById('id01').style.display='none';  
	    	location.href=yz;
	    });
	}
</script>