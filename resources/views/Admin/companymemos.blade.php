@extends('Admin.adminmaster')
@section('title','Manage Company Memos')
@section('content')

<div class="row" style="
    display: flex;
    justify-content: center;
    margin-top:20px;">
   <div class="col-md-9">
      
   </div>
   
   <div class="col-md-3">
      <a class="btn btn-dark" id="createnewmemo" href="#">Create a New Memo and Send</a>
   </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <h3 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">All Company Memos Sent to Admins and Tenants</h3>

        <div class="col-md-12">
            <table id="companymemostable" class="table table-striped table-bordered" style="width:100%; margin-top:50px;">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>Title</td>
                        <td>Date Sent</td>
                        <td>View</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('companymemoscript')
  <script>

    // show all the mpesa payments
    var companymemostable = $('#companymemostable').DataTable({
        processing:true,
        serverside:true,
        responsive:true,

        ajax:"{{ route('get.allmemos') }}",
        columns: [
            { data: 'id' },
            { data: 'memo_title' },
            { data: 'created_at',name:'created_at',orderable:false,searchable:false },
            { data: 'viewmemo',name:'viewmemo',orderable:false,searchable:false },
        ],
    });

    //   show creating a new memo modal
    $(document).on('click','#createnewmemo',function(){

        $('#sendmemomodal').modal('toggle');

        $("#memo_message_ck").html('<textarea id="memotxtarea" class="memodetailstextarea" name="memo_message"></textarea>');

        ClassicEditor
        .create( document.querySelector( '#memotxtarea' ),
        {
            toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', '|',
                'link', '|',
                'outdent', 'indent', '|',
                'bulletedList', 'numberedList', '|',
                'insertTable', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
            }
        })
    });

     // show rooms for a house on dropdown
     $(document).on('change','#recipienthouse',function(){
        var recipienthse_id=$( "#recipienthouse" ).val();
        var findusersurl = '{{ route("getusers.house") }}';

        $.ajax({
            type:'get',
            url:findusersurl,
            data:{
                'id':recipienthse_id
            },
            success:function(data){
                    console.log(data);
                    
                    data.forEach((user)=>{
                        console.log(user);
                        $('#usertenantnme').append('<option value="'+user.email+'">'+user.email+'</option>');
                    });
                    
            },error:function(){
            }
        });
    });

    //   send memo to users
    $(document).on('submit','#sendmemodetailsform',function()
    {
        var sendmemourl = '{{ route("save.memo") }}';

       $( "#recipienthouse" ).val();

        var form = $('#sendmemodetailsform')[0];
        var formdata=new FormData(form);

        $.ajax({
        url:sendmemourl,
        method:'POST',
        processData:false,
        contentType:false,
        data:formdata,
        success:function(response)
        {
            console.log(response);
            if (response.status==400)
            {
                $('#memo_errorlist').html(" ");
                $('#memo_errorlist').removeClass('d-none');
                $.each(response.message,function(key,err_value)
                {
                    $('#memo_errorlist').append('<li>' + err_value + '</li>');
                })
            } else if (response.status==200)
            {
                $('#memo_title').val('');
                $("#memo_message_ck").children("textarea").remove();
                $('.memodetailstextarea').val('');
                $('#sendmemomodal').modal('hide');
                alertify.set('notifier','position', 'top-right');
                alertify.success(response.message);
                companymemostable.ajax.reload();
            }

        }
        });
    });

  </script>
@stop


