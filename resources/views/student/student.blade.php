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
  <title>Student</title>
  </head>
  <body>
      <div style="padding:30px"></div>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">STUDENT List</h5>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Sl</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  {{-- <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>photo</td>
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
              <h5 class="card-title"><span id="addT">Add Student</span> <span id="updateT">Update Student</span></h5>

              <form method="post" id="FrmUpload" action="javascript:void(0)" enctype="multipart/form-data">
                @csrf
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Student Name</label>
                          <input type="text" id="name" name="name" placeholder="Student name"class="form-control">
                          <span class="text-danger" id="nameError"> </span>
                      </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                          <span class="text-danger" id="emailError"> </span>
                      </div>

                      <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Photo</label>
                          <input type="file" class="form-control" id="photo" name="photo" aria-describedby="photoHelp">
                          <span class="text-danger" id="photoError"> </span>
                      </div>
                      <input type="hidden" id="id">
                      <button  id="addButton" type="submit" id="submit" class="btn btn-primary">Add</button>
                      <button id="updateButton" onclick='updatData();'class="btn btn-primary">Update</button>
                      
               </form>
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
        headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
      }) ;           

      function getAllData(){
           $.ajax({
             type:"GET",
             dataType:'json',
             url:"/student/alldata",
             success:function(response){
                     //ajax  ae foreach korar niyom
                   var  data = ""
                   $.each(response,function(key,value){
                      // console.log(value.name); korar niyom
                      data = data + "<tr>"
                        data = data + "<td>"+value.id+"</td>"
                        data = data + "<td>"+value.name+"</td>"
                        data = data + "<td>"+value.email+"</td>"
                        data = data + "<td><img src="+value.photo+" alt="+value.photo+"></td>"
                        data = data + "<td>"
                        data = data + "<button class='btn btn-success'>Edit</button>"
                        data = data + "<button class='btn btn-danger '>Delete</button>"
                        data = data + "</td>"
                      data = data + "</tr>"
                    })
                   $('tbody').html(data);
                  }
           });
      }

  getAllData();


$(document).ready(function (e) {
 
 $('#FrmUpload').on('submit',(function(e) {
  
 $.ajaxSetup({
  
 headers: {
  
   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  
 }
  
 });
  
 e.preventDefault();
  
 var formData = new FormData(this);
  
 $.ajax({
  
    type:'POST',
  
    url: "{{url('/student/store')}}",
  
    data:formData,
  
    cache:false,
  
    contentType: false,
  
    processData: false,
  
    success:function(data){
      getAllData();
      alert('Data has been uploaded successfully');
  
    },
  
    error: function(data){
  
        console.log(data);
  
    }
  
 });
  
 }));
  
 });

</script>


          <!-- Optional JavaScript -->
    <!-- Popper.js first, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
  </body>
</html>
