<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 25.10.2017
 * Time: 11:30
 */

namespace controller;


use models\Employee;
use models\User;

class UserController extends BaseController implements ControllerInterface
{

    public function index()
    {

    }

    public function add()
    {
        $this::$dontRender=true;
        $data = $this->httpHandler->getData();
        $statement=$this->renderer->queryBuilder->setMode(0)
            ->setTable('dbuser')
            ->setCols('dbuser',array('username','email'))
            ->executeStatement();
        $valid=true;

        foreach($statement as $tmp)
            if($tmp['username']==$data['username'] || $tmp['email']==$data['email']){
                $valid=false;
            }
        if($valid==false){
                /*$this->renderer->sessionManager->setSessionArray('alert',array('alert'=>1));
                $this->renderer->sessionManager->setSessionItem('alert','title',"'");
                $this->renderer->sessionManager->setSessionItem('alert','content','');
                $this->renderer->sessionManager->setSessionItem('alert','good',"true");*/

                $this->renderer->sessionManager->setSessionArray('alert',array('alert'=>true,'title'=>'Username or Email invalid!','content'=>'One or both of them is already registered!','good'=>'false'));
                /*$this->renderer->setAttribute('alertTitle','Username or Email invalid!');
                $this->renderer->setAttribute('alertContent','One or both of them is already registered!');
                $this->renderer->setAttribute('alertGood','false');
                var_dump($this->renderer->alert);*/
                $this->httpHandler->redirect('user','user');
            }

        if($this->httpHandler->isPost() && $valid==true){
            $user = new User();
            $user->patchEntity($data);
            if($user->isValid()){
                $user->save();
                $this->createAlert('Registered!',"Congratulations $data[username], you just registered!",true);
                $this->httpHandler->redirect('user','user');
            }
        }
    }

