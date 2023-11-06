io
{{-- Matrix --}}

<div id="matrix_part" class="row question-box" @if(isset($display)) style="display:{{$display}};" @endif>

    <?php

        if(isset($question)) 

        {

            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);

            echo Form::color('color1', $question->color1 ? $question->color1 : $current_tests[0]->color1, ['class' => 'form-control ', 'name'=>'color1']);

            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);

            echo Form::color('color2', $question->color2 ? $question->color2 : $current_tests[0]->color2, ['class' => 'form-control ', 'name'=>'color2']);

        }

        else {

            echo Form::label('color1',trans('labels.backend.tests.fields.color1'), ['class' => 'control-label']);

            echo Form::color('color1', '', ['class' => 'form-control ', 'name'=>'color1']);

            echo Form::label('color2',trans('labels.backend.tests.fields.color2'), ['class' => 'control-label']);

            echo Form::color('color2', '', ['class' => 'form-control ', 'name'=>'color2']);

        }

    ?>

    

    <!-- Bilal Code -->

        

        <div class="col-12">

            <div class="row" >

                    <div class="col-6">

                        <select class="form-control input-small select2me selecttype" data-placeholder="Select..." >

                            <option value="text" >Single Input</option>

                            <!-- <option value="checkbox">Checkbox</option> -->

                            <option value="radio">Multiple Selection</option>

                            <!-- <option value="file">File</option> -->

                        </select>

                    </div>

                    <div class="col-6">

                        <select class="form-control input-small select2me selecttype" id="matrix_symbol" data-placeholder="Select..." >

                            <option value="€" >€</option>

                            <!-- <option value="checkbox">Checkbox</option> -->

                            <option value="Number">Number</option>

                            <!-- <option value="file">File</option> -->

                        </select>

                    </div>

                </div>

            </div>

        <div class="col-12">

            <div class="row">

                <div class="col-4">

                    <div>

                        <!-- {!! Form::label('qt_row', trans('labels.backend.questions.fields.qt_row').'*', ['class' => 'control-label']) !!}     -->

                    </div>              

                    <div>

                        <button id="row_add"

                        class="btn btn-success" style="color:white; margin-top:10px;" data-columns="0">+ Add Row</button>

                    </div>

                </div>

                <div class="col-4">

                    <div>

                    <!-- {!! Form::label('qt_col', trans('labels.backend.questions.fields.qt_col').'*', ['class' => 'control-label']) !!} -->

                    

                    </div>              

                    <div>

                        <button id="add_col"

                        class="btn btn-success" style="color:white; margin-top:10px;">+ Add Column</button>

                    </div>

                </div>

            </div>

        </div>

        @if(isset($question) && strpos($question->content,"table "))

                <?php 

                    $content = $question->content;

                    $content = str_replace('contenteditable="false"','contenteditable="true"',$content);

                    $content = str_replace('id=""','id="delete_matrix_row"',$content);

                    $content = str_replace('class="hide_btn"','class="btn btn-danger"',$content);

                    $content = str_replace('<th></th>','<th>Action</th>',$content);

                    echo html_entity_decode($content); 

                ?>

        @else

        <table id="add-matrix" name="matrix" data-id="[q_id]" class="ml-2 table table-striped">

            <thead id="symbol_matrix_value">

                

            </thead>

        </table>

        @endif



    <!-- End Here Bilal Code -->

    <!-- <div class="col-12">

        <div>

        {!! Form::label('qt_col', trans('labels.backend.questions.fields.qt_col').'*', ['class' => 'control-label']) !!}

        

        </div>              

        <!-- <div>

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

                <select class="form-control input-small select2me" data-placeholder="Select..." disabled>

                    <option value="single_input" >Single Input</option>

                    <option value="checkbox">Checkbox</option>

                    <option value="radiogroup">Radiogroup</option>

                    <option value="file">File</option>

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

                    <option value="single_input" >Single Input</option>

                    <option value="checkbox">Checkbox</option>

                    <option value="radiogroup">Radiogroup</option>

                    <option value="file">File</option>

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

                <select class="form-control input-small select2me" data-placeholder="Select..." >

                    <option value="single_input" >Single Input</option>

                    <option value="checkbox">Checkbox</option>

                    <option value="radiogroup">Radiogroup</option>

                    <option value="file">File</option>

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

                <select class="form-control input-small select2me" data-placeholder="Select..." >

                    <option value="single_input" >Single Input</option>

                    <option value="checkbox">Checkbox</option>

                    <option value="radiogroup">Radiogroup</option>

                    <option value="file">File</option>

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

        

    </div>  -->

</div>

{{-- End Matrix --}}