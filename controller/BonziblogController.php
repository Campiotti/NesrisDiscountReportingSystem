<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 15.12.2017
 * Time: 10:28
 */

namespace controller;


use helper\fileUploader;
use models\Blog;
use services\Seed;

class BonziblogController extends BaseController implements ControllerInterface
{

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function add()
    {
        // TODO: Implement add() method.
    }

    public function view(int $id)
    {
        // TODO: Implement view() method.
    }

    public function blog(){

        //$this->renderer->setAttribute('blogs', [....])
        $statement=$this->queryBuilder->setMode("select")->setColumns(array("DBBlog.ID as ID","DBUser.ID as UserID","Title","Content","Image"))->setFromTable("DBBlog")
        ->addJoin("","DBUser","","DBUserFK","=","DBUser.ID");
        $this->renderer->setAttribute('blogs', $statement->executeStatement());
        //var_dump($this->sessionManager->getUser());
        //var_dump($this->sessionManager->getCookie("test"));
    }
    public function blogView(){
        if(!isset($_GET['blog'])){
            $this->httpHandler->redirect("BonziBlog","blog");
            die();
        }
        //BlogInfo
        $statement=$this->queryBuilder->setMode("select")->setColumns(array("DBBlog.ID","Title","Content","Image","Username","DBUser.ID"))->setFromTable("DBBlog")
            ->addJoin("left","DBUser","","DBBlog.DBUserFK","=","DBUser.ID")
            ->addCondition("DBBlog.ID","=",$_GET['blog']);
        $this->renderer->setAttribute('blog',$statement->executeStatement());

        //$this->renderer->setAttribute('blog',$statement->executeStatement());
        //Comments
        $statement=$this->queryBuilder->setMode("select")
            ->setColumns(array("DBUser.ID","Username","Content"))->setFromTable("DBComment")
            ->addJoin("","DBUser","","DBUserFk","=","DBComment.ID")
            ->addCondition("BlogFk","=",$_GET['blog']);
        $this->renderer->setAttribute('comments',$statement->executeStatement());
        //Likes
        $statement=$this->queryBuilder->setMode("select")
            ->setFromTable("DBLike")
            ->setColumns("Count(BlogFk) as Likes")
            ->addCondition("BlogFK","=",$_GET['blog']);
        $this->renderer->setAttribute('likes',$statement->executeStatement());
        $statement=$this->queryBuilder->setMode("select")
            ->setColumns("Username")
            ->setFromTable("DBUser")
            ->addJoin("left","DBBlog","Blog","DBUser.ID","=","Blog.DBUserFK")
            ->addCondition("DBUser.ID","=","3");
        $this->renderer->setAttribute("test",$statement->executeStatement());

    }

    public function checkLike(){
        $this->renderPage=false;
        if(!isset($_GET['blog']) || !$this->sessionManager->isValSet('user')){
            echo"error";
            die();
        }
        $statement = $this->queryBuilder->setMode("select")
            ->setColumns("*")
            ->setFromTable("DBLike")
            ->addCondition("DBUserFK","=",$this->sessionManager->getValue('user','ID'),"and")
            ->addCondition("BlogFK","=",$_GET['blog']);
        //var_dump($statement->getStatement());
        $res=$statement->executeStatement();
        if($res==[]){
            echo"no";
        }else{
            echo"yes";
        }


    }

    public function getLikes(){
        $this->renderPage=false;
        if(!isset($_GET['blog'])){
            echo"error while getting Likes";
            die();
        }
        $statement=$this->queryBuilder->setMode("select")
            ->setFromTable("DBLike")
            ->setColumns("Count(BlogFk) as Likes")
            ->addCondition("BlogFK","=",$_GET['blog']);
        $res=$statement->executeStatement();
        if($res==[]){
            echo"0";
        }else{
            echo$res[0]['Likes'];
        }
    }

    public function like(){
        $this->renderPage=false;
        if(!isset($_GET['blog'])){
            echo"error while getting Likes";
            die();
        }
        $statement = $this->queryBuilder->setMode("select")
            ->setColumns("*")
            ->setFromTable("DBLike")
            ->addCondition("DBUserFK","=",$this->sessionManager->getValue('user','ID'),"and")
            ->addCondition("BlogFK","=",$_GET['blog']);
        $res=$statement->executeStatement();
        if($res==[]){
            $statement=$this->queryBuilder->setMode("insert")
                ->setIntoTable("DBLike")
                ->setColumns(array("DBUserFK","BlogFK"))
                ->addInsertValueSet(array($this->sessionManager->getValue('user','ID'),$_GET['blog']));
            $statement->executeStatement();echo"liked";
        }else{
            //echo"GetBlog:".$_GET['blog'].";UserID:".$this->sessionManager->getValue('user','ID');
            $statement=$this->queryBuilder->setMode("delete")
                ->setFromTable("DBLike")
                ->addCondition("DBUserFK","=",$this->sessionManager->getValue('user','ID'),"and")
                ->addCondition("BlogFK","=",$_GET['blog']);
            $statement->executeStatement();echo"unliked";
        }


    }

    public function resetDB(){
            //Without logged in User just set the attribute noUser to true in the url and it will let you bypass [totally not a security backdoor]
            if(isset($_GET['noUser'])){
                if($_GET['noUser']!="true"){
                    $this->httpHandler->redirect("BOnzIBlOg","Blog");
                    die();
                }
            }elseif($this->sessionManager->getValue("user","Role")!="admin"){
                $this->httpHandler->redirect("BOnzIBlOg","Blog");
                die();
            }
                $seed = new Seed();
                $seed->resetDB();
                $this->httpHandler->redirect("user","login");

    }
    public function addBlog(){
        if(!$this->sessionManager->isValSet('user')){
            $this->httpHandler->redirect("user","login");
        }
        if($this->httpHandler->isPost()){
            $filename="";
            $data=$this->httpHandler->getData();
            if(count($_FILES)>0) {
                $fileuploader = new fileUploader();
                $filename = $fileuploader->upload($_FILES['image']);
            }
            $blog = new Blog();
            $data['image']=$filename;
            $data['content']=trim($data['content']);
            $data['title']=trim($data['title']);
            $data['DBUserFK']=$this->sessionManager->getValue('user','ID');
            $blog->patchEntity($data);
            $blog->save();
            $this->httpHandler->redirect("bonziblog","blog");
        }
    }
    public function JsonDB(){
        //Disables Header,Page&Footer loading.
        $this->renderPage=false;
        $statement=$this->queryBuilder->setMode("select")
            ->setColumns("*")
            ->setFromTable("DBUser");
        $users=$statement->executeStatement();

        $statement=$this->queryBuilder->setMode("select")
            ->setColumns("*")
            ->setFromTable("DBBlog");
        $blogs=$statement->executeStatement();
        //blogs is veri much filled with the xss prevented database entries which prevents them being turned inrto **JAYSON** obejtks
        $statement=$this->queryBuilder->setMode("select")
            ->setColumns("*")
            ->setFromTable("DBLike");
        $likes=$statement->executeStatement();

        $statement=$this->queryBuilder->setMode("select")
            ->setColumns("*")
            ->setFromTable("DBComment");
        $comments=$statement->executeStatement();
        $statement=$this->queryBuilder->setMode("select")
            ->setFromTable("DBRole")
            ->setColumns("*");
        $roles=$statement->executeStatement();
        echo json_encode(['users' => $users, 'likes' => $likes, 'comments' => $comments, 'roles' => $roles]);
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function edit(int $id)
    {
        // TODO: Implement edit() method.
    }
}