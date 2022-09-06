{{-- dropzone text --}}
$rentaldata=Rental_house::with('rentalalternateimages')->select('id','rental_name','location_id','rental_image')->find($id);

        $data = array();

        $validator=Validator::make($request->all(),
        [
            'file'=>'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        if($validator->fails()){
            $data['success']=0;
            $data['error']=$validator->errors()->first('file');
        }else{
            $images=$request->file('file');
        
            $rental_imagestmp=Image::make($images);
            $extension=$images->getClientOriginalExtension();
            
            $rental_imagesname=$rentaldata->rental_name.'-'.rand(111,9999).'.'.$extension;

            $alternatelarge_image_path='imagesforthewebsite/alternateimages/large/'.$rental_imagesname;
            $alternatemedium_image_path='imagesforthewebsite/alternateimages/medium/'.$rental_imagesname;
            $alternatesmall_image_path='imagesforthewebsite/alternateimages/small/'.$rental_imagesname;

            Image::make($rental_imagestmp)->save($alternatelarge_image_path);
            Image::make($rental_imagestmp)->resize(520,600)->save($alternatemedium_image_path);
            Image::make($rental_imagestmp)->resize(260,300)->save($alternatesmall_image_path);

            $rental_images=new Alternaterental_image();
            $rental_images->image=$rental_imagesname;
            $rental_images->house_id=$id;
            $rental_images->save();

            $data['success']=1;
            $data['message']='Uploaded Successfully';
            
            Rental_house::where('id',$rentaldata->id)->update(['tagimages_status'=>'1']);
        }
        
        return response()->json($data);


        {{-- js code --}}
        

        upload rental images using dropzone.js
            Dropzone.options.dropzoneForm=
            {
               maxFilesize: 2,
               maxFiles: 5,
               autoprocessQueue:false,
               acceptedFiles:"image/*,.png,.jpg,.gif,.bmp,.jpeg",

               init: function() {
                  this.on("maxfilesexceeded", function(file){
                     alert("No more files please!");
                  });
               }

               success:function(file,response)
               {
                  if(file.status==='success')
                  {

                     loadimages();
                     handleresponse.handleSuccess(response);
                  }else{
                     handleresponse.handleError(response);
                  }
               }

               // process the the response sent back
               var handleresponse={
                  handleError:function(response)
                  {
                     console.log(response);
                  },
                  handleSuccess:function(response)
                  {
                     console.log(response);
                     var msg=document.getElementById('notificdiv');
                     msg.innerHTML='Image uploaded successfully.';
                     
                  },
               }
            }