<?php

namespace tgui\Controllers\ConfManager;

use tgui\Models\Conf_Models;
use tgui\Controllers\Controller;
use Respect\Validation\Validator as v;

class ConfModels extends Controller
{
################################################
	public function postAdd($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confModels',
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
			'name' => v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\Conf_Models' ),
			'expectations' => v::arrayType()->notEmpty(),//->serviceTacAvailable(0),
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();
		$expectations = $allParams['expectations'];
		unset($allParams['expectations']);

		$model = Conf_Models::create($allParams);

		$expectations_bind = [];
		for ($i=0; $i < count($expectations); $i++) {
			$expectations[$i]['model_id'] = $model->id;
			$expectations[$i]['order'] = $i;
			$expectations_bind[] = $expectations[$i];
		}
		$this->db::table('confM_bind_model_expect')->insert($expectations_bind);

		return $res -> withStatus(200) -> write(json_encode($data));
	}

	public function getEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'confModels',
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

		$data['model'] = Conf_Models::where('id', $req->getParam('id'))->first()->toArray();
		$data['model']['expectations'] = $this->db::table('confM_bind_model_expect')->
			select(['hidden','send','expect','write'])->
			where('model_id', $req->getParam('id') )->
			orderBy('order')->get();

		return $res -> withStatus(200) -> write(json_encode($data));
	}
////////////////////////////////////////////////////////////
	public function postEdit($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confModels',
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
			'name' => v::when( v::nullType() , v::alwaysValid(), v::noWhitespace()->notEmpty()->theSameNameUsed( '\tgui\Models\Conf_Models', $req->getParam('id') ) ),
			'expectations' => v::when( v::nullType() , v::alwaysValid(), v::arrayType()->notEmpty()->setName('Expectation list') )
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$allParams = $req->getParams();
		if ( isset($allParams['expectations']) ){
			$expectations = $allParams['expectations'];
			unset($allParams['expectations']);

			$expectations_bind = [];
			for ($i=0; $i < count($expectations); $i++) {
				$expectations[$i]['model_id'] = $req->getParam('id');
				$expectations[$i]['order'] = $i;
				$expectations_bind[] = $expectations[$i];
			}
			$this->db::table('confM_bind_model_expect')->where('model_id', $req->getParam('id'))->delete();
			$this->db::table('confM_bind_model_expect')->insert($expectations_bind);
		}
		$cmd = Conf_Models::where( 'id', $req->getParam('id') )->update($allParams);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
	///////////////////////////////////////////////////////////
	public function postDel($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'confModels',
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
			'name' => v::noWhitespace()->notEmpty(),//->theSameNameUsed( '\tgui\Models\Conf_Models' ),
			'id' => v::numeric()
		]);

		if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

		$data['result'] = Conf_Models::where( 'id', $req->getParam('id') )->delete();

		return $res -> withStatus(200) -> write(json_encode($data));
	}

  public function postDatatables($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'post',
      'object' => 'confModels',
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

    $columns = $this->APICheckerCtrl->getTableTitles('confM_models'); //Array of all columnes that will used
    array_unshift( $columns, 'id' );
    array_push( $columns, 'created_at', 'updated_at' );
    $data['columns'] = $columns;
    $queries = [];
    $data['filter'] = [];
    $data['filter']['error'] = false;
    $data['filter']['message'] = '';
    //Filter start
    $searchString = ( empty($params['search']['value']) ) ? '' : $params['search']['value'];
    $temp = $this->queriesMaker($columns, $searchString);
    $queries = $temp['queries'];
    $data['filter'] = $temp['filter'];

    $data['queries'] = $queries;
    $data['columns'] = $columns;
    //Filter end
    $data['recordsTotal'] = Conf_Models::count();
    //Get temp data for Datatables with Fliter and some other parameters
    $tempData = Conf_Models::select($columns)->
      when( !empty($queries),
        function($query) use ($queries)
        {
          foreach ($queries as $condition => $attr) {
            switch ($condition) {
              case '!==':
                foreach ($attr as $column => $value) {
                  $query->whereNotIn($column, $value);
                }
                break;
              case '==':
                foreach ($attr as $column => $value) {
                  $query->whereIn($column, $value);
                }
                break;
              case '!=':
                foreach ($attr as $column => $valueArr) {
                  for ($i=0; $i < count($valueArr); $i++) {
                    if ($i == 0) $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
                    $query->where($column,'NOT LIKE', '%'.$valueArr[$i].'%');
                  }
                }
                break;
              case '=':
                foreach ($attr as $column => $valueArr) {
                  for ($i=0; $i < count($valueArr); $i++) {
                    if ($i == 0) $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
                    $query->where($column,'LIKE', '%'.$valueArr[$i].'%');
                  }
                }
                break;
              default:
                //return $query;
                break;
            }
          }
          return $query;
        });
        $data['recordsFiltered'] = $tempData->count();

  			$tempData = $tempData->
  			orderBy($params['columns'][$params['order'][0]['column']]['data'],$params['order'][0]['dir'])->
  			take($params['length'])->
  			offset($params['start'])->
  			get()->toArray();
  		//Creating correct array of answer to Datatables
  		$data['data']=array();
  		foreach($tempData as $model){
  			$buttons='<button class="btn btn-warning btn-xs btn-flat" onclick="cm_models.get(\''.$model['id'].'\',\''.$model['name'].'\')">Edit</button> <button class="btn btn-danger btn-xs btn-flat" onclick="cm_models.del(\''.$model['id'].'\',\''.$model['name'].'\')">Del</button>';
  			$model['buttons'] = $buttons;
  			array_push($data['data'],$model);
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
		if ($req->getParam('byId') != null){
			$id = $req->getParam('byId');

			$data['item'] = ( is_array($id) ) ? Conf_Models::select(['id','name AS text'])->whereIn('id', $id)->get() : Conf_Models::select(['id','name AS text'])->where('id', $req->getParam('byId') )->first();
			//$data['item']['text'] = $data['item']['name'];
			return $res -> withStatus(200) -> write(json_encode($data));
		}
		//////////////////////
		////LIST OF GROUPS////
		$data['incomplete_results'] = false;
		$data['totalCount'] = Conf_Models::select(['id','name'])->count();
		$search = $req->getParam('search');
		$take = 10 * $req->getParam('page');
		$offset = 10 * ($req->getParam('page') - 1);
		$data['take'] = $take;
		$data['offset'] = $offset;
		$tempData = Conf_Models::select(['id','name AS text'])->
			when( !empty($search), function($query) use ($search)
			{
				$query->where('name','LIKE', '%'.$search.'%');
			})->
			take($take)->
			offset($offset);

		$tempCounter = $tempData->count();

		$tempData = $tempData->get()->toArray();
		$data['results']=array();
		$data['pagination'] = (!$tempData OR $tempCounter < 10) ? ['more' => false] : [ 'more' => true];
		foreach($tempData as $model)
		{
			//$model['text'] = $model['name'];
			//unset($model['name']);
			array_push($data['results'],$model);
		}

		return $res -> withStatus(200) -> write(json_encode($data));
	}

}//END OF CLASS//
