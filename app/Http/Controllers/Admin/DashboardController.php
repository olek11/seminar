<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{
    public function index()
    {
        $data = array(
            $data = [
                "title"         => "Dashboard",
                "menuDashboard" => "active",
            ]
        );
        return view('admin.dashboard', $data);
    }
}
