<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Website;
use Common;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->objModel = new Website();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $data = $this->objModel->getAll('', '', '', '', '');
        $totalFiltered = $this->objModel->getAll('', '', '');        
        $arrFile = array('name'=>'profile_photo','type'=>'image','resize'=>'150','path'=>'images/website/', 'predefine'=>'', 'except'=>'file_exist');
        return view('admin.user.dashboard',compact(['data','arrFile']));
    }
}
