<?php defined('_AMSgo') or die; ?>
<h1><?php echo $header; ?></h1>

<?php 

if(isset($this->aReg->exception)){
    foreach ($this->aReg->exception as $error){
        throw new Exception('Error |-->'.$error);
    }
}
if(isset($this->aReg->error)){
    echo $this->aReg->error;
} else {
    if (isset($_GET['err'])){
        $err = filter_var($_GET['err'], FILTER_SANITIZE_STRING);
        print_r('<pre>'.print_r($err, true).'</pre>');
    }
    ?>
<p>An has error Occurred.</p>
<p>No further information is available.</p>
<?php 

}
