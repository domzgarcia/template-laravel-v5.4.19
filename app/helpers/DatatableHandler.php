<?php 
namespace App\helpers;
use DB;

class DatatableHandler {

	private $query_data;
	private $query_count;
	private $var_table_name;
	private $var_request;

	public function __construct($request, $tablename)
	{
		// $default = "inquiries";
		$this->var_table_name = $tablename; 
		$this->var_request = $request;
	}

	public function make()
	{
		//set query
		$this->setQuery();
		//set return
		$return = array(
					"draw" => $this->var_request->input('draw'),
					"recordsFiltered" => $this->query_count,
					"recordsTotal" => $this->query_count,
					"data" => $this->query_data->get()
				);
		return $return;
	}

	private function setQuery()
	{
		$this->query_data = DB::table($this->var_table_name);
		//count
		$this->countData();
		//set condition
		$this->setCondition();
		//set limit
		$this->setLimit();
		//set order
		$this->setOrder();
		return true;
	}

	private function setCondition()
	{
		$columns = $this->var_request->input('columns'); //array(array('name'=>'full_name'),array('name'=>'email'));
		// $columns = array(array('name'=>'full_name'),array('name'=>'email'));
		$value = $this->var_request->input('search')['value'];
		foreach ($columns as $key => $column) {
			if($column['searchable']){ // check if searchable
				if($key == 0){
					$this->query_data->where($column['name'],'like','%'. $value .'%');
				}else{
					$this->query_data->orWhere($column['name'],'like','%'. $value .'%');
				}
			}
		}
		return true;
	}

	private function setOrder()
	{
		$columns = $this->var_request->input('columns');
		$orders = $this->var_request->input('order');
		//test data
		// $columns = array(array('name'=>'full_name'),array('name'=>'email'));
		// $orders = array(array("column"=>1,"dir"=>'desc'));
		foreach ($orders as $key => $order) {
			if($columns[$order['column']]['orderable']){ // check if orderable
				$this->query_data->orderBy($columns[$order['column']]['name'],$order['dir']);
			}
		}
	}

	private function setLimit()
	{
		$start = $this->var_request->input('start');
		$length = $this->var_request->input('length');
		//test data
		// $start = 0;
		// $length = 10;
		//set data here
		$this->query_data->skip($start)->take($length);
		return true;
	}

	private function countData()
	{
		$this->query_count = $this->query_data->count();
		return true;
	}
}