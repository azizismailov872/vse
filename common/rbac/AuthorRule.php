<?php 

namespace common\rbac;


use yii\rbac\Rule;


class AuthorRule extends Rule
{
	public $name = 'isAuthor';

	public function execute($user_id,$item,$params)
	{	
		if(isset($params['item']) && !empty($params['item']))
		{
			if($params['item']->author_id == $user_id)
			{	
				return true;
			}
			else
			{	
				return false;
			}
		}
	}
}