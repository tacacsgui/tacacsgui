<?php
namespace tgui\Controllers\APINotification;

use tgui\Controllers\Controller;
use tgui\Models\APINotification;
use tgui\Models\PostLog;
use Respect\Validation\Validator as v;

class APINotificationCtrl extends Controller
{
  public function getSettings($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'get',
			'object' => 'notification',
			'action' => 'settings',
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

    $data['settings'] = APINotification::select()->first();
		return $res -> withStatus(200) -> write(json_encode($data));
	}
  public function postSettings($req,$res)
	{
		//INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'notification',
			'action' => 'settings',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

    //CHECK ACCESS TO THAT FUNCTION//START//
    if( ! $this->checkAccess(1) )
    {
      return $res -> withStatus(403) -> write(json_encode($data));
    }
    //CHECK ACCESS TO THAT FUNCTION//END//

    $allParams = $req->getParams();

    $validation = $this->validator->validate($req, [
      'bad_authentication_enable' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)),
      'bad_authorization_enable' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(1)),
      'bad_authentication_count' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(60)->setName('Bad Authentication Count')),
      'bad_authorization_count' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(60)->setName('Bad Authorization Count')),
      'bad_authentication_interval' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(30)->setName('Bad Authentication Interval')),
      'bad_authorization_interval' => v::when( v::nullType() , v::alwaysValid(), v::numeric()->min(0)->max(30)->setName('Bad Authentication Interval')),
      'bad_authentication_email_list' => v::when( v::nullType() , v::alwaysValid(), v::arrayType()->each(v::oneOf(v::email(), v::equals('')))->setName('Email List')),
      'bad_authorization_email_list' => v::when( v::nullType() , v::alwaysValid(), v::arrayType()->each(v::oneOf(v::email(), v::equals('')))->setName('Email List')),
    ]);

    if ($validation->failed()){
			$data['error']['status']=true;
			$data['error']['validation']=$validation->error_messages;
			return $res -> withStatus(200) -> write(json_encode($data));
		}

    if ( isset($allParams['bad_authentication_email_list']) ) $allParams['bad_authentication_email_list'] = implode('; ',$allParams['bad_authentication_email_list']);
    if ( isset($allParams['bad_authorization_email_list']) ) $allParams['bad_authorization_email_list'] = implode('; ',$allParams['bad_authorization_email_list']);

    $data['save'] = APINotification::where([['id','=',1]])->update($allParams);

		return $res -> withStatus(200) -> write(json_encode($data));
	}
  public function postDatatables($req,$res)
  {
    //INITIAL CODE////START//
		$data=array();
		$data=$this->initialData([
			'type' => 'post',
			'object' => 'notification',
			'action' => 'datatables',
		]);
		#check error#
		if ($_SESSION['error']['status']){
			$data['error']=$_SESSION['error'];
			return $res -> withStatus(401) -> write(json_encode($data));
		}
		//INITIAL CODE////END//

		unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//

		$params=$req->getParams(); //Get ALL parameters form Datatables

		$columns = $this->APICheckerCtrl->getTableTitles('post_log', 'logging'); //Array of all columnes that will used
		array_unshift( $columns, 'id' );

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
		$data['recordsTotal'] = PostLog::count();

		//Get temp data for Datatables with Fliter and some other parameters
		$tempData = PostLog::select()->
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
			$data['data'] = [];
		foreach($tempData as $loggingEntry){
			//$loggingEntry['username'] .= ($loggingEntry['uid'] !== '') ? ' ('.$loggingEntry['uid'].')' : '';
			//$loggingEntry['obj_name'] .= ($loggingEntry['obj_id'] !== '') ? ' ('.$loggingEntry['obj_id'].')' : '';
			array_push($data['data'],$loggingEntry);
		}
		//Some additional parameters for Datatables
		$data['draw']=intval( $params['draw'] );

		return $res -> withStatus(200) -> write(json_encode($data));
	}
  public function postBufferDatatables($req,$res)
  {
    //INITIAL CODE////START//
    $data=array();
    $data=$this->initialData([
      'type' => 'post',
      'object' => 'notification',
      'action' => 'datatables',
    ]);
    #check error#
    if ($_SESSION['error']['status']){
      $data['error']=$_SESSION['error'];
      return $res -> withStatus(401) -> write(json_encode($data));
    }
    //INITIAL CODE////END//

    unset($data['error']);//BEACAUSE DATATABLES USES THAT VARIABLE//

    $params=$req->getParams(); //Get ALL parameters form Datatables

    $columns = $this->APICheckerCtrl->getTableTitles('post_buffer', 'logging'); //Array of all columnes that will used
    array_unshift( $columns, 'id' );

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
    $data['recordsTotal'] = $this->db::connection('logging')->table('post_buffer')->count();

    //Get temp data for Datatables with Fliter and some other parameters
    $tempData = $this->db::connection('logging')->table('post_buffer')->select()->
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
      $data['data'] = [];
    foreach($tempData as $loggingEntry){
      //$loggingEntry['username'] .= ($loggingEntry['uid'] !== '') ? ' ('.$loggingEntry['uid'].')' : '';
      //$loggingEntry['obj_name'] .= ($loggingEntry['obj_id'] !== '') ? ' ('.$loggingEntry['obj_id'].')' : '';
      array_push($data['data'],$loggingEntry);
    }
    //Some additional parameters for Datatables
    $data['draw']=intval( $params['draw'] );

    return $res -> withStatus(200) -> write(json_encode($data));
  }
}
