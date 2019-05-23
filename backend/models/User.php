<?php

namespace backend\models;

use Yii;
use \backend\models\base\User as BaseUser;
use kartik\password\StrengthValidator;

/**
 * This is the model class for table "user".
 */
class User extends BaseUser
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public $current_password;
    public $new_password;
    public $new_password_repeat;

    public static function getAllRoles()
    {
		
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        $res = array();
		$getuser=User::find()->where(['id'=>Yii::$app->user->id])->one();
		
			foreach ($roles as $value) {
				if($getuser->type =="Super Admin")
				{
					$res[] = array(
						'id' => $value->name,
						'name' => Yii::t('app', $value->name)
					);
                }elseif(in_array($getuser->type, Yii::$app->params['type_user_register']))
                {
                    if (in_array($value->name, Yii::$app->params['type_user_register'])) {
                        $res[] = array(
                        'id' => $value->name,
                        'name' => Yii::t('app', $value->name)
                        );
                    }
                }else{
					if($value->name !="Super Admin")
					{
                        if (!in_array($value->name, Yii::$app->params['type_user_register'])) {
                            $res[] = array(
                            'id' => $value->name,
                            'name' => Yii::t('app', $value->name)
                            );
                        }
					}
				}
		}
        return $res;
    }

    public function rules()
    {
        $arr = [
            [['password'], StrengthValidator::className(), 'preset' => 'normal', 'userAttribute' => 'username'],
            [['username'], 'email'],
            [['new_password', 'new_password_repeat', 'current_password'], 'required', 'on' => 'changepassword'],
            ['new_password_repeat', 'compare', 'compareAttribute' => 'new_password', 'message' => Yii::t('app', 'The new passwords are different.'), 'on' => 'changepassword'],
            [['new_password'], \kartik\password\StrengthValidator::className(), 'preset' => 'normal', 'userAttribute' => 'username'],
        ];
        return array_merge(parent::rules(), $arr);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function checkAccess($role, $controller, $action)
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
    SELECT count(*) as tot from authitemchild
    WHERE (parent=:role AND child=:child) or (parent = :role AND child=:allrights)", [':role' => $role, ':child' => $controller . "/" . $action, ':allrights' => $controller . "/*"]);

        $result = $command->queryAll();
        if ($result[0]["tot"] > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function attributeLabels()
    {
        $array = [
            'status' => Yii::t('app', 'Active?'),
        ];
        return array_merge(parent::attributeLabels(), $array);
    }

}
