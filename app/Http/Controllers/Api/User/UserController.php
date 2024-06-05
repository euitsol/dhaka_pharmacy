<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserController extends BaseController
{
    public function info(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            $userData = $user->only('id', 'name', 'email', 'is_verify');
            return sendResponse(true, 'User information retrived successfully', $userData);
        } else {
            return sendResponse(false, 'User is invalid', null);
        }
    }
}
