<?php

use Illuminate\Support\Facades\Route;
//Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoriesController;
use App\Http\Controllers\Admin\menuController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\EditorUploadsController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\DownloadsController;
use App\Http\Controllers\Admin\CkController;
use App\Http\Controllers\Admin\invoiceController;
use App\Http\Controllers\Admin\LaborController;
use App\Http\Controllers\Admin\ourservicesController;
use App\Http\Controllers\TermsandconditionsController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\SearchLaborController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\Admin\PaymentApproval;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function(){
// echo "<h1>Rabia Store</h1>";
// });

Route::get('/', [DashboardController::class, 'login']);


Route::group(['namespace' => 'Admin', 'prefix' => 'admin/', 'middleware' => 'auth'], function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

  // Account  // USER
  Route::get('/account/{id}', [UserController::class, 'edit'])->name('admin.account');
  Route::post('/account/{id}', [UserController::class, 'update'])->name('admin.account.update');

  Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
  Route::post('/users/tabledata', [UserController::class, 'tabledata'])->name('admin.users.tabledata');
  Route::get('/users/add-new-user', [UserController::class, 'create'])->name('admin.users.create');
  Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
  Route::post('/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
  Route::get('/users/edit-user/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
  Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
  Route::get('/users/check-number', [UserController::class, 'checkNumber'])->name('users.checknumber');

  // Category
  Route::get('/category', [CategoryController::class, 'index'])->name('admin.category.index');
  Route::post('/category/tabledata', [CategoryController::class, 'tabledata'])->name('admin.category.tabledata');
  Route::get('/category/add-new-category', [CategoryController::class, 'create'])->name('admin.category.create');
  Route::get('/category/update-category/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
  Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
  Route::post('/category/update-category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
  Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

  // Subcategories
  Route::get('/Subcategories', [SubcategoriesController::class, 'index'])->name('admin.Subcategories.index');
  Route::post('/Subcategories/tabledata', [SubcategoriesController::class, 'tabledata'])->name('admin.Subcategories.tabledata');
  Route::get('/Subcategories/add-new-Subcategories', [SubcategoriesController::class, 'create'])->name('admin.Subcategories.create');
  Route::get('/Subcategories/update-Subcategories/{id}', [SubcategoriesController::class, 'edit'])->name('admin.Subcategories.edit');
  Route::post('/Subcategories/store', [SubcategoriesController::class, 'store'])->name('admin.Subcategories.store');
  Route::post('/Subcategories/update-Subcategories/{id}', [SubcategoriesController::class, 'update'])->name('admin.Subcategories.update');
  Route::delete('/Subcategories/delete/{id}', [SubcategoriesController::class, 'destroy'])->name('admin.Subcategories.destroy');

  // Menu
  Route::get('/menu', [menuController::class, 'index'])->name('admin.menu.index');
  Route::post('/menu/tabledata', [menuController::class, 'tabledata'])->name('admin.menu.tabledata');
  Route::get('/menu/add-new-menu', [menuController::class, 'create'])->name('admin.menu.create');
  Route::get('/menu/update-menu/{id}', [menuController::class, 'edit'])->name('admin.menu.edit');
  Route::post('/menu/store', [menuController::class, 'store'])->name('admin.menu.store');
  Route::post('/menu/update-menu/{id}', [menuController::class, 'update'])->name('admin.menu.update');
  Route::delete('/menu/delete/{id}', [menuController::class, 'destroy'])->name('admin.menu.destroy');

  // Section
  Route::get('/section', [SectionController::class, 'index'])->name('admin.section.index');
  Route::post('/section/tabledata', [SectionController::class, 'tabledata'])->name('admin.section.tabledata');
  Route::get('/section/update-section/{id}', [SectionController::class, 'edit'])->name('admin.section.edit');
  Route::post('/section/store', [SectionController::class, 'store'])->name('admin.section.store');
  Route::post('/section/update-section/{id}', [SectionController::class, 'update'])->name('admin.section.update');

  // Service
  Route::get('/service', [ServiceController::class, 'index'])->name('admin.service.index');
  Route::post('/service/tabledata', [ServiceController::class, 'tabledata'])->name('admin.service.tabledata');
  Route::get('/service/add-service', [ServiceController::class, 'create'])->name('admin.service.create');
  Route::post('/service/store', [ServiceController::class, 'store'])->name('admin.service.store');
  Route::get('/service/update-service/{id}', [ServiceController::class, 'edit'])->name('admin.service.edit');
  Route::post('/service/update-service/{id}', [ServiceController::class, 'update'])->name('admin.service.update');
  Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('admin.service.destroy');


  Route::get('/service', [ServiceController::class, 'index'])->name('admin.service.index');
  Route::post('/service/tabledata', [ServiceController::class, 'tabledata'])->name('admin.service.tabledata');
  Route::get('/service/add-service', [ServiceController::class, 'create'])->name('admin.service.create');
  Route::post('/service/store', [ServiceController::class, 'store'])->name('admin.service.store');
  Route::get('/service/update-service/{id}', [ServiceController::class, 'edit'])->name('admin.service.edit');
  Route::post('/service/update-service/{id}', [ServiceController::class, 'update'])->name('admin.service.update');
  Route::delete('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('admin.service.destroy');

  // Portfolio
  Route::get('/portfolio', [PortfolioController::class, 'index'])->name('admin.portfolio.index');
  Route::post('/portfolio/tabledata', [PortfolioController::class, 'tabledata'])->name('admin.portfolio.tabledata');
  Route::get('/portfolio/add-new-portfolio/{portfolio?}', [PortfolioController::class, 'create'])->name('admin.portfolio.create');
  Route::get('/portfolio/update-portfolio/{id}', [PortfolioController::class, 'edit'])->name('admin.portfolio.edit');
  Route::post('/portfolio/store', [PortfolioController::class, 'store'])->name('admin.portfolio.store');
  Route::post('/portfolio/update-portfolio/{id}', [PortfolioController::class, 'update'])->name('admin.portfolio.update');
  Route::delete('/portfolio/delete/{id}', [PortfolioController::class, 'destroy'])->name('admin.portfolio.destroy');
  Route::get('/portfolio/removeimage/{id}/{slug}', [PortfolioController::class, 'removeimage'])->name('admin.portfolio.removeimage');

  // Faq
  Route::get('/faq', [FaqController::class, 'index'])->name('admin.faq.index');
  Route::post('/faq/tabledata', [FaqController::class, 'tabledata'])->name('admin.faq.tabledata');
  Route::get('/faq/add-new-faq', [FaqController::class, 'create'])->name('admin.faq.create');
  Route::get('/faq/update-faq/{id}', [FaqController::class, 'edit'])->name('admin.faq.edit');
  Route::post('/faq/store', [FaqController::class, 'store'])->name('admin.faq.store');
  Route::post('/faq/update-faq/{id}', [FaqController::class, 'update'])->name('admin.faq.update');
  Route::delete('/faq/delete/{id}', [FaqController::class, 'destroy'])->name('admin.faq.destroy');

  // download
  Route::get('/download', [DownloadsController::class, 'index'])->name('admin.download.index');
  Route::get('/download/add-new-download', [DownloadsController::class, 'create'])->name('admin.download.create');
  Route::get('/download/update-download/{id}', [DownloadsController::class, 'edit'])->name('admin.download.edit');
  Route::post('/download/store', [DownloadsController::class, 'store'])->name('admin.download.store');
  Route::post('/download/update-download/{id}', [DownloadsController::class, 'update'])->name('admin.download.update');
  Route::delete('/download/delete/{id}', [DownloadsController::class, 'destroy'])->name('admin.download.destroy');

  // Testimonial
  Route::get('/review', [TestimonialController::class, 'index'])->name('admin.testimonial.index');
  Route::post('/review/tabledata', [TestimonialController::class, 'tabledata'])->name('admin.testimonial.tabledata');
  Route::get('/review/add-new-review', [TestimonialController::class, 'create'])->name('admin.testimonial.create');
  Route::get('/review/update-review/{id}', [TestimonialController::class, 'edit'])->name('admin.testimonial.edit');
  Route::post('/review/store', [TestimonialController::class, 'store'])->name('admin.testimonial.store');
  Route::post('/review/update-review/{id}', [TestimonialController::class, 'update'])->name('admin.testimonial.update');
  Route::delete('/review/delete/{id}', [TestimonialController::class, 'destroy'])->name('admin.testimonial.destroy');

  // Setting
  Route::get('/settings/update-settings/{id}', [SettingController::class, 'edit'])->name('admin.setting.edit');
  Route::post('/settings/update-settings/{id}', [SettingController::class, 'update'])->name('admin.setting.update');

  // Insurance1
  Route::get('/insurance/update-insurance/{id}', [InsuranceController::class, 'edit'])->name('admin.insurance.edit');
  Route::post('/insurance/update-insurance/{id}', [InsuranceController::class, 'update'])->name('admin.insurance.update');
  Route::get('/insurance/add-new-insurance', [InsuranceController::class, 'create'])->name('admin.insurance.create');
  Route::get('/insurance/add-new-insurance', [InsuranceController::class, 'create'])->name('admin.insurance.create');
  Route::delete('/insurance/delete/{id}', [InsuranceController::class, 'destroy'])->name('admin.insurance.destroy');



  //check
  Route::get('/check', [InsuranceController::class, 'index'])->name('admin.insurance.index');
  // Lead
  Route::get('/lead', [LeadController::class, 'index'])->name('admin.lead.index');
  Route::post('/lead/tabledata', [LeadController::class, 'tabledata'])->name('admin.lead.tabledata');
  Route::get('/lead/lead-details/{id}', [LeadController::class, 'show'])->name('admin.lead.show');
  Route::delete('/lead/delete/{id}', [LeadController::class, 'destroy'])->name('admin.lead.destroy');


  // Tinymce image upload handler
  Route::post('/handleeditoruploads', [EditorUploadsController::class, 'upload'])->name('admin.editoruploads.upload');



  ///////////////////// MINE /////////////////

  Route::get('/pages', [PagesController::class, 'index'])->name('admin.pages.index');
  Route::post('/service/tabledata', [PagesController::class, 'tabledata'])->name('admin.service.tabledata');
  Route::get('/pages/create', [PagesController::class, 'create'])->name('admin.pages.create');
  Route::post('/pages/store', [PagesController::class, 'store'])->name('admin.pages.store');
  Route::get('/pages/edit/{id}', [PagesController::class, 'edit'])->name('admin.pages.edit');
  Route::post('/pages/update/{id}', [PagesController::class, 'updates'])->name('admin.pages.update');
  Route::get('/service/delete/{id}', [PagesController::class, 'destroy'])->name('admin.pages.destroy');



  ///////////////////////// OUR SERVICES /////////////////////////
  Route::get('/ourservices', [ourservicesController::class, 'index'])->name('admin.ourservices.index');
  Route::post('/ousrservices/tabledata', [ourservicesController::class, 'tabledata'])->name('admin.ourservices.tabledata');
  Route::get('/ourservices/create', [ourservicesController::class, 'create'])->name('admin.ourservices.create');
  Route::post('/ourservices/store', [ourservicesController::class, 'store'])->name('admin.ourservices.store');
  Route::get('/ourservices/edit/{id}', [ourservicesController::class, 'edit'])->name('admin.ourservices.edit');
  Route::post('/ourservices/update/{id}', [ourservicesController::class, 'updates'])->name('admin.ourservices.update');
  Route::get('/ourservices/delete/{id}', [ourservicesController::class, 'destroy'])->name('admin.ourservices.destroy');
  Route::get('/ourservices/check-number', [ourservicesController::class, 'checkNumber'])->name('services.checknumber');


  //////////////////////// LABOR ///////////////////////
  Route::get('/labor', [LaborController::class, 'index'])->name('admin.labors.index');
  Route::post('/labors/tabledata', [LaborController::class, 'tabledata'])->name('admin.labors.tabledata');
  Route::get('/labors/create', [LaborController::class, 'create'])->name('admin.labors.create');
  Route::post('/labors/store', [LaborController::class, 'store'])->name('admin.labors.store');
  Route::get('/labors/edit/{id}', [LaborController::class, 'edit'])->name('admin.labors.edit');
  Route::post('/labors/update/{id}', [LaborController::class, 'update'])->name('admin.labors.update');
  Route::get('/labors/delete/{id}', [LaborController::class, 'destroy'])->name('admin.labors.destroy');
  Route::post('/labors/check-number', [LaborController::class, 'checkNumber'])->name('labors.checknumber');


  //////////////////////// SEARCH LABOR ///////////////////////
  Route::get('/search-labors', [SearchLaborController::class, 'index'])->name('admin.searchlabors.index');
  Route::post('/ourlabors', [SearchLaborController::class, 'search'])->name('admin.searchlabors.labors');

  

  ///////////////////// TESTING /////////////////
  Route::get('testing', [TestingController::class, 'testing']);

  //PAYMENT APPROVAL
  Route::get('/paymentapproval', [PaymentApproval::class, 'index'])->name('admin.paymentapproval');
  Route::post('/paymentapproval/tabledata', [PaymentApproval::class, 'tabledata'])->name('admin.paymentapproval.tabledata');
  Route::get('/paymentapproval/create', [PaymentApproval::class, 'create'])->name('admin.paymentapproval.create');
  Route::post('/paymentapproval/store', [PaymentApproval::class, 'store'])->name('admin.paymentapproval.store');
  Route::get('/paymentapproval/edit/{id}', [PaymentApproval::class, 'edit'])->name('admin.paymentapproval.edit');
  Route::post('/paymentapproval/update/{id}', [PaymentApproval::class, 'update'])->name('admin.paymentapproval.update');
  Route::get('/paymentapproval/delete/{id}', [PaymentApproval::class, 'destroy'])->name('admin.paymentapproval.destroy');
  
  //INVOICE DETAILS //
  Route::get('/invoice',[invoiceController::class,'index'])->name('admin.invoice.index');
  Route::post('/invoice/tabledata', [invoiceController::class, 'tabledata'])->name('admin.invoice.tabledata');
  Route::get('/invoice/create', [invoiceController::class, 'create'])->name('admin.invoice.create');
  Route::post('/invoice/store', [invoiceController::class, 'store'])->name('admin.invoice.store');
  Route::get('/invoice/edit/{id}', [invoiceController::class, 'edit'])->name('admin.invoice.edit');
  Route::post('/invoice/update/{id}', [invoiceController::class, 'update'])->name('admin.invoice.update');
  Route::get('/invoice/delete/{id}', [invoiceController::class, 'destroy'])->name('admin.invoice.destroy');

  Route::get('userinvoice',[NotificationController::class,'userinvoice']);

});






require __DIR__ . '/auth.php';
