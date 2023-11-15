<?php


namespace App\Http\Controllers\Cms;


use App\DataTables\CustomerDataTable;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('cms.customer.index');
    }
}
