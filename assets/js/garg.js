Send = ()=>{
    let name = document.querySelector('#name').value;
    let email = document.querySelector('#email').value;
    let last_name = document.querySelector('#last_name').value;
    let message = document.querySelector('#message').value;

  
    let fd = new FormData();
    fd.append('name',name);
    fd.append('email',email);
    fd.append('last_name',last_name);
    fd.append('message',message);
   
      fetch("form1.php",{
          method:"POST",
          headers:{
              // "Content-Type":"application/json",
              "Accept": 'application/json',
          },
          body: fd
      }).then(res=>res.text()).then((resData)=>{
          console.log(resData);
           resData = JSON.parse(resData);
           console.log(resData);
           if(resData=='success'){
           document.querySelector('#form1').innerHTML = "<h1 style='text-align:center;'> Thank You for Registering</h1>"; 
         }
           else{
                  alert('Please provide complete details!!');
           }
        }).catch(err =>{
          alert(err);
      });
  }