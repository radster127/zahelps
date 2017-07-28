<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Validator;
// Models [start]
use App\Testimonial;
use App\Custom;


class TestimonialController extends Controller
{
    
    public function __construct() {
        // Links
        $this->list_url = 'admin/letter-of-happiness';
        $this->add_url = 'admin/letter-of-happiness/create';
        $this->edit_url = 'admin/letter-of-happiness/{id}/edit';

        // Model and Module name
        $this->module = "Testimonial";
        $this->moduleLocation = "Testimonial";
        $this->modelObj = new Testimonial;

        // Module Message
        $this->addMsg = $this->module . " has been added successfully!";
        $this->updateMsg = $this->module . " has been updated successfully!";
        $this->deleteMsg = $this->module . " has been deleted successfully!";
        $this->deleteErrorMsg = $this->module . " can not deleted!";

        // View
        $this->veiw_base = 'admin.letter-of-happiness';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list_params = Custom::getListParams($request);
        $rows = $this->modelObj->getAdminList($list_params);
        $data['rows'] = $rows;
        $data['list_params'] = $list_params;
        $data['searchColumns'] = $this->modelObj->getSearchColumns();
        $data['with_date'] = 1;
        return view($this->veiw_base . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->veiw_base . '.create');
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
                    'subject' => 'required',
                    'letter-of-happiness' => 'required',
        ]);

        if ($validator->fails()) {
          return redirect($this->add_url)
                          ->withErrors($validator)
                          ->withInput();
        } else {
          $model = $this->modelObj;
          $model::create($request->all());

          session()->flash('success_message', $this->addMsg);
          return redirect($this->list_url);
        }
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
        $model = $this->modelObj;
        $formObj = $model::findOrFail($id);
        $data['formObj'] = $formObj;
        return view($this->veiw_base . '.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //dd($request->all());
        $model = $this->modelObj;
        $formObj = $model::findOrFail($id);

        $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'content' => 'required',
                    'status' => 'required',
        ]);

        if ($validator->fails()) {

          $edit_url = $this->edit_url;
          $edit_url = str_replace('{id}', $id, $edit_url);

          return redirect($edit_url)
                          ->withErrors($validator)
                          ->withInput();
        } else {

          $formObj->update($request->all());

          session()->flash('success_message', $this->updateMsg);
          return redirect($this->list_url);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $model = $this->modelObj;
        $modelObj = $model::find($id);
        $modelObjTemp = $modelObj;

        if ($modelObj) {
          try {
            $modelObj->delete();
            session()->flash('success_message', $this->deleteMsg);
            return redirect($this->list_url);
          } catch (Exception $e) {
            session()->flash('error_message', $this->deleteErrorMsg);
            return redirect($this->list_url);
          }
        } else {
          session()->flash('error_message', "Record not exists");
          return redirect($this->list_url);
        }
    }
}
