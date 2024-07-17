@extends("admin.admin_app")

@section("content")

  
  <div class="content-page">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card-box table-responsive">

                <div class="row">             
                <div class="col-md-3">
                  <a href="{{URL::to('admin/tv_category/add_category')}}" class="btn btn-success btn-md waves-effect waves-light m-b-20" data-toggle="tooltip" title="{{trans('words.add_category')}}"><i class="fa fa-plus"></i> {{trans('words.add_category')}}</a>
                </div>
              </div>

                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
              

              <div class="row">
                  @foreach($category_list as $i => $category_data)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6" id="card_box_id_{{$category_data->id}}">
                        <!-- Simple card -->
                        <div class="card m-b-20 p-3 lng_item_grid">
                            <div class="card-body p-0">
                                <!--<h4 class="card-title mb-3">{{ stripslashes($category_data->category_name) }}</h4>-->
								<div class="item_latter">{{ stripslashes($category_data->category_name) }}</div>
                                <a href="{{ url('admin/tv_category/edit_category/'.$category_data->id) }}" class="btn waves-effect waves-light btn-success m-b-0 m-r-5" data-toggle="tooltip" title="{{trans('words.edit')}}"> <i class="fa fa-edit"></i> </a>
                                <a href="#" class="btn waves-effect waves-light btn-danger data_remove" data-toggle="tooltip" title="{{trans('words.remove')}}" data-id="{{$category_data->id}}"> <i class="fa fa-remove"></i></a>
                                <a href="Javascript:void(0);" class="ml-2 fl-right mt-1" data-toggle="tooltip" title="@if($category_data->status==1){{ trans('words.active')}} @else {{trans('words.inactive')}} @endif"><input type="checkbox" name="ads_on_off" id="ads_on_off" value="1" data-plugin="switchery" data-color="#28a745" data-size="small" class="enable_disable"  data-id="{{$category_data->id}}" @if($category_data->status==1) {{ 'checked' }} @endif/></a>    
                            </div>
                        </div>
                    </div>
                   @endforeach      
                </div>

                <nav class="paging_simple_numbers">
                @include('admin.pagination', ['paginator' => $category_list]) 
                </nav>
           
              </div>
            </div>
          </div>
        </div>
      </div>
      @include("admin.copyright") 
    </div>

    <script src="{{ URL::asset('admin_assets/js/jquery.min.js') }}"></script>
 
    <script type="text/javascript">
 
 $(".enable_disable").on("change",function(e){      
        
       var post_id = $(this).data("id");
       
       var status_set = $(this).prop("checked"); 
 
       var action_name='livetv_cat_status';
       //alert($(this).is(":checked"));
       //alert(status_set);
 
       $.ajax({
         type: 'post',
         url: "{{ URL::to('admin/ajax_status') }}",
         dataType: 'json',
         data: {"_token": "{{ csrf_token() }}",id: post_id, value: status_set, action_for: action_name},
         success: function(res) {
 
           if(res.status=='1')
           {
             Swal.fire({
                     position: 'center',
                     icon: 'success',
                     title: '{{trans('words.status_changed')}}',
                     showConfirmButton: true,
                     confirmButtonColor: '#10c469',
                     background:"#1a2234",
                     color:"#fff"
                   })
              
           } 
           else
           { 
             Swal.fire({
                     position: 'center',
                     icon: 'error',
                     title: 'Something went wrong!',
                     showConfirmButton: true,
                     confirmButtonColor: '#10c469',
                     background:"#1a2234",
                     color:"#fff"
                   })
           }
           
         }
       });
 }); 
 
 </script> 

 <script type="text/javascript">
 
 $(".data_remove").click(function () {  
   
   var post_id = $(this).data("id");
   var action_name='livetv_cat_delete';
 
   Swal.fire({
     title: '{{trans('words.dlt_warning')}}',
   text: "{{trans('words.dlt_warning_text')}}",
   icon: 'warning',
   showCancelButton: true,
   confirmButtonColor: '#3085d6',
   cancelButtonColor: '#d33',
   confirmButtonText: '{{trans('words.dlt_confirm')}}',
   cancelButtonText: "{{trans('words.btn_cancel')}}",
   background:"#1a2234",
   color:"#fff"
 
 }).then((result) => {
 
   //alert(post_id);
 
   //alert(JSON.stringify(result));
 
     if(result.isConfirmed) { 
 
         $.ajax({
             type: 'post',
             url: "{{ URL::to('admin/ajax_delete') }}",
             dataType: 'json',
             data: {"_token": "{{ csrf_token() }}",id: post_id, action_for: action_name},
             success: function(res) {
 
               if(res.status=='1')
               {  
 
                   var selector = "#card_box_id_"+post_id;
                     $(selector ).fadeOut(1000);
                     setTimeout(function(){
                             $(selector ).remove()
                         }, 1000);
 
                   Swal.fire({
                     position: 'center',
                     icon: 'success',
                     title: '{{trans('words.deleted')}}!',
                     showConfirmButton: true,
                     confirmButtonColor: '#10c469',
                     background:"#1a2234",
                     color:"#fff"
                   })
                 
               } 
               else
               { 
                 Swal.fire({
                         position: 'center',
                         icon: 'error',
                         title: 'Something went wrong!',
                         showConfirmButton: true,
                         confirmButtonColor: '#10c469',
                         background:"#1a2234",
                         color:"#fff"
                        })
               }
               
             }
         });
     }
  
 })
 
 });
 
 </script>   

@endsection