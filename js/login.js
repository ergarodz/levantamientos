$(document).ready(function() {

  //habilita login con tecla enter 
  $("#passw").keypress(function(e) {
      if(e.which == 13) {
      login();
      }
  });

  $("#username").keypress(function(e) {
      if(e.which == 13) {
        login();
      }
  });


});

function login(){
  $("#loader").show();
  
  var usa = $('#username').val();
  var pwd = $('#passw').val();

  len_pwd=pwd.length;//alert(len_pwd);
  for(i=0; i<=len_pwd; i++){
    pwd=pwd.replace(" ","");
  }

  if( usa == " " || usa == "" ){
    setTimeout(function () { $("#loader").hide(); }, 300); 
    swal.fire("Ingresa usuario");
  }else if(pwd == " " || pwd == ""){
    setTimeout(function () { $("#loader").hide(); }, 300); 
    swal.fire("Ingresa contraseña");
  }else{ 
    $.ajax({
      url:'acceso/route.php',
      data:{acceess:100,usa:usa,pwd:pwd},
      dataType:'json',
      type:'post',
      //beforeSend:function(){alert('antes');},
      success:function(yz){
        //alert(yz);
        if(yz=='Error'){
          setTimeout(function () { $("#loader").hide(); }, 300); 
          swal.fire("Usuario y/o contraseña incorrectos");
        }else{///no hay error, redirige dentro del sistema
          setTimeout(function () { $("#loader").hide(); }, 300); 
          location.href=yz;
        }
      }

    });
    // $.post("acceso/route.php",{acceess:100,usa:usa,pwd:pwd},function(yz){

    //   if(yz=='Error'){
    //     swal.fire("Usuaio y/o contraseña incorrectos");
    //   }else{///no hay error, redirige dentro del sistema
    //     location.href=yz;
    //   }
      
    // });

  } 
}