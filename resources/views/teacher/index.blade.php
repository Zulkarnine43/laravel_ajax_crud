<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <title>Teacher</title>
  </head>
  <body>
      <div style="padding:30px"></div>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Teacher List</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Sl</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td><a class="btn btn-success" href="">Edit</a><a class="btn btn-danger" href="">Delete</a></td>
                  </tr> --}}
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><span id="addT">Add Teacher</span> <span id="updateT">Update Teacher</span></h5>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Teacher Name</label>
                    <input type="text" id="name" placeholder="Teacher name"class="form-control">
                    <span class="text-danger" id="nameError"> </span>
                </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                    <span class="text-danger" id="emailError"> </span>
                </div>
                <input type="hidden" id="id">
                <button  id="addButton" onclick="addData();" class="btn btn-primary">Add</button>
                <button id="updateButton" onclick='updatData();'class="btn btn-primary">Update</button>
            </div>
          </div>
        </div>
        <div class="col-sm-1"></div>
      </div>

      <script>

          $('#addT').show();
          $('#addButton').show();
          $('#updateT').hide();
          $('#updateButton').hide();

            $.ajaxSetup({
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content');
            }
            });

          function allData(){
              $.ajax({
                  type: "GET",
                  dataType: 'json',
                  url: "/teacher/all",
                  success:function(response){
                     //ajax  ae foreach korar niyom
                   var  data = ""
                   $.each(response,function(key,value){
                      // console.log(value.name); korar niyom
                      data = data + "<tr>"
                        data = data + "<td>"+value.id+"</td>"
                        data = data + "<td>"+value.name+"</td>"
                        data = data + "<td>"+value.email+"</td>"
                        data = data + "<td>"
                        data = data + "<button class='btn btn-success' onclick='editData("+value.id+")'>Edit</button>"
                        data = data + "<button class='btn btn-danger ' onclick='deleteData("+value.id+")'>Delete</button>"
                        data = data + "</td>"
                      data = data + "</tr>"
                    })
                   $('tbody').html(data);
                  }
              })
          }
     allData();
 //data clear korar jonnoo.
     function clearData(){
            $('#name').val('');
            $('#email').val('');
            $('#nameError').text('');
            $('#emailError').text('');
        }
    //data clear End.
    //data insert korrar jonno.
          function addData(){
            var name  =  $('#name').val();
            var email = $('#email').val();
            $.ajax({
                type:"POST",
                dataType:"json",
                data:{name:name, email:email},
                url: "/teacher/store/",
                success: function(data){
                    clearData();
                    allData();
// ==============show alert==========
                 const Msg = Swal.mixin({
                     toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 5000
                  })
                  Msg.fire({
                    type: 'success',
                    title: 'Data Added Success',
                  })
// ============== end show alert==========
                console.log('data insert');
              },
              error: function(error){
                  $('#nameError').text(error.responseJSON.errors.name);
                  $('#emailError').text(error.responseJSON.errors.email);
               }
            })
          }
           //data insert korrar End.

         //edit korar jonno==============

          function editData(id){
           $.ajax({
               type:"GET",
               dataType:"json",
               url: "/teacher/edit/"+id,
               success:function(data){
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);

                    $('#addT').hide();
                    $('#addButton').hide();
                    $('#updateT').show();
                    $('#updateButton').show();
                   console.log(data);
               }
           })
          }
   //edit korar jonno end==============

   //update korar jonno ==============
    function updatData(){
        var id    =  $('#id').val();
        var name  =  $('#name').val();
        var email = $('#email').val();

        $.ajax({
            type:"POST",
            dataType:"json",
            data:{name:name, email:email},
             url: "/teacher/update/"+id,
             success:function(data){
              clearData();
              allData();

         // ==============show alert==========
        const Msg = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 4000
                 })
                  Msg.fire({
                        type: 'success',
                        title: 'Data Updated Success',
                     })
          // ============== end show alert==========
              console.log('data update');
              $('#addT').show();
              $('#addButton').show();
              $('#updateT').hide();
              $('#updateButton').hide();

             },

             error: function(error){
                  $('#nameError').text(error.responseJSON.errors.name);
                  $('#emailError').text(error.responseJSON.errors.email);
             }
        })

        }

   //update korar jonno end==============


   //delete korar jonno ==============
 function deleteData(id){
 // ==============show alert==========
 Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
            type:"GET",
            dataType:"json",
            url: "/teacher/delete/"+id,
            success:function(data){
                clearData();
                allData();
                $('#addT').show();
                $('#addButton').show();
                $('#updateT').hide();
                $('#updateButton').hide();

         const Msg = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 4000
                 })
                Msg.fire({
                    type: 'warning',
                    title: 'Data Deleted Success',
                })
          }
     })



          // ============== end show alert==========

                console.log(data);
               }
           })
       }

   //delete korar jonno end==============



      </script>

    <!-- Optional JavaScript -->
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  </body>
</html>
