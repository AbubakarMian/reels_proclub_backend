<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Product;
use App\Models\User;



class AdminController extends Controller
{
    function index()
    {
        return view('login.login');
    }


    function checklogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password'),
            // 'role_id' => 1
        );

        if(Auth::attempt($user_data))
        {
            session(['my_timezone' => $request->my_timezone]);
            return redirect('admin/dashboard');
        }
        // elseif()
        // {
        //     return back()->with('error', 'Wrong Login Details');
        // }

        else
        {
            return back()->with('error', 'Wrong Login Details');
        }

    }



    function logout()
    {
        Auth::logout();
        return redirect('admin/login');
    }


    function dashboard (){

        $admin_common = new \stdClass();
        $admin_dashboard = $this->admin_dashboard();

        $modules = $admin_dashboard['modules'];
        $reports = $admin_dashboard['reports'];
        $admin_common->id = '1';
        $admin_common->modules = $modules;
        $admin_common->reports = $reports;
        $admin_common->name = 'Admin';

        $chart = $admin_dashboard['chart'];

        session(['admin_common' => $admin_common]);
        return view('layouts.default_dashboard',compact(
            'chart'));
    }
    public function admin_dashboard()
    {
        $modules[] = [

            'url' => 'admin/users',
            'title' => 'Users ',

        ];
         $modules[]= [

            'url'=>'admin/aboutus/edit/1',
            'title'=>'About US'

        ];
        $modules[]= [

            'url'=>'admin/teacher',
            'title'=>'Teacher'

        ];
        $modules[]= [

            'url'=>'admin/category',
            'title'=>'Category'
        ];
        $modules[] = [

            'url' => 'admin/courses',
            'title' => 'Courses',

        ];
        $modules[]= [

            'url'=>'admin/group',
            'title'=>'Group'
        ];
        $modules[]= [

            'url'=>'admin/books',
            'title'=>'Books'
        ];


        $modules[] = [

            'url' => 'admin/question',
            'title' => 'Question ',

        ];
        $modules[]= [

            'url'=>'admin/quiz',
            'title'=>'Exams'

        ];

        // $modules[]= [

        //     'url'=>'admin/settings',
        //     'title'=>'Settings'

        // ];
        $modules[]= [

            'url'=>'admin/workshop',
            'title'=>'Workshop'
        ];
        $modules[] = [
            'url' => 'admin/contact',
            'title' => 'Contact Us',


        ];

        $modules[]= [

            'url'=>'admin/settings',
            'title'=>'Settings'

        ];

        $modules[]= [

            'url'=>'admin/role',
            'title'=>'Role'

        ];
        $modules[]= [

            'url'=>'admin/employee',
            'title'=>'Employee'

        ];

        $reports[] = [

            'url' => 'admin/course_register',
            'title' => 'Course Register ',

        ];
        // $reports[] = [

        //     'url' => 'admin/reports/permissions',
        //     'title' => 'Reports Permission ',

        // ];
        $reports[] = [
            'url' => 'admin/reports/payments',
            'title' => 'Payments',
        ];
        $reports[]= [
            'url'=>'admin/student_plan',
            'title'=>'Student Plan',
        ];

        $myvar = [];
        $myvar['modules'] = $modules;
        $myvar['reports'] = $reports ;
        $myvar['chart'] = [];

        return $myvar;
    }

}
