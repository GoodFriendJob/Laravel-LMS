@extends('backend.layouts.app')
@section('title', __('labels.backend.testimonials.title').' | '.app_name())

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">@lang('labels.backend.questions.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.questions.fields.question')</th>
                            <td>{!! $question->question !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.questions.fields.question_image')</th>
                            <td>@if($question->question_image)<a
                                        href="{{ asset('storage/uploads/' . $question->question_image) }}"
                                        target="_blank"><img
                                            src="{{ asset('storage/uploads/' . $question->question_image) }}"
                                            height="50px"/></a>@endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.questions.fields.score')</th>
                            <td>{{ $question->score }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">

                <li role="presentation" class="nav-item">
                    <a href="#questionsoptions" class="nav-link active" aria-controls="questionsoptions" role="tab"
                       data-toggle="tab">Questions options</a>
                </li>
                <li role="presentation" class="nav-item">
                    <a href="#tests" class="nav-link" aria-controls="tests" role="tab" data-toggle="tab">Tests</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane container active" id="questionsoptions">
                    <table class="table table-bordered table-striped {{ count($questions_options) > 0 ? 'datatable' : '' }}">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.questions_options.fields.question')</th>
                            <th>@lang('labels.backend.questions_options.fields.option_text')</th>
                            <th>@lang('labels.backend.questions_options.fields.correct')</th>
                            @if( request('show_deleted') == 1 )
                                <th>@lang('labels.general.actions')</th>
                            @else
                                <th>@lang('labels.general.actions')</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        @if (count($questions_options) > 0)
                            @foreach ($questions_options as $questions_option)
                                <tr data-entry-id="{{ $questions_option->id }}">
                                    <td>{{ ($questions_option->question) ? $questions_option->question->question : '' }}</td>
                                    <td>{!! $questions_option->option_text !!}</td>
                                    <td>{{ Form::checkbox("correct", 1, $questions_option->correct == 1 ? true : false, ["disabled"]) }}</td>
                                    @if( request('show_deleted') == 1 )
                                        <td>

                                            <a data-method="delete" data-trans-button-cancel="Cancel"
                                               data-trans-button-confirm="Restore" data-trans-title="Are you sure?"
                                               class="btn btn-xs mb-2  btn-success" style="cursor:pointer;"
                                               onclick="$(this).find('form').submit();">
                                                {{trans('strings.backend.general.app_restore')}}
                                                <form action="{{route('admin.questions_options.restore',['questions_option'=> $questions_option->id ])}}"
                                                      method="POST" name="delete_item" style="display:none">
                                                    @csrf
                                                </form>
                                            </a>


                                            <a data-method="delete" data-trans-button-cancel="Cancel"
                                               data-trans-button-confirm="Delete" data-trans-title="Are you sure?"
                                               class="btn btn-xs mb-2 btn-danger" style="cursor:pointer;"
                                               onclick="$(this).find('form').submit();">
                                                {{trans('strings.backend.general.app_permadel')}}
                                                <form action="{{route('admin.questions_options.perma_del',['questions_option'=>$questions_option->id])}}"
                                                      method="POST" name="delete_item" style="display:none">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                </form>
                                            </a>

                                    @else
                                        <td>
                                            @can('questions_option_view')
                                                <a href="{{ route('admin.questions_options.show',[$questions_option->id]) }}"
                                                   class="btn btn-xs mb-2 btn-primary"><i class="icon-eye"></i></a>
                                            @endcan
                                            @can('questions_option_edit')
                                                <a href="{{ route('admin.questions_options.edit',[$questions_option->id]) }}"
                                                   class="btn btn-xs mb-2 btn-info"><i class="icon-pencil"></i></a>
                                            @endcan
                                            @can('questions_option_delete')

                                                <a data-method="delete" data-trans-button-cancel="Cancel"
                                                   data-trans-button-confirm="Delete" data-trans-title="Are you sure?"
                                                   class="btn btn-xs mb-2 btn-danger" style="cursor:pointer;"
                                                   onclick="$(this).find('form').submit();">
                                                    <i class="fa fa-trash"></i>
                                                    <form action="{{route('admin.questions_options.destroy',['questions_option'=> $questions_option->id])}}"
                                                          method="POST" name="delete_item" style="display:none">
                                                        @csrf
                                                        {{method_field('DELETE')}}
                                                    </form>
                                                </a>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">@lang('strings.backend.general.app_no_entries_in_table')</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane container" id="tests">
                    <table class="table table-bordered table-striped {{ count($tests) > 0 ? 'datatable' : '' }}">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.tests.fields.course')</th>
                            <th>@lang('labels.backend.tests.fields.lesson')</th>
                            <th>@lang('labels.backend.tests.fields.title')</th>
                            <th>@lang('labels.backend.tests.fields.questions')</th>
                            <th>@lang('labels.backend.tests.fields.published')</th>
                            @if( request('show_deleted') == 1 )
                                <th>@lang('labels.general.actions')</th>
                            @else
                                <th>@lang('labels.general.actions')</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        @if (count($tests) > 0)
                            @foreach ($tests as $test)
                                <tr data-entry-id="{{ $test->id }}">
                                    <td>{{ ($test->course) ? $test->course->title : '' }}</td>
                                    <td>{{ ($test->lesson) ? $test->lesson->title : '' }}</td>
                                    <td>{{ $test->title }}</td>
                                    <td>
                                        @foreach ($test->questions as $singleQuestions)
                                            <span class="label label-info label-many">{{ $singleQuestions->question }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ Form::checkbox("published", 1, $test->published == 1 ? true : false, ["disabled"]) }}</td>
                                    @if( request('show_deleted') == 1 )
                                        <td>

                                            <a data-method="delete" data-trans-button-cancel="Cancel"
                                               data-trans-button-confirm="Restore" data-trans-title="Are you sure?"
                                               class="btn btn-xs mb-2  btn-success" style="cursor:pointer;"
                                               onclick="$(this).find('form').submit();">
                                                {{trans('strings.backend.general.app_restore')}}
                                                <form action="{{route('admin.tests.restore',['test'=> $test->id ])}}"
                                                      method="POST" name="delete_item" style="display:none">
                                                    @csrf
                                                </form>
                                            </a>


                                            <a data-method="delete" data-trans-button-cancel="Cancel"
                                               data-trans-button-confirm="Delete" data-trans-title="Are you sure?"
                                               class="btn btn-xs mb-2 btn-danger" style="cursor:pointer;"
                                               onclick="$(this).find('form').submit();">
                                                {{trans('strings.backend.general.app_permadel')}}
                                                <form action="{{route('admin.tests.perma_del',['test'=>$test->id])}}"
                                                      method="POST" name="delete_item" style="display:none">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                </form>
                                            </a>

                                        </td>
                                    @else
                                        <td>
                                            @can('test_view')
                                                <a href="{{ route('admin.tests.show',[$test->id]) }}"
                                                   class="btn btn-xs mb-2 btn-primary">
                                                    <i class="icon-eye"></i>
                                                </a>
                                            @endcan
                                            @can('test_edit')
                                                <a href="{{ route('admin.tests.edit',[$test->id]) }}"
                                                   class="btn btn-xs mb-2 btn-info">
                                                    <i class="icon-pencil"></i>
                                                </a>
                                            @endcan
                                            @can('test_delete')

                                                    <a data-method="delete" data-trans-button-cancel="Cancel"
                                                       data-trans-button-confirm="Delete" data-trans-title="Are you sure?"
                                                       class="btn btn-xs mb-2 btn-danger" style="cursor:pointer;"
                                                       onclick="$(this).find('form').submit();">
                                                        <i class="fa fa-trash"></i>
                                                        <form action="{{route('admin.tests.destroy',['test'=> $test->id])}}"
                                                              method="POST" name="delete_item" style="display:none">
                                                            @csrf
                                                            {{method_field('DELETE')}}
                                                        </form>
                                                    </a>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">@lang('strings.backend.general.app_no_entries_in_table')</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('admin.questions.index') }}"
               class="btn btn-default border mt-3">@lang('strings.backend.general.app_back_to_list')</a>
        </div>
    </div>
@stop