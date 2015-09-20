<?php
defined('_AMSgo') or die;

Class errorController Extends baseController {

    public function prime()
    {
        $setTest = is_array($this->aReg->error);
        if($setTest){
            $arrayTest = array_key_exists('404', $this->aReg->error);
            if ($arrayTest){
                $this->err404();
            } else {
                $this->aReg->template->header = 'Error Occured';
                $this->aReg->template->show('error');
            }
        } else {
            $this->aReg->template->header = 'Error Occured';
            $this->aReg->template->show('error');
        }
    }

    public function err404()
    {
            $this->aReg->template->header = '404 Error Occured';
            $this->aReg->template->show('error404');
    }

    // public function error404() 
    // {
    //         $this->aReg->template->header = '404 Error Occured';
    //         $this->aReg->template->show('error404');
    // }


}
?>
