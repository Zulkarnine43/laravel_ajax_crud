<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Laravel Image Upload Using Ajax Example with Coding Driver</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.9/sweetalert2.all.min.js" integrity="sha512-IZ95TbsPTDl3eT5GwqTJH/14xZ2feLEGJRbII6bRKtE/HC6x3N4cHye7yyikadgAsuiddCY2+6gMntpVHL1gHw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>


  <h2 class="text-center">Ajax Image Upload</h2>
  <div class="row">
    <div class="col-md-4 ml-5 mt-4 mr-5"  >
      <h3 id="add_student" class="text-center">Add Student</h3>
      <h3  id="update_student" class="text-center">Update Student</h3>

      <form method="post" id="upload-image-form" class="updateForm" enctype="multipart/form-data">
          @csrf
          
          <input type="hidden" name="image_id" id="img_id">
          <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" class="form-control" id="name-input">
            <span class="text-danger" id="name-input-error"></span>
         </div>
         <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control" id="email-input">
            <span class="text-danger" id="email-input-error"></span>
         </div>
        <div class="form-group">
          <label for="">Department</label>
          <input type="text" name="department" class="form-control" id="department-input">
          <span class="text-danger" id="department-input-error"></span>
        </div>
        <div id="image_show_hide">
          <label for="">old image</label> <br>
          <img  id="old_image" src="" alt="" height="100" width="100" style="border-radius: 50%">
        </div>
         
        <div class="form-group">
          <input type="file" name="file" class="form-control" id="image-input">
          <span class="text-danger" id="image-input-error"></span>
        </div>
          <div class="form-group">
            <button type="submit" id="student_add" class="btn btn-success">Add Student</button>
            <button type="submit" id="student_update" class="btn btn-success">Update Student</button>

            
          </div>
  
     </form>
  </div>
  <div class="col-md-5 mt-5">
    <h3 class="text-center">All Student</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Department</th>
          <th scope="col">Image</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>


        </tr>
      </thead>
      <tbody>
       
        
      </tbody>
    </table>
  
  </div>
  
  </div>


<script>

$("#student_update").hide();
$("#image_show_hide").hide();

$("#update_student").hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    fetchImage();
    function fetchImage(){
      $.ajax({

        type:"GET",
        url:"/fetch-image",
        dataType:"json",
        success: function(response){
          //console.log(response.images);
          fetchImage();

          $('tbody').html("");
          $.each(response.images, function(key, item){
            $('tbody').append('<tr>\
                        <td>'+item.id+'</td>\
                        <td>'+item.name+'</td>\
                        <td>'+item.email+'</td>\
                        <td>'+item.department+'</td>\
                        <td><img src="'+item.image+'"width="50px" height="50px" alt="Image" style="border-radius:50%"></td>\
                        <td><button type="button" id=""  value="'+item.id+'" onclick="editImage('+item.id+')" class=" edit_btn btn btn-success btn-sm">Edit</button></td>\
                        <td><button type="button" value=""  onclick="deleteImage('+item.id+')" class="delete_btn btn btn-danger btn-sm">Update</button></td>\
                      </tr>');


          });
          
        }
      });
    }

     function deleteImage(id)
     {
       $.ajax({
         type:"POST",
         url:"delete/"+id,
         dataType:"json",
         success: function(response){
           // Stare Alert
                  const Msg = Swal.mixin({
                           toast:true,
                           position:'top-end',
                           icon:'success',
                           showConfirmButton:false,
                           timer:2000 
                           
                         })
                         Msg.fire({
                           type:'error',
                           title:'Data Deleted Successfully!',
                           
                           
                         })
           
         }
       })
     }

     function cleaData()
     {
              $("#name-input").val('');   
              $("#email-input").val('');            
              $("#department-input").val('');   
              $("#old_image").attr(' ');  
     }
    function editImage(id)
      {
        $.ajax({
          type:"GET",
          url:"edit-image/"+id,
          dataType:"json",
          success: function(data){
            $("#img_id").val(data.id);   

              $("#name-input").val(data.name);   
              $("#email-input").val(data.email);            
              $("#department-input").val(data.department);   
              $("#old_image").attr('src',data.image);   
              $("#image_show_hide").show();
              $("#add_student").hide();
              $("#update_student").show();
              $("#student_update").show();
              $("#student_add").hide();




                       
         
              
          }
        });
        
      }

    // $(document).on('click','.edit_btn', function(e){
    //   e.preventDefault();
    //   var id = $(this).val();
    //   alert(id);
    // });

    
   $('#upload-image-form').submit(function(e) {
       e.preventDefault();
       let formData = new FormData(this);
       $('#image-input-error').text('');

       $.ajax({
          type:'POST',
          url: `/upload-images`,
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {

           $("#image_show_hide").hide();
             if (response) {
               this.reset();
               cleaData();

               //alert('Image has been uploaded successfully');
                  // Stare Alert
                  const Msg = Swal.mixin({
                           toast:true,
                           position:'top-end',
                           icon:'success',
                           showConfirmButton:false,
                           timer:2000 
                           
                         })
                         Msg.fire({
                           type:'success',
                           title:'Data Added Successfully!',
                           
                           
                         })
                         
                         //End Alert
             }
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
           }
       });
  });
  // $('.updateForm').submit(function(e) {
  //      e.preventDefault();
  //      let formData = new FormData(this);

  //      $.ajax({
  //         type:'POST',
  //         url: `update`,
  //          data: formData,
  //          contentType: false,
  //          processData: false,
  //         success: function(response){

  //           cleaData();
  //           // Stare Alert
  //           const Msg = Swal.mixin({
  //                          toast:true,
  //                          position:'top-end',
  //                          icon:'success',
  //                          showConfirmButton:false,
  //                          timer:2000 
                           
  //                        })
  //                        Msg.fire({
  //                          type:'error',
  //                          title:'Data Updated Successfully!',
                           
                           
  //                        })
           
  //         }
  //         //  error: function(response){
  //         //     console.log(response);
  //         //       $('#image-input-error').text(response.responseJSON.errors.file);
  //         //  }
  //      });
  // });

</script>
</body>
</html>