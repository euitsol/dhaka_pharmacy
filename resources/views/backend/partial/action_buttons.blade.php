
        
    <div class="buttons">
        @foreach($menuItems as $menuItem)
            @php
                //This function will take the route name and return the access permission.
                if(!isset($menuItem['routeName']) || $menuItem['routeName'] == '' || $menuItem['routeName'] == null || $menuItem['routeName'] =='javascript:void(0)'){
                    $check = false;
                }else{
                    $check = check_access_by_route_name($menuItem['routeName']);
                }

                //Parameters
                $parameterArray = isset($menuItem['params']) ? $menuItem['params'] : [];
            @endphp
            @if ($check)

            <a href="{{ route($menuItem['routeName'], $parameterArray) }}" 
                class="btn btn-sm 
                @if(isset($menuItem['className'])) {{$menuItem['className']}} @endif
                @if(isset($menuItem['btnClass'])) {{$menuItem['btnClass']}} @endif
                "
                title="@if(isset($menuItem['title'])) {{$menuItem['title']}} @endif"
                @if(isset($menuItem['delete']) && $menuItem['delete'] == true) onclick="return confirm('Are you sure?')" @endif
                ><i class="@if(isset($menuItem['iconClass'])) {{$menuItem['iconClass']}} @endif"></i></i>
            </a>
            @elseif($menuItem['routeName']=='javascript:void(0)')
            
                <a href="{{$menuItem['routeName']}}" 
                    class="btn btn-sm 
                    @if(isset($menuItem['className'])) {{$menuItem['className']}} @endif
                    @if(isset($menuItem['btnClass'])) {{$menuItem['btnClass']}} @endif
                    " data-id="{{$menuItem['params'][0]}}"
                    title="@if(isset($menuItem['title'])) {{$menuItem['title']}} @endif"
                    ><i class="@if(isset($menuItem['iconClass'])) {{$menuItem['iconClass']}} @endif"></i></i>
                </a>

            @endif

        @endforeach
    </div>

