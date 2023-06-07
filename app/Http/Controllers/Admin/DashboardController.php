<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
//use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\services;
use App\Models\Page;
use App\Models\Faq;
use App\Models\Lead;
use App\Models\color;
use App\Models\LaborModel;
use App\Models\termsandconditions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller  
{

    public function login()
    {
        return redirect('/admin/login');
    }


    public function index()
    {

        $categories = Category::count();
        //$blogs = Blog::count();
        $reviews = Testimonial::count();
        $services = services::count();
        $pages = termsandconditions::count();
        $faqs = Faq::count();
        $leads = Lead::count();
        $labors = LaborModel::count();
        $users = User::count();
        $viewData = array(
            'pageName' => 'Dashboard',
            'categories' => $categories,
            'users' => $users,
            'reviews' => $reviews,
            'services' => $services,
            'pages' => $pages,
            'faqs' => $faqs,
            'leads' => $leads,
            'labors' => $labors,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => 'active',
                    'url' => route('admin.dashboard')
                )
            )
        );
        return view('admin.dashboard')->with($viewData);
    }
}
