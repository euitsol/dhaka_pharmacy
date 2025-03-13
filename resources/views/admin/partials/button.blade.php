@php

    //This function will take the route name and return the access permission.
    if (!isset($routeName) || $routeName == '' || $routeName == null) {
        $check = false;
    } else {
        $check = check_access_by_route_name($routeName);
    }
    //Parameters
    $parameterArray = isset($params) ? $params : [];
@endphp

@if (isset($type) && $type == 'submit' && $check)
    <button type="submit" @if (isset($confirm) && !empty($confirm)) onclick="return confirm('{{ $confirm }}')" @endif
        class="btn btn-fill {{ $className }}">{{ __($label) }}</button>
@elseif($check)
    <a href="{{ is_valid_route($routeName) ? route($routeName, $parameterArray) : $routeName }}"
        class="btn btn-sm {{ $className }}">{{ _($label) }}</a>
@endif
