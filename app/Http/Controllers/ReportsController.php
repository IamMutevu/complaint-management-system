<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ComplaintCategory;

class ReportsController extends Controller
{
    public function index(){
        return view('backend.admin.reports');
    }

    public function getData(){
        $complaint_categories = ComplaintCategory::all()->load('complaints');

        $data = array();

        foreach($complaint_categories as $complaint_category){
            $data += array(
                $complaint_category->name => count($complaint_category->complaints)
            );
        }
        return json_encode($data, false);
    }
}
