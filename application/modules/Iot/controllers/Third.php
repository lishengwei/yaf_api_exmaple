<?php
/**
 * Created by PhpStorm.
 * User: lishengwei
 * Date: 18-3-20
 * Time: 下午5:36
 */

class ThirdController extends Yaf_Controller_Abstract
{
    public function serviceAction ()
    {
        $a = new SampleModel();
        echo $a->selectSample() . "\r\n";
        $b = new iot\SampleModel();
        echo $b->selectSample();
    }
}