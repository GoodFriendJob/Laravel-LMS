@extends('backend.layouts.app')
@section('title', __('labels.backend.questions.title').' | '.app_name())

@section('content')
    <!-- {!! Form::open(['method' => 'POST', 'route' => ['admin.questions.store'], 'files' => true,]) !!} -->
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
    <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


<link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-toastr/toastr.min.css')}}"/>
<script src="{{asset('assets/metronic_assets/global/plugins/bootstrap-toastr/toastr.min.js')}}"></script>
<script src="{{asset('assets/metronic_assets/admin/pages/scripts/ui-toastr.js')}}"></script>

   <!-- {{-- <link rel="stylesheet" href="{{asset('css/jquery-toasts.css')}}">  
    <script type="text/javascript" src="{{asset('js/jquery-toasts.js')}}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script> --}} -->
    <style>
         #sortable-8{ list-style-type: none; margin: 0; 
            padding: 0; width: 25%; float:left;}
         #sortable-8 li{ margin: 0 3px 3px 3px; padding: 0.4em; 
            padding-left: 1.5em; font-size: 17px; height: 16px; }
         .default {
            background: #ccc;
            border: 1px solid #DDDDDD;
            color: #333333;
         }
       

    
      </style>
      
      <script>
         $(function() {
            $('#sortable-8').sortable({
               update: function(event, ui) {
                  var productOrder = $(this).sortable('toArray').toString();
                  $("#sortable-9").text (productOrder);

                    for (var i=1;i<= $("#sortable-8").children().length ; i++)
                    {
                        $("#sortable-8 li:nth-child("+i+")").find("span.no").text( i );
                    }
								
               }
            });
         });

         $(function() {
            $('#sortable-10').sortable({
               update: function(event, ui) {
								
               }
            });
         });

         $(function() {
            $('#sortable-11').sortable({
               update: function(event, ui) {
								
               }
            });
         });

     
         $(function() {
            $('#sortable-13').sortable({
               update: function(event, ui) {
								
               }
            });
         });

         $(function() {
            $('#sortable-14').sortable({
               update: function(event, ui) {
								
               }
            });
         });
         
      </script>

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Selection of Tests</h3>
            <div class="float-right">
                <a href="{{ route('admin.questions.index') }}"
                   class="btn btn-success">@lang('labels.backend.questions.view')</a>
            </div>            
         
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('tests', 'Test', ['class' => 'control-label']) !!}
                 <?php 
                  
                    $i=0;
                 ?>
                 
                     <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                        @foreach($tests as $test)
                            @if ($i ==0)
                                <option value="{{$test->id}}" selected>{{ $test->title}}</option>
                                 <?php
                                    $i++;
                                ?>
                            @else
                                <option value="{{$test->id}}">{{$test->title}}</option>
                               
                            @endif                           
                            
                        @endforeach      
                     
                    </select>
                     <p class="help-block"></p>
                    @if($errors->has('question'))
                        <p class="help-block">
                            {{ $errors->first('question') }}
                        </p>
                    @endif
                </div>
            </div>
 

        </div>
    </div>
{{-- 
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Question Order</h3>
            
        </div>
        <div class="card-body" >
            <div class="row">
                <div class="col-12 form-group" >
                    
                    <div class ="row">
                        <div class="col-6 col-lg-3 form-group">
                            {!! Form::label('question_page', trans('labels.backend.questions.fields.question_page').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('question_page', old('Question Page'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.questions.fields.question_page'), 'required' => '']) !!}
                        </div>
                        <div class="col-6 col-lg-3 form-group">
                            {!! Form::label('question_order', trans('labels.backend.questions.fields.question_order').'*', ['class' => 'control-label']) !!}
                            {!! Form::text('question_order', old('Question Order'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.questions.fields.question_order'), 'required' => '']) !!}
                        </div>
                    </div>
                    
                    <div class="portlet box blue" style="display:none">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-comments"></i>Question List
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body ">
							<div class="dd" id="nestable_list_1">
								<ol class="dd-list">
									<li class="dd-item" data-id="1">
										<div class="dd-handle">
											 question 1
										</div>
									</li>
									<li class="dd-item" data-id="2">
										<div class="dd-handle">
                                        question 2
										</div>
										<!-- <ol class="dd-list">
											<li class="dd-item" data-id="3">
												<div class="dd-handle">
													 Item 3
												</div>
											</li>
											<li class="dd-item" data-id="4">
												<div class="dd-handle">
													 Item 4
												</div>
											</li>
											<li class="dd-item" data-id="5">
												<div class="dd-handle">
													 Item 5
												</div>
												
											</li>
											<li class="dd-item" data-id="9">
												<div class="dd-handle">
													 Item 9
												</div>
											</li>
										
										</ol> -->
									</li>
									<li class="dd-item" data-id="11">
										<div class="dd-handle">
                                        question 11
										</div>
									</li>
									<li class="dd-item" data-id="12">
										<div class="dd-handle">
                                        question 12
										</div>
									</li>
								</ol>
							</div>
						</div>
					</div>

                    <ul id = "sortable-8" style="display:none">
                        <li id = "1" class = "default" display="inline-flex" style="height:25px;vertical-align:middle;padding-top:0px;">                           
                            <span class="no" style="margin-right:10px; background-color:#20c997;">1</span>
                            <span >question1</span>
                        </li>
                        <li id = "2" class = "default" display="inline-flex" style="height:25px;vertical-align:middle;padding-top:0px;">
                            <span class="no" style="margin-right:10px; background-color:#20c997;">2</span>
                            <span >question2</span>
                        </li>
                        <li id = "3" class = "default" display="inline-flex" style="height:25px;vertical-align:middle;padding-top:0px;">                           
                            <span class="no" style="margin-right:10px; background-color:#20c997;">3</span>
                            <span >question3</span>
                        </li>
                        <li id = "4" class = "default" display="inline-flex" style="height:25px;vertical-align:middle;padding-top:0px;">
                            <span class="no" style="margin-right:10px; background-color:#20c997;">4</span>
                            <span >question4</span>
                        </li>
                        <li id = "5" class = "default" display="inline-flex" style="height:25px;vertical-align:middle;padding-top:0px;">                           
                            <span class="no" style="margin-right:10px; background-color:#20c997;">5</span>
                            <span >question5</span>
                        </li>
                        <li id = "6" class = "default" display="inline-flex" style="height:25px;vertical-align:middle;padding-top:0px;">
                            <span class="no" style="margin-right:10px; background-color:#20c997;">6</span>
                            <span >question6</span>
                        </li>
                        <li id = "7" class = "default" display="inline-flex" style="height:25px;vertical-align:middle;padding-top:0px;">                           
                            <span class="no" style="margin-right:10px; background-color:#20c997;">7</span>
                            <span >question7</span>
                        </li>
                        <li id = "8" class = "default" display="inline-flex" style="height:25px;vertical-align:middle;padding-top:0px;">
                            <span class="no" style="margin-right:10px; background-color:#20c997;">8</span>
                            <span >question8</span>
                        </li>
              
                       
                    </ul>
                    <br>
                    <h3><span id = "sortable-9"></span></h3>

                    @if($errors->has('question'))
                        <p class="help-block">
                            {{ $errors->first('question') }}
                        </p>
                    @endif
                </div>
            </div>  

        </div>
    </div> --}}


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Question Edit</h3>
           
        </div>
        <div id="question_edit" class="card-body row">
            <div class="edit col-12" >
                <div class="row">
                    <div class="col-12 form-group">
                    <?php
                        //$question_type =['Single Input','Check Box','RadioGroup','Dropdown','Ranking','Image','Matrix'];
                        $question_type =['Single Input','Check Box','RadioGroup','Image','Matrix'];
                    ?>
                        {!! Form::label('question_type', trans('labels.backend.questions.fields.question_type'), ['class' => 'control-label']) !!}
                        {{-- {!! Form::select('question_type', $question_type,  (request('question_type')) ? request('question_type') : old('question_type'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'question_type']) !!} --}}
                        <select class="form-control" name="options" id="question_type" placeholder="Options">
                        @for($i=0 ;$i< count($question_type);$i++)   
                            <option value="{{$i}}">{{ $question_type[$i]}}</option>
                        @endfor
                        </select>
                        <p class="help-block"></p>

                        {!! Form::label('question', "Question", ['class' => 'control-label']) !!}
                        <input id="question_content" type="text"  class="form-control">

                        @if($errors->has('question'))
                            <p class="help-block">
                                {{ $errors->first('question') }}
                            </p>
                        @endif
                    </div>
                </div>

             

                <div class="row main-content" id="single_input_part" >
                    <div class="col-8 form-group">
                    {!! Form::label('qt_single_input', 'Single input'.'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('qt_single_input', old('qt_single_input'), ['class' => 'form-control ', 'rows' => 2, 'required' =>  true]) !!}

                    <label  class="control-label">Score</label>
                    <input  id="single_score" type="text"  class="form-control" value="">
                  

                          <p class="help-block"></p>
                        @if($errors->has('question'))
                            <p class="help-block">
                                {{ $errors->first('question') }}
                            </p>
                        @endif
                    </div>
                    <div class="col-4">
                        <div class="form-body">                                    
                            <div class="form-group ">
                                <!-- <label class="control-label col-md-3">Image Upload</label> -->
                                <div class="col-md-9" style="border:1px solid #bbbbbb">
                                    <form method="POST" enctype="multipart/form-data" class="image-upload-form" action="javascript:void(0)" >
                                    @csrf
                                        <div class="row">
                                            <label>Select Images</label>
                                            <div class="col-md-12 mb-2">
                                                <img class="display-image-preview" src=""
                                                    alt="" style="max-height: 150px;">
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="file" name="file[]" placeholder="Choose image"  accept="Image/*" class="file" multiple/>
                                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                                </div>
                                            </div>                                           
                                            
                                        </div>     
                                    </form>
                                </div>
                            </div>            
                        </div>

                    </div>


                </div>

                <div class="row main-content" style="borde:1px solid #00ff00;" id="checkbox_part">
                    <div class="col-12">
                        <a id="check_add"
                        class="btn btn-success" style="color:white; margin-top:10px;">+ New</a>
                    </div>
                    <div id="sortable-10" class="col-8 form-group">
                        <div  class="checkbox">
                            <label style="color:transparent"><input type="checkbox" >Option 1</label>  
                            <input class="check_label" type="text" value="Check1" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
                            <label  >Score</label>
                            <input  class="checkbox_score" type="text"  style="margin-right:1vw">
                            
                            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                <i class="fa fa-trash" style="color:white"></i>
                                <!-- <form action="#"
                                        method="POST" name="delete_item" style="display:none">
                                    @csrf
                                    {{method_field('DELETE')}}
                                </form> -->
                            </a>
                        </div>
                        <div class="checkbox">
                            <label  style="color:transparent"><input type="checkbox" value="">Option 1 </label>  
                            <input class="check_label" type="text" value="Check1" style="margin-left:-2vw;margin-right:5vw;z-index:20;border:none;">
                            <label  >Score</label>
                            <input  class="checkbox_score" type="text"  style="margin-right:1vw">
                        
                            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="12">
                                <i class="fa fa-trash" style="color:white"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-4">
                        <div class="form-body">                                    
                            <div class="form-group ">
                                <!-- <label class="control-label col-md-3">Image Upload</label> -->
                                <div class="col-md-9" style="border:1px solid #bbbbbb">
                                    <form method="POST" enctype="multipart/form-data" class="image-upload-form" action="javascript:void(0)" >
                                    @csrf
                                        <div class="row">
                                            <label>Select Images</label>
                                            <div class="col-md-12 mb-2">
                                                <img class="display-image-preview" src=""
                                                    alt="" style="max-height: 150px;">
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="file" name="file[]" placeholder="Choose image"  accept="Image/*" class="file" multiple/>
                                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                                </div>
                                            </div>                                           
                                            
                                            {{-- <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div> --}}
                                        </div>     
                                    </form>
                                </div>
                            </div>            
                        </div>

                    </div>
                </div>

                <div class="row" style="borde:1px solid #00ff00;" id="radio_part">
                    <div class="col-12">
                      <a id="radio_add" class="btn btn-success" style="color:white; margin-top:10px;">+ New</a>
                    </div>
                    <div class="col-8  form-group " id="sortable-11">
                    <!-- <form> -->
                        <div class="radio">
                            <label  style="color:transparent"><input type="radio" name="optradio" checked>Option 1</label>
                            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                            <label  >Score</label>
                            <input  class ="radio_score" type="text"   value="" style="margin-right:1vw">
                            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="41">
                                <i class="fa fa-trash" style="color:white"></i>
                            </a>
                        </div>
                        <div class="radio">
                            <label  style="color:transparent"><input type="radio" name="optradio" >Option 2</label>
                            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                            <label  >Score</label>
                            <input  class ="radio_score" type="text"   value="" style="margin-right:1vw">
                            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="42">
                                <i class="fa fa-trash" style="color:white"></i>
                            </a>
                        </div>
                        <div class="radio">
                            <label  style="color:transparent"><input type="radio" name="optradio" >Option 2</label>
                            <input class="radio_label" type="text" value="radio1" style="margin-left:-2vw;;margin-right:5vw;z-index:20;border:none;">
                            <label  >Score</label>
                            <input   class ="radio_score"  type="text"   value="" style="margin-right:1vw">
                            <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="43">
                                <i class="fa fa-trash" style="color:white"></i>
                            </a>
                        </div>
                    </div>
         
                    <div class="col-4">
                        <div class="form-body">                                    
                            <div class="form-group ">
                                <!-- <label class="control-label col-md-3">Image Upload</label> -->
                                <div class="col-md-9" style="border:1px solid #bbbbbb">
                                    <form method="POST" enctype="multipart/form-data" class="image-upload-form" action="javascript:void(0)" >
                                    @csrf
                                        <div class="row">
                                            <label>Select Images</label>
                                            <div class="col-md-12 mb-2">
                                                <img class="display-image-preview" src=""
                                                    alt="" style="max-height: 150px;">
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="file" name="file[]" placeholder="Choose image"  accept="Image/*" class="file" multiple/>
                                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                                </div>
                                            </div>                                           
                                            
                                            {{-- <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div> --}}
                                        </div>     
                                    </form>
                                </div>
                            </div>            
                        </div>

                    </div>
                </div>
                
                <div class="row main-content" id="image_part" >
                    <div class="col-md-12 form-body">                                    
                        <div class="form-group ">
                            <!-- <label class="control-label col-md-3">Image Upload</label> -->
                            <div class="col-md-9">
                                <form method="POST" enctype="multipart/form-data" class="image-upload-form" action="javascript:void(0)" id="sortable-13">
                                    @csrf
                                    <div class="form-group " id="sortable-11">
                                        <div class="input-group hdtuto control-group lst increment" >
                                            <input type="file" name="file[]" class="myfrm form-control">
                                            <div class="input-group-btn"> 
                                                <button class="btn btn-success add-btn" type="button">+</button>
                                            </div>
                                            <label  style="margin-left:5vw;margin-right:1vw;">Score</label>
                                            <input  class="image_score" type="text"   value="" style="margin-right:1vw">
                                        </div>
                                        <div class="clone">
                                            <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                                <input type="file" name="file[]" class="myfrm form-control">
                                                <div class="input-group-btn"> 
                                                <button class="btn btn-danger del-btn" type="button"><i class="fa fa-trash" style="color:white"></i></button>
                                                </div>
                                                <label  style="margin-left:5vw;margin-right:1vw;">Score</label>
                                                <input  class="image_score" type="text"   value="" style="margin-right:1vw">
                                            </div>                                    
                                        </div>
                                    </div>
                                    
                            
                                {{-- <button type="submit" class="btn btn-success" style="margin-top:10px">Submit</button>     --}}
                                </form>
                            </div>
                        </div>            
                    </div>
   
             
                </div>               

                <div class="row main-content" id="matrix_part">
               
                    <div class="col-12">
                        <div>
                        {!! Form::label('qt_col', trans('labels.backend.questions.fields.qt_col').'*', ['class' => 'control-label']) !!}
                        
                        </div>              
                        <div>
                            <a id="col_add"
                            class="btn btn-success" style="color:white; margin-top:10px;">+ Add Column</a>
                        </div>
                    </div>
                    <div id="col_panel" class="col-12 " style="padding-top:10px;">
                        <div class="row" >
                            <div class="col-2">
                                <label>Cell Type</label>  
                            </div>
                            <div class="col-2">
                                <label>Name</label>                             
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-2">
                                <select class="form-control input-small select2me" data-placeholder="Select..."  disabled>
                                    <option >Single Input</option>
                                    <option >Checkbox</option>
                                    <option >Radiogroup</option>
                                    <option >Imagepicker</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <input type="text" value="Input" style="z-index:20;"  class="form-control">
                                
                            </div>
                            <div class="col-2">
                                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                    <i class="fa fa-trash" style="color:white"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row" style="padding-top:0.5vh;">
                            <div class="col-2">
                                <select class="form-control input-small select2me" data-placeholder="Select..."  disabled>
                                    <option >Single Input</option>
                                    <option >Checkbox</option>
                                    <option >Radiogroup</option>
                                    <option >Imagepicker</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <input type="text" value="Input" style="z-index:20;"  class="form-control">
                                
                            </div>
                            <div class="col-2">
                                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                    <i class="fa fa-trash" style="color:white"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div>
                            {!! Form::label('qt_row', trans('labels.backend.questions.fields.qt_row').'*', ['class' => 'control-label']) !!}    
                        </div>              
                        <div>
                            <a id="row_add"
                            class="btn btn-success" style="color:white; margin-top:10px;">+ Add Row</a>
                        </div>
                    </div>
                    <div id= "row_panel" class="col-12" style="padding-top:10px;">
                        <div class="row" >
                            <div class="col-2">
                                <label>Cell Type</label>  
                            </div>
                            <div class="col-2">
                                <label>Name</label>                             
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-2">
                                <select class="form-control input-small select2me" data-placeholder="Select..."  disabled>
                                    <option >Single Input</option>
                                    <option >Checkbox</option>
                                    <option >Radiogroup</option>
                                    <option >Imagepicker</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <input type="text" value="Input" style="z-index:20;"  class="form-control">
                                
                            </div>
                            <div class="col-2">
                                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                    <i class="fa fa-trash" style="color:white"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row" style="padding-top:0.5vh;">
                            <div class="col-2"> 
                                <select class="form-control input-small select2me" data-placeholder="Select..." disabled>
                                    <option >Single Input</option>
                                    <option >Checkbox</option>
                                    <option >Radiogroup</option>
                                    <option >Imagepicker</option>
                                </select>   
                            </div>
                            <div class="col-2">
                                <input type="text" value="Input" style="z-index:20;"  class="form-control">
                                
                            </div>
                            <div class="col-2">
                                <a class="btn btn-xs mb-2 btn-danger del-btnx" style="cursor:pointer;" data-id="11">
                                    <i class="fa fa-trash" style="color:white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button id="mat_update" type="button" class="btn-danger">Update</button>
                    </div>
                    
                    <div class="col-12" style="padding-top:3vh;">
                        {!! Form::label('value', 'value', ['class' => 'control-label']) !!}
                        <table  id="real_matrix" width="100%">
                        </table>
                        
                        {!! Form::label('score', 'Score', ['class' => 'control-label']) !!}
                        <table  id="score_matrix" width="100%" stylr="padding-top:2vh;">
                        </table>
                        
                    </div> 
                </div>
            </div>     
        </div>        
            

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Logic</h3>
          
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-9 form-group">                    
                    <div>                        

                        <div class="logic_part" style="border:1px solid #bbbbbb;padding:10px;">
                            <a id="logic_open" class="btn btn-primary" style="color:white; margin-top:10px;">Logic Start</a>
                           
                            {{--  <a id="condition_add" class="btn btn-success" style="color:white; margin-top:10px;" >Add Condition</a>  --}}
                            <div id="sortable-14">
                                    <div class="logic_condition row clone_condition" style="padding-top:10px;">
                                        <div class="col-3">
                                            <select class="form-control first_operator" name="first_operator" placeholder="Options">
                                                <option value="0">And</option>
                                                <option value="1">Or</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <?php
                                                $last_test_id=""; $i=0; 
                                            ?>
                                             <input type="text" class="qt_name form-control" >
                     
                                            <div class="tree_1 tree-demo" display="none">
                                                <ul class="treecontent">
                                                    @for ($i=0;$i<count($course_list);$i++)
                                                    <li>                  
                                                    {{ $course_list[$i]['title'] }} </a>
                                                        <ul>
                                                            @for ($j=0;$j<count($course_test_list[$i]);$j++)
                                                                <li>
                                                                    {{ $course_test_list[$i][$j]['title']}}
                                                                    <ul>
                                                                        <?php
                                                                            $tk=  $course_test_list[$i][$j]['id'];
                                                                        ?>
                                                                        @if(isset($question_list[$tk]))
                                                                            @for ($k=0;$k<count($question_list[$tk]);$k++)
                                                                                <li>
                                                                                    {{ $question_list[$tk][$k]['id'] }}.{{ $question_list[$tk][$k]['question'] }}
                                                                                </li>
                                                                            @endfor
                                                                        @endif
                                                                    </ul>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </li>                                     
                                                    @endfor
                                                </ul>                   
                                            </div>
                                        </div>
                                        <input class="qt_type" type="hidden" value="">
                                        <div class="col-5">                                    
                                             <select class="form-control operators" name="operators" placeholder="Options">
                                                <?php
                                                    $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
                                                ?>
                                                @for($i=0;$i<count($operators);$i++)
                                                    <option value="{{ $i }}">{{ $operators[$i] }}</option>
                                                @endfor                                       
                                            </select>
                                        </div>
                                        <div class="col-12 logic-content" style="padding-top:10px">

                                        </div>
                                        <div class="col-12" style="padding-top:10px;">                                            
                                            <a class="btn btn-xs  btn-danger del-btnx" style="cursor:pointer;"><i class="fa fa-trash" style="color:white"></i></a>
                                        </div>
                                   
                                
                                </div>


                                <div class="logic_condition row clone_condition" style="padding-top:10px;">
                                        <div class="col-3">
                                            <select class="form-control first_operator" name="first_operator" placeholder="Options">
                                                <option value="0">And</option>
                                                <option value="1">Or</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <?php
                                                $last_test_id=""; $i=0;
                                            ?>
                                             <input type="text" class="qt_name form-control" >
                     
                                            <div class="tree_1 tree-demo" display="none">
                                                <ul class="treecontent">
                                                    @for ($i=0;$i<count($course_list);$i++)
                                                    <li>                  
                                                    {{ $course_list[$i]['title'] }} </a>
                                                        <ul>
                                                            @for ($j=0;$j<count($course_test_list[$i]);$j++)
                                                                <li>
                                                                    {{ $course_test_list[$i][$j]['title']}}
                                                                    <ul>
                                                                        <?php
                                                                            $tk=  $course_test_list[$i][$j]['id'];
                                                                        ?>
                                                                        @if(isset($question_list[$tk]))
                                                                            @for ($k=0;$k<count($question_list[$tk]);$k++)
                                                                                <li>
                                                                                    {{ $question_list[$tk][$k]['id'] }}.{{ $question_list[$tk][$k]['question'] }}
                                                                                </li>
                                                                            @endfor
                                                                        @endif
                                                                    </ul>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </li>                                     
                                                    @endfor
                                                </ul>                   
                                            </div>
                                        </div>
                                        <input class="qt_type" type="hidden" value="">
                                        <div class="col-5">                                    
                                             <select class="form-control operators" name="operators" placeholder="Options">
                                                <?php
                                                    $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
                                                ?>
                                                @for($i=0;$i<count($operators);$i++)
                                                    <option value="{{ $i }}">{{ $operators[$i] }}</option>
                                                @endfor                                       
                                            </select>
                                        </div>
                                        <div class="col-12 logic-content" style="padding-top:10px">

                                        </div>
                                        <div class="col-12" style="padding-top:10px;">                                            
                                            <a class="btn btn-xs  btn-danger del-btnx" style="cursor:pointer;"><i class="fa fa-trash" style="color:white"></i></a>
                                        </div>
                                   
                                
                                </div>

                                 <div class="logic_condition row clone_condition" style="padding-top:10px;">
                                        <div class="col-3">
                                            <select class="form-control first_operator" name="first_operator" placeholder="Options">
                                                <option value="0">And</option>
                                                <option value="1">Or</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <?php
                                                $last_test_id=""; $i=0; );
                                            ?>
                                             <input type="text" class="qt_name form-control" >
                     
                                            <div class="tree_1 tree-demo">
                                                <ul class="treecontent">
                                                    @for ($i=0;$i<count($course_list);$i++)
                                                    <li>                  
                                                    {{ $course_list[$i]['title'] }} </a>
                                                        <ul>
                                                            @for ($j=0;$j<count($course_test_list[$i]);$j++)
                                                                <li>
                                                                    {{ $course_test_list[$i][$j]['title']}}
                                                                    <ul>
                                                                        <?php
                                                                            $tk=  $course_test_list[$i][$j]['id'];
                                                                        ?>
                                                                        @if(isset($question_list[$tk]))
                                                                            @for ($k=0;$k<count($question_list[$tk]);$k++)
                                                                                <li>
                                                                                   {{ $question_list[$tk][$k]['id'] }}.{{ $question_list[$tk][$k]['question'] }}
                                                                                </li>
                                                                            @endfor
                                                                        @endif
                                                                    </ul>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </li>                                     
                                                    @endfor
                                                </ul>                   
                                            </div>
                                        </div>
                                        <input class="qt_type" type="hidden" value="">
                                        <div class="col-5">                                    
                                             <select class="form-control operators" name="operators" placeholder="Options">
                                                <?php
                                                    $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
                                                ?>
                                                @for($i=0;$i<count($operators);$i++)
                                                    <option value="{{ $i }}">{{ $operators[$i] }}</option>
                                                @endfor                                       
                                            </select>
                                        </div>
                                        <div class="col-12 logic-content" style="padding-top:10px">

                                        </div>
                                        <div class="col-12" style="padding-top:10px;">                                            
                                            <a class="btn btn-xs  btn-danger del-btnx" style="cursor:pointer;"><i class="fa fa-trash" style="color:white"></i></a>
                                        </div>
                                   
                                
                                </div>

                                <div class="logic_condition row clone_condition" style="padding-top:10px;">
                                        <div class="col-3">
                                            <select class="form-control first_operator" name="first_operator" placeholder="Options">
                                                <option value="0">And</option>
                                                <option value="1">Or</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <?php
                                                $last_test_id=""; $i=0; 
                                            ?>
                                             <input type="text" class="qt_name form-control" >
                     
                                            <div class="tree_1 tree-demo">
                                                <ul class="treecontent">
                                                    @for ($i=0;$i<count($course_list);$i++)
                                                    <li>                  
                                                    {{ $course_list[$i]['title'] }} </a>
                                                        <ul>
                                                            @for ($j=0;$j<count($course_test_list[$i]);$j++)
                                                                <li>
                                                                    {{ $course_test_list[$i][$j]['title']}}
                                                                    <ul>
                                                                        <?php
                                                                            $tk=  $course_test_list[$i][$j]['id'];
                                                                        ?>
                                                                        @if(isset($question_list[$tk]))
                                                                            @for ($k=0;$k<count($question_list[$tk]);$k++)
                                                                                <li>
                                                                                   {{ $question_list[$tk][$k]['id'] }}.{{ $question_list[$tk][$k]['question'] }}
                                                                                </li>
                                                                            @endfor
                                                                        @endif
                                                                    </ul>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </li>                                     
                                                    @endfor
                                                </ul>                   
                                            </div>
                                        </div>
                                        <input class="qt_type" type="hidden" value="">
                                        <div class="col-5">                                    
                                             <select class="form-control operators" name="operators" placeholder="Options">
                                                <?php
                                                    $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
                                                ?>
                                                @for($i=0;$i<count($operators);$i++)
                                                    <option value="{{ $i }}">{{ $operators[$i] }}</option>
                                                @endfor                                       
                                            </select>
                                        </div>
                                        <div class="col-12 logic-content" style="padding-top:10px">

                                        </div>
                                        <div class="col-12" style="padding-top:10px;">                                            
                                            <a class="btn btn-xs  btn-danger del-btnx" style="cursor:pointer;"><i class="fa fa-trash" style="color:white"></i></a>
                                        </div>
                                   
                                
                                </div>

                                <div class="logic_condition row clone_condition" style="padding-top:10px;">
                                        <div class="col-3">
                                            <select class="form-control first_operator" name="first_operator" placeholder="Options">
                                                <option value="0">And</option>
                                                <option value="1">Or</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <?php
                                                $last_test_id=""; $i=0;
                                            ?>
                                             <input type="text" class="qt_name form-control" >
                     
                                            <div class="tree_1 tree-demo">
                                                <ul class="treecontent">
                                                    @for ($i=0;$i<count($course_list);$i++)
                                                    <li>                  
                                                    {{ $course_list[$i]['title'] }} </a>
                                                        <ul>
                                                            @for ($j=0;$j<count($course_test_list[$i]);$j++)
                                                                <li>
                                                                    {{ $course_test_list[$i][$j]['title']}}
                                                                    <ul>
                                                                        <?php
                                                                            $tk=  $course_test_list[$i][$j]['id'];
                                                                        ?>
                                                                        @if(isset($question_list[$tk]))
                                                                            @for ($k=0;$k<count($question_list[$tk]);$k++)
                                                                                <li>
                                                                                    {{ $question_list[$tk][$k]['id'] }}.{{ $question_list[$tk][$k]['question'] }}
                                                                                </li>
                                                                            @endfor
                                                                        @endif
                                                                    </ul>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </li>                                     
                                                    @endfor
                                                </ul>                   
                                            </div>
                                        </div>
                                        <input class="qt_type" type="hidden" value="">
                                        <div class="col-5">                                    
                                             <select class="form-control operators" name="operators" placeholder="Options">
                                                <?php
                                                    $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
                                                ?>
                                                @for($i=0;$i<count($operators);$i++)
                                                    <option value="{{ $i }}">{{ $operators[$i] }}</option>
                                                @endfor                                       
                                            </select>
                                        </div>
                                        <div class="col-12 logic-content" style="padding-top:10px">

                                        </div>
                                        <div class="col-12" style="padding-top:10px;">                                            
                                            <a class="btn btn-xs  btn-danger del-btnx" style="cursor:pointer;"><i class="fa fa-trash" style="color:white"></i></a>
                                        </div>
                                   
                                
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    <div id="example_panel" class="col-12 form-group">

                    </div>
                        @if($errors->has('question'))
                            <p class="help-block">
                                {{ $errors->first('question') }}
                            </p>
                        @endif
                </div>
                <div class="property col-3" style="padding-bottom:10px;">
                
                    <div class="row" style="background-color:#eeeeee;padding:1vw;">
                        <div class="col-12">
                            <h2> Properties</h2>
                        </div>
                        <div class="col-12">
                           
                            {!! Form::label('width', 'Width', ['class' => 'control-label']) !!}
                            <input type="text" name="width" id="width" placeholder="" class="form-control" />
                
                            {!! Form::label('indent', 'Indent', ['class' => 'control-label']) !!}
                            <input type="text" name="indent" id="indent" placeholder="" class="form-control" />
                            {!! Form::label('font_size', 'Font size', ['class' => 'control-label']) !!}
                            <input type="text" name="font_size" id="font_size" placeholder="" class="form-control" />
                     
                            {{-- {!! Form::label('title_location', 'Title location', ['class' => 'control-label']) !!}
                            <select class="form-control" name="options" id="title_location" placeholder="Options">
                                <option value="1">top</option>
                                <option value="2">buttom</option>
                                <option value="3">left</option>
                                <option value="4">hidden</option>  
                            </select> --}}
                
                            {{-- {!! Form::label('column_count', 'Column Count', ['class' => 'control-label']) !!}
                            <input type="text" name="column_count" id="column_count" placeholder="" class="form-control" /> --}}
                            {!! Form::label('imagefit', 'Image Fit', ['class' => 'control-label']) !!}  
                            <select class="form-control" name="options" id="image_fit" placeholder="Options">
                                <option value="0">none</option>
                                <option value="1">contain</option>
                                <option value="2">cover</option>
                                <option value="3">fill</option>  
                            </select>
                            
                            {!! Form::label('image_width', 'Image Width', ['class' => 'control-label']) !!}
                            <input type="text" name="image_width" id="image_width" placeholder="" class="form-control" />
                            {!! Form::label('image_height', 'Image Height', ['class' => 'control-label']) !!}
                            <input type="text" name="image_height" id="image_height" placeholder="" class="form-control" />                     
                        </div>    
                        
                    </div>
                </div>
            </div>
              <div class="float-right">
                
                <a id="save_data"
                   class="btn btn-success" style="color:white">Save Data</a>
            </div>
       
        </div>
    </div>

    

    <!-- @for ($question=1; $question<=2; $question++)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('option_text_' . $question, trans('labels.backend.questions.fields.option_text').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('option_text_' . $question, old('option_text'), ['class' => 'form-control ', 'rows' => 3, 'required' =>  true]) !!}
                    <p class="help-block"></p>
                    @if($errors->has('option_text_' . $question))
                        <p class="help-block">
                            {{ $errors->first('option_text_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('explanation_' . $question, trans('labels.backend.questions.fields.option_explanation'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('explanation_' . $question, old('explanation_'.$question), ['class' => 'form-control ', 'rows' => 3]) !!}
                    <p class="help-block"></p>
                    @if($errors->has('explanation_' . $question))
                        <p class="help-block">
                            {{ $errors->first('explanation_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('correct_' . $question, trans('labels.backend.questions.fields.correct'), ['class' => 'control-label']) !!}
                    {!! Form::hidden('correct_' . $question, 0) !!}
                    {!! Form::checkbox('correct_' . $question, 1, false, []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('correct_' . $question))
                        <p class="help-block">
                            {{ $errors->first('correct_' . $question) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endfor
    <div class="col-12 text-center">
        {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-danger mb-4 form-group']) !!}
    </div>

    {!! Form::close() !!} -->

    
    <script type="text/javascript" src="{{asset('js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/main.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/ui-nestable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.nestable.js')}}"></script>

    <!-- <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script> -->
    <script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dataTables.bootstrap.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('js/table-editable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/question-create.js')}}"></script>

    <script src="{{ asset('assets/metronic_assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>


    <script type="text/javascript" src="{{asset('js/3.5.1/jquery.min.js')}}"></script>

    {{-- <link href="{{asset('css/custom.css')}}"  rel="stylesheet" type="text/css"/> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}"/>   
    <script type="text/javascript" src="{{asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}"></script>

    
    <script>
      

        jQuery(document).ready(function(e) {       
            // initiate layout and plugins
            // Metronic.init(); // init metronic core components
            // Layout.init(); // init current layout
            // QuickSidebar.init(); // init quick sidebar
            // Demo.init(); // init demo features
            UITree.init();  
            UINestable.init();
            TableEditable.init();
            QuestionCreate.init();  
              UIToastr.init();
                               
          

            
        });
    </script>








    
@stop

