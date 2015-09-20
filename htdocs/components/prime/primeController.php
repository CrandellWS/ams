<?php
defined('_AMSgo') or die;

Class primeController Extends baseController {

    /**
     * This is the main controller which defaults to the dashboard if loggedin and a basic page if not.
     *
     * This should perhaps be expanded into more. Additional features for this page is non-determined at this point.
     *
     * @return void
     * @todo make better documents specially showing source such as lines 19-23
     */
    public function prime() {
        $loggedIn = $this->aReg->auth->loggedIn($this->aReg->db);
        $template = $this->aReg->config->TEMPLATE_PATH . DS . $this->aReg->config->SITE_TEMPLATE;


            /**
             * @todo data changes should be done in a model
             */
            if ($loggedIn === true) {
              $this->aReg->lastCSS = array(
                  "
                  <link rel='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/dashboard.css?v2' />"
                  ,"
                  <link rel='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/extra.css?v2' />"
                  ,"
                  <link rel ='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/carousel.css?v4' />"

                  );
                $this->aReg->template->show('prime');
            } else {
              $this->aReg->lastCSS = array(
                "
                <link rel='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/dashboard.css?v2' />"
                ,"
                <link rel='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/extra.css?v2' />"
                ,"
                <link rel ='stylesheet' type='text/css' href='".AMS_URL."templates/base/static/src/css/carousel.css?v4' />"

                );
                $this->aReg->template->show('prime');
            }
    }

}
