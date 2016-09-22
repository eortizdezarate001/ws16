function ikusBalioak(){
  var sAux="";
  var frm=document.getElementById("erregistro");
  for(i=0;i<frm.elements.length-2;i++){
    sAux +="IZENA: " + frm.elements[i].name+" ";
    sAux +="BALIOA: " + frm.elements[i].value+"\n";
  }
  alert(sAux);
}

function validateEmail(email){
  var reg = /[a-z]*[0-9][0-9][0-9]@ikasle.ehu.e(u?)s/;
  return reg.test(email);
}

function validatePhone(phone){
  var reg = /[0-9]{9}/;
  return reg.test(phone);
}
  
function validation(){
  var s = "";
  var b=false;
  var f=document.getElementById("erregistro");
  for(i=0;i<5;i++){
    if(f.elements[i].value==""){
      s += f.elements[i].name + " is empty!\n";
      b=true;
    }
  }
  if(b==true) alert(s);
  else if(document.getElementById("pass").value.length<6)
    alert("Password needs at least 6 characters.");
  else if(validateEmail(document.getElementById("email").value)==false)
    alert("Incorrect e-mail.");
  else if(validatePhone(document.getElementById("phone").value)==false)
    alert("Incorrect phone number.");
  else ikusBalioak();
}
