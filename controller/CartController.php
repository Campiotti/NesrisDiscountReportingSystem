<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 31.01.2018
 * Time: 09:28
 */

namespace controller;



class CartController extends BaseController
{
    function cart(){
        if ($this->renderer->sessionManager->isSet('User')){
            $this->renderer->headerIndex = 7;
            $statement = $this->renderer->queryBuilder->setMode(0)->setTable('dbuser')
                ->setCols('product', array('productname', 'image', 'description', 'price', 'discount'))
                ->setCols('cart', array('id', 'amount'))
                ->joinTable('cart', 'dbuser', '0', 'userfk', true)
                ->joinTable('product', 'cart', '0', 'productfk')
                ->addCond('cart','userfk',0,$this->renderer->sessionManager->getSessionItem('User','id'),false)
                ->executeStatement();
            $this->renderer->setAttribute('cart', $statement);
        } else {
            $this->httpHandler->redirect('base', 'index');
        }
    }

    function changeAmount($id, $newAmount){
        $this::$dontRender = true;

        if ($id > 0){
            $stock = $this->renderer->queryBuilder->setMode(0)->setTable('cart')
                ->setCols('product', array('stock'))
                ->joinTable('product', 'cart', 0, 'productfk')
                ->addCond('cart', 'id', 0, $id, 0)
                ->addCond('cart', 'userfk', 0, $this->renderer->sessionManager->getSessionItem('User', 'id'), 'true')
                ->executeStatement()[0]['stock'];

            if ($newAmount <= $stock && $newAmount > 0){
                $this->renderer->queryBuilder->setMode(1)->setTable('cart')
                    ->setColsWithValues('cart', array('amount'), array($newAmount))
                    ->addCond('cart', 'id', 0, $id, 'true')
                    ->addCond('cart', 'userfk', 0, $this->renderer->sessionManager->getSessionItem('User', 'id'), 'true')
                    ->executeStatement();
                echo$newAmount;
            }
        }
    }

    function remove($id){
        $this::$dontRender=true;
        if ($id > 0){
            $this->renderer->queryBuilder->setMode(3)->setTable('cart')
                ->addCond('cart', 'id', 0, $id, 'true')
                ->addCond('cart', 'userfk', 0, $this->renderer->sessionManager->getSessionItem('User', 'id'), 'true')
                ->executeStatement();
            $this->renderer->sessionManager->setSessionArray('alert',array(
                'alert'=>true,
                'title'=>'Item has been removed from your cart.',
                'content'=>'Item successfully removed',
                'good'=>'true'));
            $this->httpHandler->redirect('cart', 'cart');
        }
    }

    function addCart($id){
        $this::$dontRender=true;
        if ($id > 0 && $this->httpHandler->isPost()){
            // get stock of product
            $stock = $this->renderer->queryBuilder->setMode(0)->setTable('product')
                ->addCond('product', 'id', '0', $id, false)
                ->executeStatement()[0]['Stock'];
            $data = $this->httpHandler->getData();
            if ($data['amount'] > 0){
                // check if item is already in cart
                $amount = $this->renderer->queryBuilder->setMode(0)->setTable('cart')
                    ->addCond('cart', 'productFk', '0', $id, true)
                    ->addCond('cart', 'userfk', 0, $this->renderer->sessionManager->getSessionItem('User', 'id'), 'false')
                    ->executeStatement()[0];
                if ($amount['Amount'] > 0){
                    $newAmount = ($data['amount'] + $amount['Amount'] >= $stock) ? $stock : $data['amount'] + $amount['Amount'];
                    $this->changeAmount($amount['ID'], $newAmount);
                } else {
                    $newAmount = ($data['amount'] >= $stock) ? $stock : $data['amount'];
                    $this->renderer->queryBuilder->setMode(2)->setTable('cart')
                        ->setColsWithValues('cart', array('id', 'productfk', 'userfk', 'amount'), array('', $id, $this->renderer->sessionManager->getSessionItem('User', 'id'), $newAmount))
                        ->executeStatement();
                }

                $this->httpHandler->redirect('cart', 'cart');
            } else {
                $this->httpHandler->redirect('video', 'products');
            }
        }
    }

    public function buyCart(){
        $this::$dontRender=true;
        if(!$this->renderer->sessionManager->isSet('User')){
            $this->httpHandler->redirect('base','index');
            die("not logged in!");
        }
        $statement=$this->renderer->queryBuilder->setMode(0)
            ->setTable('cart')
            ->joinTable('product','cart',0,'productfk')
            ->setCols('product',array('stock','id'))
            ->setCols('cart',array('amount','id cartID'))
            ->orderBy(array('cart.id'))
            ->addCond('cart','userfk',0,$this->renderer->sessionManager->getSessionItem('User','id'),false)
            ->executeStatement();
        foreach($statement as $item){
            if($item['amount']<=$item['stock']){
                $this->changeStock($item['id'],$item['stock']-$item['amount']);
                $this->remove($item['cartID']);
            }
        }

    }
    private function changeStock($productID,$amount){
        $this::$dontRender=true;
        if($amount<0)
            return;
        $this->renderer->queryBuilder->setMode(1)
            ->setTable('product')
            ->setColsWithValues('product',array('stock'),array($amount))
            ->addCond('product','id',0,$productID,false)
            ->executeStatement();
    }
}