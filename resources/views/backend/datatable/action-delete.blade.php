
@if(isset($allow_delete) && ($allow_delete == false))


<a href="#"  class="btn btn-xs btn-danger delete_warning text-white mb-1" style="cursor:pointer;">
    <i class="fa fa-trash"
       data-toggle="tooltip"
       data-placement="top" title=""
       data-original-title="Warning"></i>
</a>
@else

    @if(isset($class))
        <a data-method="delete" data-trans-button-cancel="{{__('buttons.general.cancel')}}"
           data-trans-button-confirm="{{__('buttons.general.crud.delete')}}" data-trans-title="{{__('strings.backend.general.are_you_sure')}}"
           class="{{$class}}" style="cursor:pointer;"
           onclick="$(this).find('form').submit();">
            {{__('buttons.general.crud.delete')}}
            <form action="{{$route}}"
                  method="POST" name="delete_item" style="display:none">
                @csrf
                {{method_field('DELETE')}}
            </form>
        </a>
    @else
        <a data-method="delete" data-trans-button-cancel="{{__('buttons.general.cancel')}}"
           data-trans-button-confirm="{{__('buttons.general.crud.delete')}}" data-trans-title="{{__('strings.backend.general.are_you_sure')}}"
           class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;"
           onclick="$(this).find('form').submit();">
            <i class="fa fa-trash"
               data-toggle="tooltip"
               data-placement="top" title=""
               data-original-title="{{__('buttons.general.crud.delete')}}"></i>
            <form action="{{$route}}"
                  method="POST" name="delete_item" style="display:none">
                @csrf
                {{method_field('DELETE')}}
            </form>
        </a>
    @endif


@endif
