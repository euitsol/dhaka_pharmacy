<div class="dropdown">
    <a class="btn btn-sm btn-icon-only text-light" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        @foreach($menuItems as $menuItem)
        @php
            $parameterArray = isset($menuItem['params']) ? $menuItem['params'] : [];
            //This function will take the route name and return the access permission.
            if(!isset($menuItem['routeName']) || $menuItem['routeName'] == '' || $menuItem['routeName'] == null){
                $check = false;
            }elseif( $menuItem['routeName'] =='javascript:void(0)'){
                $check = true;
                $route = 'javascript:void(0)';
            }else{
                $check = check_access_by_route_name($menuItem['routeName']);
                $route = route($menuItem['routeName'], $parameterArray);
            }

            //Parameters
        @endphp
        @if ($check)
            <a class="dropdown-item @if(isset($menuItem['className'])) {{$menuItem['className']}} @endif @if(isset($menuItem['delete']) && $menuItem['delete'] == true) action-delete @endif" @if(isset($menuItem['delete']) && $menuItem['delete'] == true) onclick="return confirm('Are you sure?')" @endif href="{{$route}}" @if(isset($menuItem['data-id'])) data-id="{{$menuItem['data-id']}}" @endif>{{ _($menuItem['label']) }}</a>
        @endif

        @endforeach
    </div>
</div>
