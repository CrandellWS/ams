<?php

/*
 * The MIT License
 *
 * Copyright 2014 William Crandell <dev at crandell.ws>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


defined('_AMSgo') or die;

if ($_SESSION['userTypeID'] === 1 || $_SESSION['userTypeID'] === 2 ) {
?>

<ul class="nav nav-tabs pull-right" style="margin-right:20px">
<?php
    if ($_SESSION['userTypeID'] === 1 ) {
?>

  <li id="importTab" ><a class="btn-info" href="<?php echo AMS_SEO_URL ?>user/manage/addUsers">Add Users</a></li>

<?php
    }
?>
  <li id="manageTab"><a class="btn-info" href="<?php echo AMS_SEO_URL ?>user/manage">Users</a></li>
</ul>
<?php

}
