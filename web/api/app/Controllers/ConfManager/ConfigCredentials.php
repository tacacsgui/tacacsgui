<?php

namespace tgui\Controllers\ConfManager;

use tgui\Models\Conf_Credentials;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class ConfigCredentials extends Controller
{
################################################
	public function postAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confCredentials',
			'action' => 'add',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\Conf_Credentials' ),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$credential = Conf_Credentials::create($allParams);

		$data['credential'] = 1;

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function getEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confCredentials',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'id' => v::numeric()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['credential'] = Conf_Credentials::where('id', $req->getParam('id'))->first()->toArray();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
////////////////////////////////////////////////////////////
	public function postEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confCredentials',
			'action' => 'edit',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'id' => v::numeric(),
			'name' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\Conf_Credentials', $req->getParam('id') ) ),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();

		$cmd = Conf_Credentials::where( 'id', $req->getParam('id') )->update($allParams);

		$data['save'] = 1;

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////////////////
	public function postDel($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confCredentials',
			'action' => 'del',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK SHOULD I STOP THIS?//START//
		if( $this->shouldIStopThis() )
		{
			$data['error'] = $this->shouldIStopThis();
			return $res -> withStatus(400) -> write(json_encode($data));
		}
		//CHECK SHOULD I STOP THIS?//END//
		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		$validation = $this->validator->validate($req, [
			'name' => v::noWhitespace()->notEmpty(),//->theSameNameUsed( '\tgui\Models\Conf_Credentials' ),
			'id' => v::numeric()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['result'] = Conf_Credentials::where( 'id', $req->getParam('id') )->delete();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

  public function postDatatables($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'post',
      'object' => 'confCredentials',
      'action' => 'datatables',
    ]);
    #check error#
    if ($_SESSION['error']['status']){
      $data['error']=$_SESSION['error'];
      return $res -> withStatus(401) -> write(json_encode($data));
    }
    //INITIAL CODE////END//

    unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//

    //CHECK ACCESS TO THAT FUNCTION//START//
    if(!$this->checkAccess(4, true))
    {
      $data['data'] = [];
      $data['recordsTotal'] = 0;
      $data['recordsFiltered'] = 0;
      return $res -> withStatus(200) -> write(json_encode($data));
    }
    //CHECK ACCESS TO THAT FUNCTION//END//

    $params = $req->getParams(); //Get ALL parameters form Datatables

    $columns = []; //$this->APICheckerCtrl->getTableTitles('confM_credentials'); //Array of all columnes that will used
    array_unshift( $columns, 'confM_credentials.*' );
    array_push( $columns,
	 	$this->db::raw('(SELECT COUNT(*) FROM confM_queries WHERE credential = confM_credentials.id) as ref_d'),
	 	$this->db::raw('(SELECT COUNT(*) FROM confM_devices WHERE credential = confM_credentials.id) as ref_q') );
		if (($key = array_search('name', $columns)) !== false) {
    	unset($columns[$key]);
			array_push( $columns, 'confM_credentials.name as name');
		}

		$data['columns'] = $columns;
		$queries = (empty($params['searchTerm'])) ? [] : $params['searchTerm'];

		//Filter end
		$data['recordsTotal'] = Conf_Credentials::count();
		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = Conf_Credentials::select($columns)->
			leftJoin('confM_queries as q', 'q.credential', '=', 'confM_credentials.id')->
			leftJoin('confM_devices as d', 'd.credential', '=', 'confM_credentials.id')->
			groupBy('confM_credentials.id')->
			select($columns);
		// when( !empty($queries),
		// 	function($query) use ($queries)
		// 	{
		// 		$query->where('username','LIKE', '%'.$queries.'%');
		// 		return $query;
		// 	});
		$data['recordsFiltered'] = $tempData->count();

		if (!empty($params['sortColumn']) and !empty($params['sortDirection']))
				$tempData = $tempData->orderBy($params['sortColumn'],$params['sortDirection']);

		$data['data'] = $tempData->get()->toArray();

		return $res -> withStatus(200) -> write(json_encode($data));

    // $data['columns'] = $columns;
    // $queries = [];
    // $data['filter'] = [];
    // $data['filter']['error'] = false;
    // $data['filter']['message'] = '';
    // //Filter start
    // $searchString = ( empty($params['search']['value']) ) ? '' : $params['search']['value'];
    // $temp = $this->queriesMaker($columns, $searchString);
    // $queries = $temp['queries'];
    // $data['filter'] = $temp['filter'];
		//
    // $data['queries'] = $queries;
    // $data['columns'] = $columns;
    // //Filter end
    // $data['recordsTotal'] = Conf_Credentials::count();
    // //Get temp data for Datatables with Fliter and some other parameters
    // $tempData = Conf_Credentials::select($columns)->
		// 	leftJoin('confM_queries as q', 'q.credential', '=', 'confM_credentials.id')->
		// 	leftJoin('confM_devices as d', 'd.credential', '=', 'confM_credentials.id')->
		// 	groupBy('confM_credentials.id')->
    //   when( !empty($queries),
    //     function($query) use ($queries)
    //     {
    //       foreach ($queries as $condition => $attr) {
    //         switch ($condition) {
    //           case '!==':
    //             foreach ($attr as $column => $value) {
    //               $query->whereNotIn($column, $value);
    //             }
    //             break;
    //           case '==':
    //             foreach ($attr as $column => $value) {
    //               $query->whereIn($column, $value);
    //             }
    //             break;
    //           case '!=':
    //             foreach ($attr as $column => $valueArr) {
    //               for ($i=0; $i < count($valueArr); $i++) {
    //                 if ($i == 0) $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
    //                 $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
    //               }
    //             }
    //             break;
    //           case '=':
    //             foreach ($attr as $column => $valueArr) {
    //               for ($i=0; $i < count($valueArr); $i++) {
    //                 if ($i == 0) $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
    //                 $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
    //               }
    //             }
    //             break;
    //           default:
    //             //return $query;
    //             break;
    //         }
    //       }
    //       return $query;
    //     });
    //     $data['recordsFiltered'] = $tempData->count();
		//
  	// 		$tempData = $tempData->
  	// 		orderBy($params['columns'][$params['order'][0]['column']]['data'],$params['order'][0]['dir'])->
  	// 		take($params['length'])->
  	// 		offset($params['start'])->
  	// 		get()->toArray();
  	// 	//Creating correct array of answer to Datatables
  	// 	$data['data']=array();
  	// 	foreach($tempData as $credentials){
  	// 		$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="cm_credo.get(\''.$credentials['id'].'\',\''.$credentials['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="cm_credo.del(\''.$credentials['id'].'\',\''.$credentials['name'].'\')">Del</button>';
  	// 		$credentials['buttons'] = $buttons;
  	// 		array_push($data['data'],$credentials);
  	// 	}
  	// 	//Some additional parameters for Datatables
  	// 	$data['draw']=intval( $params['draw'] );
		//
  	// 	return $res -> withStatus(200) -> write(json_encode($data));
  }

	public function getList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confmanager',
			'action' => 'model list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(3, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		///IF GROUPID SET///
		if ($req->getParam('id') != null){
			$id = explode(',', $req->getParam('id'));

			$data['results'] = Conf_Credentials::select(['id','name AS text'])->whereIn('id', $id)->get();
			// if (  !count($data['results']) ) $data['results'] = null;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$query = Conf_Credentials::select(['id','name as text']);
		$data['total'] = $query->count();
		$search = $req->getParam('search');

		$query = $query->when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			});

		$data['results']=$query->orderBy('name')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

}//END OF CLASS//
