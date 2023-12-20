@foreach($menuItems as $menuItem)
    @php
        //This function will take the route name and return the access permission.
        if( !isset($menuItem['routeName']) || $menuItem['routeName'] == '' || $menuItem['routeName'] == null){
            $check = false;
        }else{
            $check = check_access_by_route_name($menuItem['routeName']);
        }

        //Parameters
        $parameterArray = isset($menuItem['params']) ? $menuItem['params'] : [];
    @endphp
    @if ($check)
        <li @if ($pageSlug == $menuItem['pageSlug']) class="active" @endif>
            <a href="{{ route($menuItem['routeName'], $parameterArray) }}">
                <i class="{{ _($menuItem['iconClass'] ?? 'fa-solid fa-minus') }} @if ($pageSlug == $menuItem['pageSlug']) fa-beat-fade @endif"></i>
                <p>{{ _($menuItem['label']) }}</p>
            </a>
        </li>
    @endif
    {{-- For Main Menus  --}}
    @if(!isset($menuItem['routeName']) || $menuItem['routeName'] == '' || $menuItem['routeName'] == null)
        <li @if ($pageSlug == $menuItem['pageSlug']) class="active" @endif>
            <a href="javascript:void(0)">
                <i class="{{ _($menuItem['iconClass'] ?? 'fa-solid fa-minus') }} @if ($pageSlug == $menuItem['pageSlug']) fa-beat-fade @endif"></i>
                <p>{{ _($menuItem['label']) }}</p>
            </a>
        </li>
    @endif
@endforeach


