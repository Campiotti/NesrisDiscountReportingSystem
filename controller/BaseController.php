<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.10.2017
 * Time: 09:11
 */

namespace controller;

/**
 * Database strandkorb
 * name, bild, tagsystem, discount, stockcount, price, weight, display, (time - 2-5days), date
 * kommen in lager - liquidation falls discount > 0
 */

use services\DatabaseSeed;

class BaseController
{
    protected $renderer;
    public $httpHandler;
    public $viewTemplate;
    protected $queryResult;
    public $controllerName;
    protected static $dontRender;
    private static $alerts;

    public function getQueryResult(){
        return$this->queryResult;
    }

    /**
     * BaseController constructor.
     * Called every time any page is called.
     * Creates a new renderer which will load the visual page
     * a new httpHandler which is used by many controllers
     * and it also starts a new session in the sessionManager as well as turns on rendering of the page.
     */
    public function __construct()
    {
        $this->renderer = new \Viewrenderer($this);
        $this->httpHandler  = new HttpHandler();
        $this->renderer->sessionManager->startSession();
        $this::$dontRender = false;
    }

    public function getController(){
        return$this;
    }

    /**
     * BaseController destructor.
     * Called upon once the other controllers ran the called function
     * renders the base header, the page itself and then the base footer.
     */
    public function __destruct()
    {
        if (!BaseController::$dontRender){
            //$this->setAlerts();
            $this->renderer->renderLayout('header.php');
            $this->renderer->renderByFileName("/view/" .$this->controllerName . "/" . $this->viewTemplate);
            $this->renderer->renderLayout('footer.php');
        }

    }

    /**
     * PHP function to create the alert message which is called upon page load and then cleared.
     * @param string $title title of the alert which are displayed in large text at the top of the message.
     * @param string $content contents of the alert which are displayed in smaller text in the midst of the message.
     * @param bool $good boolean good (or bad), used to set the color depending on if it's a positive or negative message.
     */
    public function createAlert(string $title,string $content,bool $good){
        BaseController::$dontRender=true;
        $good = ($good==true || $good==1)? 'true' : 'false';
        $temp=array('alert'=>true,'title'=>$title,'content'=>$content,'good'=>$good);
        BaseController::$alerts=$temp;
        $this->renderer->sessionManager->setSessionArray('alert',$temp);

    }

    /**
     * This method is used to reset the Database
     * It can only be called if an Admin is logged in
     * or bypassed is the $_GET['bypass'] variable is set
     */
    public function resetDatabase(){

        if (($this->renderer->sessionManager->isSet('User') && $this->renderer->sessionManager->getSessionItem('User', 'RoleName') == 'Admin') || isset($_GET['bypass'])){
            $dbseed = new DatabaseSeed();
            $dbseed->resetDatabase();
        }
        $this->httpHandler->redirect('base', 'index');
    }
    /**
     * Throwaway function used to update the header index so the page looks right
     */
    public function about()
    {
        $this->renderer->headerIndex = 1;
    }
    /**
     * Throwaway function used to update the header index so the page looks right
     */
    public function contact (){
        $this->renderer->headerIndex = 4;
    }

    /**
     * Throwaway function used to update the header index so the page looks right
     */
    public function partners(){
        $this->renderer->headerIndex = 3;
    }

    /**
     * filter function used to filter videos by their tags,names, or uploaders.
     * @param $mode int mode which defines if the search is done through tags,authors or video-names.
     * @param $val string value which is being searched with.
     */
    public function filter($mode, $val){
        $this::$dontRender = true;
        $val = '%'.$val.'%';
        switch($mode){
            case 1:
                $res = $this->renderer->queryBuilder->setMode(0)->setTable('product')
                    ->setCols('product', array('id', 'productname', 'image', 'description'))
                    ->joinTable('product_tag', 'product', 0, 'productfk', true)
                    ->joinTable('tags', 'product_tag', 0, 'tagsfk')
                    ->addCond('tags', 'tagname', 6, $val, false)
                    ->groupBy(array('product_tag.productfk'))
                    ->orderBy(array('product.id'))
                    ->executeStatement();
                break;
            case 2:
                $res = $this->renderer->queryBuilder->setMode(0)->setTable('product')
                    ->setCols('product', array('id', 'productname', 'image', 'description'))
                    ->joinTable('dbuser', 'product', 0, 'dbuserfk')
                    ->addCond('dbuser', 'username', 6, $val, false)
                    ->executeStatement();
                break;
            case 3:
                $res = $this->renderer->queryBuilder->setMode(0)->setTable('product')
                    ->setCols('product', array('id', 'productname', 'image', 'description'))
                    ->addCond('product', 'productname', 6, $val, false)
                    ->executeStatement();
                break;
            default:
                $res = $this->renderer->queryBuilder->setMode(0)->setTable('product')->setCols('product', array('id', 'productname', 'image', 'description'))->executeStatement();
                break;
        }

        echo json_encode($res);
        die();
    }

}