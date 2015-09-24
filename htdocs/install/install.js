function swapConfig(x) {
  var radioEls = document.getElementsByName(x.name);
  for(i = 0 ; i < radioEls.length; i++){
    document.getElementById(radioEls[i].id.concat("Settings")).style.display="none";
  }
  document.getElementById(x.id.concat("Settings")).style.display="initial";
}


function updateValues(caller, className){
  callerValue = caller.value;
  if(callerValue !== '' && className !== 'HtVal'){
    callerValue = callerValue.concat('/');
  }
  classEls=document.getElementsByClassName(className);  // Find the elements
  for(var i = 0; i < classEls.length; i++){
    classEls[i].innerText=callerValue;    // Change the content
  }
}
