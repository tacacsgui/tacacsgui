<?php

namespace tgui\Controllers\ConfManager;

use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;
use tgui\Controllers\ConfManager\ConfManagerHelper as Helper;

use tgui\Services\CMDRun\CMDRun as CMDRun;

class ConfGroups extends Controller
{
################################################
	public function postAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confGroups',
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
			'name' => v::noWhitespace()->notEmpty()->alnum()//->theSameNameUsed( '\tgui\Models\Conf_Devices' ),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$status = CMDRun::init()->
			setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_git.sh')->
			setAttr('--mkdir='.$req->getParam('name'))->
			get();

		if ( !$status ){
				$data['error']['status']=true;
				$data['error']['validation']=['name' => ['That name already used']];
				return $res -> withStatus(200) -> write(json_encode($data));
			}

		$data['group'] = 1;

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function getEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confGroups',
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

		$data['group'] = [
			'name' => $req->getParam('id'),
			'name_old' => $req->getParam('id'), 
			'id' => $req->getParam('id')];

		return $res -> withStatus(200) -> write(json_encode($data));
	}
////////////////////////////////////////////////////////////
	public function postEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confGroups',
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
			'name' => v::noWhitespace()->notEmpty()->alnum(),
			'name_old' => v::noWhitespace()->notEmpty()->alnum(),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$status = CMDRun::init()->
			setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_git.sh')->
			setAttr(['--new-dir-name='.$req->getParam('name'),'--mv-dir='.$req->getParam('name_old')])->
			get();

		if ( $status != 1 ){
			$data['error']['status']=true;
			$data['error']['validation']= ($status == 2) ? ['name' => ['That name already used']] : ['name' => ['Unkown error']] ;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		ConfManagerHelper::forceCommit();

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
			'object' => 'confGroups',
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
			'name' => v::noWhitespace()->notEmpty()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['result'] = CMDRun::init()->
			setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_git.sh')->
			setAttr('--deldir='.$req->getParam('name'))->
			get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

  public function postDatatables($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'post',
      'object' => 'confGroups',
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

    $reverse = ( $params['sortDirection'] == 'asc') ? 0 : 1;

    $searchString = ( empty($params['search']['value']) ) ? '' : $params['search']['value'];

    $data['queries'] = $queries;
    $data['columns'] = $columns;

    // $request_attr = ['--show-dir-table=1','--reverse='.$reverse,'--sort='.$sort_colum,'--start-line='.$start_line,'--end-line='.$end_line];
    $request_attr = [ '--show-dir-table=1','--reverse='.$reverse,'--sort='.$params['sortColumn'] ];

    if ( $data['queries'] ){
      if ( $data['queries']['='] ){
        foreach ($data['queries']['='] as $key => $value_arr) {
          foreach ($value_arr as $value) {
            array_push( $request_attr, '--'.$key.'='.$value );
          }
        }
      }
    }

    $data['cmd_'] = CMDRun::init()->
      setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh')->
      setAttr($request_attr)->showCMD();
    $table_data = CMDRun::init()->
      setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh')->
      setAttr($request_attr)->
      get();
    $table_data = explode(PHP_EOL, $table_data);

    $data['recordsTotal'] = intval( preg_replace('/total\s+/', '', $table_data[0]) );
    $data['recordsFiltered'] = intval( preg_replace('/filtered\s+/', '', $table_data[1]) );
    unset($table_data[1]); unset($table_data[0]);

    $data['data'] = [];
    foreach ($table_data as $row) {
      $columns = preg_split('/\s+/', $row);
      $data['data'][] = [
        'id' => $columns[1],
        'name' => $columns[1],
        'date' => date( 'Y-m-d H:i:s', $columns[0]),
        'members' => $columns[2],
        'buttons' => $buttons,
      ];
    }

    //Some additional parameters for Datatables
    $data['draw']=intval( $params['draw'] );

  	return $res -> withStatus(200) -> write(json_encode($data));
  }

	public function getList($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confmanager',
			'action' => 'group list',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		//CHECK ACCESS TO THAT FUNCTION//START//
		if(!$this->checkAccess(1, true))
		{
			return $res -> withStatus(403) -> write(json_encode($data));
		}
		//CHECK ACCESS TO THAT FUNCTION//END//

		///IF GROUPID SET///
		if ($req->getParam('id') != null){
			$id = explode(',', $req->getParam('id'));

			// $data['results'] = TACCMD::select(['id','name AS text'])->where('type',1)->whereIn('id', $id)->get();
			$data['results'] = [];
			if ( is_dir('/opt/tgui_data/confManager/configs/'.$id) ){
				$data['results'][] = [
					'text' => $id,
					'id' => $id,
				];
			}
			// if (  !count($data['results']) ) $data['results'] = null;
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////

		$search = $req->getParam('search');
		// $take = 10 * $req->getParam('page');
		// $offset = (10 * ($req->getParam('page') - 1) + 1);
		$data['take'] = $take;
		$data['offset'] = $offset;
		$reverse=1;
		$sort_colum='date';
		// $start_line='1';
		// $end_line="10";
		// $request_attr = ['--show-dir-table=1','--reverse='.$reverse,'--sort='.$sort_colum,'--start-line='.$offset,'--end-line='.$take];
		$request_attr = ['--show-dir-table=1','--reverse='.$reverse,'--sort='.$sort_colum];
		if ( ! empty($search) ) $request_attr[]='--name='.$search;
		$data['cmd_'] = CMDRun::init()->
			setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh')->
			setAttr($request_attr)->showCMD();
		$table_data = CMDRun::init()->
			setCmd('/opt/tacacsgui/plugins/ConfigManager/cm_ls.sh')->
			setAttr($request_attr)->
			get();
		$table_data = explode(PHP_EOL, $table_data);

		$data['recordsTotal'] = intval( preg_replace('/total\s+/', '', $table_data[0]) );
		$data['recordsFiltered'] = intval( preg_replace('/filtered\s+/', '', $table_data[1]) );
		$table_data = array_slice($table_data, 2);
		$data['results'] = [];
		for ($i=0; $i < count($table_data); $i++) {
			$temp_data = explode(' ', $table_data[$i]);
			$data['results'][] = [
				'id' => $temp_data[1],
				'text' => $temp_data[1],
				// 'members' => $temp_data[2],
			];
		}

		return $res -> withStatus(200) -> write(json_encode($data));
		//////////////////////
		////LIST OF GROUPS////
		// $data['incomplete_results'] = false;
		// $data['totalCount'] = Conf_Devices::select(['id','name'])->count();
		// $search = $req->getParam('search');
		// $take = 10 * $req->getParam('page');
		// $offset = 10 * ($req->getParam('page') - 1);
		// $data['take'] = $take;
		// $data['offset'] = $offset;
		// $tempData = Conf_Devices::select(['id','name AS text'])->
		// 	when( !empty($search), function($query) use ($search)
		// 	{
		// 		$query->where('name','LIKE', '%'.$search.'%');
		// 	})->
		// 	take($take)->
		// 	offset($offset);
		//
		// $tempCounter = $tempData->count();
		//
		// $tempData = $tempData->get()->toArray();
		// $data['results']=array();
		// $data['pagination'] = (!$tempData OR $tempCounter < 10) ? ['more' => false] : [ 'more' => true];
		// foreach($tempData as $model)
		// {
		// 	//$model['text'] = $model['name'];
		// 	//unset($model['name']);
		// 	array_push($data['results'],$model);
		// }

		return $res -> withStatus(200) -> write(json_encode($data));
	}

}//END OF CLASS//
