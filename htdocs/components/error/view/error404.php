<?php defined('_AMSgo') or die; ?>
<div class="container-fluid">
    <div class="well-lg">
        <div class="panel">
            <div class="panel-heading btn-danger"><pre><?php print_r($header); ?></pre></div>
            <div class="panel-body bg-danger">
            <h3>You found the 404 error page.</h3>
<?php
if(isset($exception)){
    foreach ($exception as $error){
        throw new Exception('Error |-->'.print_r($error, true));
    }
}
if(isset($this->aReg->error['404'])){
    if(isset($this->aReg->error['controller'])){
        echo '<h3>This content type can not be found</h3><p><pre>'.print_r($this->aReg->error['controller'], true).'</pre></p>';
        if(isset($this->aReg->error['model'])){
            if($this->aReg->error['model'] !== 'prime')
            echo '<h3>This category type can not be found</h3><p><pre>'.print_r($this->aReg->error['model'], true).'</pre></p>';
        }
        if(isset($this->aReg->error['action'])){
            echo '<h3>This item can not be found</h3><p><pre>'.print_r($this->aReg->error['action'], true).'</pre></p>';
        }
    } else {
        echo '<p> That was a bad web address</p>';
    }
} else {
?>
        <p> That was a bad url.</p>
<?php
}
?>
            </div>
        </div>
    </div>
</div>
