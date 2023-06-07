<?php

namespace App\Http\Controllers\Admin;

use App\Common\FileHandler;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insurance;
use Illuminate\Support\Facades\Validator;

class menuController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = array(
            'pageName' => 'Menu',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'menu',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.menu.menu')->with($viewData);
    }

    public function tabledata(Request $request) {
        $input = $request->all();
        $query = Insurance::query();
        if($request->search['value']) {
            $searchStrings = explode(' ', $request->search['value']);
            foreach($searchStrings as $searchString) {
                $query->where(function ($query) use ($searchString) {
                    $query->orWhere('title', 'like', '%' . $searchString . '%');
                    $query->orWhere('slug', 'like', '%' . $searchString . '%');
                });
            }
        }
        if($request->order) {
            $orderableColumns = array('title', 'slug', '');
            $query->orderBy($orderableColumns[$request->order['0']['column']], $request->order['0']['dir']);
        }else {
            $query->orderBy('id', 'DESC');
        }
        $recordsFiltered = $query->count();
        $query->offset($input['start']);
        $query->limit($input['length']);
        $filteredMenu = $query->get();
        // echo "<pre>";print_r($filteredMenu);echo "</pre>";exit;
        foreach($filteredMenu as $menu) {
            $menu->actions = '<a class="edit_men" href="'.route('admin.menu.edit', ['id' => $menu->id]).'">
                        <img src="'.asset('img/edit-solid.svg').'" alt="edit icon">
                    </a>';
                $menu->actions .= '<a class="deleteprocess" data-type="menu" data-id="'.$menu->id.'" href="javascript:;">
                        <img src="'.asset('img/trash-solid.svg').'" alt="delete icon">
                    </a>
                    <form class="deleteformmenu'. $menu->id.'" method="POST" action="'.route('admin.menu.destroy', ['id' => $menu->id]).'">
                      <input type="hidden" name="_token" value="'.csrf_token().'">
                      <input type="hidden" name="_method" value="DELETE">
                    </form>';
        }
        $data = [
            'draw' => $input['draw'],
            'recordsTotal' => Insurance::count(),
            'recordsFiltered' => $recordsFiltered,
            "data" =>  $filteredMenu
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viewData = array(
            'pageName' => 'Add Insurance',
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'Menu',
                    'class' => '',
                    'url' => route('admin.menu.index')
                ),
                (object)array(
                    'name' => 'Add New Insurance',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.menu.addeditmenu')->with($viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);       
        $menu = new Insurance;
        $menu->name = $request->name;
        $menu->save();
        return Redirect()->route("admin.menu.index")->with('success', 'menu added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Insurance::findOrFail($id);
        $viewData = array(
            'pageName' => 'Update Page',
            'menu' => $menu,
            'breadCrumbs' => array(
                (object)array(
                    'name' => 'Dashboard',
                    'class' => '',
                    'url' => route('admin.dashboard')
                ),
                (object)array(
                    'name' => 'menu',
                    'class' => '',
                    'url' => route('admin.menu.index')
                ),
                (object)array(
                    'name' => 'Update menu',
                    'class' => 'active',
                    'url' => 'javascript:;'
                )
            )
        );
        return view('admin.menu.addeditmenu')->with($viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Insurance ::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        $menu->name = $request->name;
        $menu->save();
        return Redirect()->route("admin.menu.index")->with('success', 'Insaurance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Insurance::destroy($id);
        return Redirect()->route("admin.menu.index")->with('success', 'Insurance deleted successfully');
    }
}