    public function view(int $id)
    {
        // TODO: Implement view() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function edit(int $id)
    {
        $this::$dontRender=true;
        //$valid=true;
        //echo "started<br>";
        if($id!=$this->renderer->sessionManager->getSessionItem('User','id') || $this->httpHandler->isGet()){
            $this->createAlert('Invalid Edit!','The contents of your profile edit were invalid.',false);
            $this->httpHandler->redirect('user','user');
        }
        //echo"valid id input<br>";
        $data = $this->httpHandler->getData();
        $user = new User();
        $temp=$this->renderer->queryBuilder->setMode(0)
            ->setTable('DBUser')
            ->addCond('DBUser','id',0,$id,0)
            ->executeStatement();
        if(password_verify($data['current_password'],$temp[0]['password'])){
            $this->createAlert('Invalid Edit!','Wrong password.',false);
            //echo"illegal edit, wrong password<br>";
        }
        //echo"valid password<br>";
        $data['password']=(isset($data["new_password"])&& strlen($data['new_password'])>5) ? crypt($data['new_password'],$user::getSalt()) : crypt($data['current_password'],$user::getSalt());
        $data['id']=$id;
        $temp=$this->renderer->queryBuilder->setMode(0)->setTable('DBUser')
            ->setCols('DBUser',array('count(*) as dupes'))
            ->addCond('DBUser','ID',1,$id,0)
            ->executeStatement();
        if($temp[0]['dupes']>0){
            $this->createAlert('Invalid Edit!','Illegal name change exception.',false);
            //echo"illegal duplicate name<br>";
            //var_dump($temp);
        }else{//If all checks passed, goes here.
            $user->patchEntity($data);
            if($user->isValid()){
                //echo"user valid<br>";
                $user->edit($id);
                $user = $this->renderer->queryBuilder->setMode(0)->setTable('DBUser')->addCond('DBUser', 'id', '0', $id,false)->setCols('DBUser', array('id', 'Username', 'Password', 'Email', 'EndDate'))->executeStatement();
                $this->renderer->sessionManager->unsetSessionArray('User');
                $this->renderer->sessionManager->setSessionArray('User', $user[0]);
                $this->createAlert('Profile updated.','Your profile was successfully updated.',true);
            }else{
                //echo"user invalid input<br>";
                $this->createAlert('Invalid Edit!','Invalid input exception.',false);
            }

        }
        $this->httpHandler->redirect('user','user');
    }


    public function login(){
        $this::$dontRender=true;
        if($this->httpHandler->isPost() && isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] && $_POST['password']) {
            $user = $this->renderer->queryBuilder->setMode(0)->setTable('Employee')->addCond('Employee', 'Username', '0', $_POST['username'],false)->setCols('Employee', array('id', 'Username', 'Password', 'Email', 'tel','firstname','lastname'))->executeStatement();

            if ($user && password_verify($_POST['password'], $user[0]['Password'])) {
                $this->renderer->sessionManager->setSessionArray('User', $user[0]);
                $this->renderer->setAttribute('user',$user[0]);
                $this->createAlert('Logged in','Correct Credentials.',true);
                $this->httpHandler->redirect('user', 'user');
            } else {
                /*$this->renderer->sessionManager->setSessionArray('alert',array(
                    'alert'=>true,
                    'title'=>'Username or Password invalid!',
                    'content'=>'Invalid Credentials.',
                    'good'=>'false'));*/
                $this->createAlert('Username or Password invalid!','Invalid Credentials.',false);
                $this->httpHandler->redirect('user','user');

            }
        } else {
            if ($this->renderer->sessionManager->isSet('User')){
                //echo'right';
                $this->createAlert('Already logged in!','You are already logged in!',false);
                $this->httpHandler->redirect('video','index');
            }
            else{
                $this->httpHandler->redirect('user','user');
                $this->createAlert('Invalid Credentials.',
                    'Username and/or Password missing!',false);
            }
        }
    }
   /* public function usernameCheck(){
        $this::$dontRender=true;
        if($this->httpHandler->isGet()){
            $data=$this->httpHandler->getData();
            $username=$data["q"];
            $statement= $this->renderer->queryBuilder->setMode("select")->setColumns("Username")->setFromTable("DBUser")
                ->addCondition("Username","=",$username);
            $res=$statement->executeStatement();
            if($res==[]){
                echo "Username not found in Database!";
            }else{
                echo "Username was found in Database";
            }
        }
    }*/
    public function logout(){
        session_destroy();
        $this->httpHandler->redirect("user","user");
    }
    public function register(){
        $this->add();
    }
    public function user(){
        $this->renderer->headerIndex = 5;
        $id = $this->renderer->sessionManager->getSessionItem('User', 'id');
        $stmnt = $this->renderer->queryBuilder->setMode(0)->setTable("dbuser")
            ->setCols('dbuser',array('id','username','email'))
            ->addCond('dbuser','id','0',$id,'')
            ->executeStatement();
        $this->renderer->setAttribute('user',$stmnt);
            $videos=$this->renderer->queryBuilder->setMode(0)->setTable('product')
                ->addCond('product','dbuserfk',0,$id,false)
                ->executeStatement();
            $this->renderer->setAttribute('videos',$videos);

    }
    public function testDelete($id){
        $emp = new Employee();
        $emp->patchEntity(array('id'=>$id));
        $emp->delete();
    }
    public function testAdd(){
        $emp = new Employee();
        $emp->patchEntity(array('firstname'=>'test','lastname'=>'test2','email'=>'1&1@2.de','tel'=>'+420 88888888','username'=>'guydude','password'=>'admin12'));
        $emp->save();
    }
    public function testUpdate($id){
        $emp = new Employee();
        $emp->patchEntity(array('id'=>$id,'firstname'=>'doug','lastname'=>'dimmadome'));
        $emp->update();
    }
    public function testView($id){
        $emp = new Employee();
        $emp->patchEntity(array('id'=>$id));
        $emp->view();
        echo$emp->firstname;
    }
}