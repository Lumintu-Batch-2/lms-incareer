var swiper = new Swiper(".mySwiper", {
    autoplay: 
    {
      delay: 5000,
    },
    loop: true,
  });

 function validation(){
   let form = document.getElementById('formForgot');
   let email = document.getElementById('forgotEmail').value;
   let text = document.getElementById('text');
    console.log(email)
   let pattern = /^[^ ]+\.[a-z]{1,3}$/;

   if(email === ''){
    text.innerHTML =''
   }else{
     if(email.match(pattern)){
      form.classList.add("valid");
      form.classList.remove("invalid")
      text.innerHTML = '<i class="fas fa-check"></i> Email adress is valid.';
      text.style.color = "#00ff00";
    }else{
     form.classList.remove("valid");
     form.classList.add("invalid");
     text.innerHTML = '<i class="fas fa-times"></i> Email adress is invalid.';
     text.style.color = "#ff0000";
    }
   }
 } 