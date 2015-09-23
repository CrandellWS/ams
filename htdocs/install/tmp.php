
<script>
  function swapConfig(x) {
    var radioEls = document.getElementsByName(x.name);
    for(i = 0 ; i < radioEls.length; i++){
      document.getElementById(radioEls[i].id.concat("Settings")).style.display="none";
    }
    document.getElementById(x.id.concat("Settings")).style.display="initial";
  }


function updateValues(caller, className){
  callerValue = caller.value;
  classEls=document.getElementsByClassName(className);  // Find the elements
  for(var i = 0; i < classEls.length; i++){
    classEls[i].innerText=callerValue;    // Change the content
  }
}
</script>
<style>
label{
  display:inline-block;
  width:100%;
}

input{
  display:block;
}

fieldset{
  display:block;
}

.wrap {
  text-align: center;
}

.outer {
  display: inline-block;
  margin: 0 auto;
  min-width: 300px;
}

.inner {
  text-align: left;
}

.clearspace{
  padding-top: 1em;
  clear:both;
}

.inLabel{
  overflow:hidden;
  background: #ccc;
}

.inBlockRight{
  float: right;
  display:inline-block;
}

.inBlockLeft{
  float: left;
  display:inline-block;
}

.blockOfHid{
  display: block;
  overflow: hidden;
}

.width100{
  width:100%;
}
.text-center{
  text-align: center;
  display:inline-block;
}
</style>

<div class='wrap'>
    <div class='outer'>
        <div class='inner'>
          <form name="Config Creation" method="post" action="">
            <fieldset>
              <legend>MySQL Database Configuration</legend>
              <label>Database Host:
                <div class="inLabel">
                    <span class="inBlockRight"></span>
                    <span class="inBlockLeft"></span>
                    <span class="blockOfHid">
                        <input class="width100" type="text" name="dbhost" placeholder="localhost or localhost;port=3307" value="">
                    </span>
                </div>
                <span class="text-center width100">(Do Not Include http:// or https://)</span>
              </label>
              <div class="clearSpace"></div>
              <label>Database Name:
                <div class="inLabel">
                    <span class="inBlockRight"></span>
                    <span class="inBlockLeft"></span>
                    <span class="blockOfHid">
                        <input class="width100" type="text" name="dbname" placeholder="dbname" value="sample1">
                    </span>
                </div>
              </label>
              <div class="clearSpace"></div>
              <label>Database Username:
                <div class="inLabel">
                    <span class="inBlockRight"></span>
                    <span class="inBlockLeft"></span>
                    <span class="blockOfHid">
                        <input class="width100" type="text" name="dbuser" placeholder="username" value="user1">
                    </span>
                </div>
              </label>
              <div class="clearSpace"></div>
              <label>Database Pass:
                <div class="inLabel">
                    <span class="inBlockRight"></span>
                    <span class="inBlockLeft"></span>
                    <span class="blockOfHid">
                        <input class="width100" type="password" name="dbpass" placeholder="password1" value="password1">
                    </span>
                </div>
              </label>
              <div class="clearSpace"></div>
            </fieldset>
            <div class="clearSpace"></div>
            <fieldset>
              <legend>User Configuration</legend>
              <label>Site Name:
                <div class="inLabel">
                    <span class="inBlockRight"></span>
                    <span class="inBlockLeft"></span>
                    <span class="blockOfHid">
                        <input class="width100" type="text" name="sitename" placeholder="Company Name" value="">
                    </span>
                </div>
              </label>
            </fieldset>
            <div class="clearSpace"></div>
            <fieldset>
              <legend>Url and Domain Configuration</legend>
              <label style="display:block">
                <span style="display:block; "><input style="display:inline-block" type="radio" onchange="swapConfig(this)" name="urlOptions" id="production" checked="checked" value="production"/> Production</span>
              </label>
              <label style="display:block">
                  <span style="display:block"><input style="display:inline-block" type="radio" onchange="swapConfig(this)" name="urlOptions" id="development" value="development"/> Development</span>
              </label>
              <div class="clearSpace"></div>
              <div id="productionSettings">
                <fieldset>
                  <legend>Prefered Protocol</legend>
                    <div class="inLabel">
                      <span class="inBlockRight">
                        <label><input type="radio" name="preferedProtocol" id="https" value="https://" onchange="updateValues(this, 'HtVal')" /> https:// </label>
                      </span>
                      <span class="inBlockLeft">
                        <label ><input type="radio" name="preferedProtocol" id="http" value="http://" onchange="updateValues(this, 'HtVal')" checked="checked" /> http:// </label>
                      </span>
                      <span class="blockOfHid"><p class="width100"></p></span>
                  </div>
                </fieldset>
                <div class="clearSpace"></div>
                <label>Domain:
                  <div class="inLabel">
                      <span class="inBlockRight">/</span>
                      <span class="inBlockLeft HtVal">http://</span>
                      <span class="blockOfHid">
                          <input class="width100" type="text" name="proDomain" placeholder="localhost" value="locahost" onchange="updateValues(this, 'domain')">
                      </span>
                  </div>
                  <span class="text-center width100">(Do Not Include http:// or https://)</span>
                </label>
                <div class="clearSpace"></div>
                <label>AMS Url Root Directory:
                  <div class="inLabel">
                      <span class="inBlockLeft"><span class="HtVal">http://</span><span class="domain">locahost</span></span>
                      <span class="inBlockLeft">/</span>
                      <span class="blockOfHid">
                          <input class="width100" type="text" name="amsFolder" placeholder="ams" value="" onchange="updateValues(this, 'amsFolder')">
                      </span>
                  </div>
                  <span class="text-center width100">(blank if using root directoy)</span>
                </label>
                <div class="clearSpace"></div>
                <label>SEO Root Folder:
                  <div class="inLabel">
                      <span class="inBlockLeft"><span class="HtVal">http://</span><span class="domain">locahost</span></span>
                      <span class="inBlockLeft">/</span>
                      <span class="blockOfHid">
                          <input class="width100" type="text" name="seoFolder" placeholder="ams" value="">
                      </span>
                  </div>
                  <span class="text-center width100">(blank if using root directoy)</span>

                </label>
                <div class="clearSpace"></div>
                <label>Template Folder:
                  <div class="inLabel">
                      <span class="inBlockLeft"><span class="HtVal">http://</span><span class="domain">locahost</span></span>
                      <span class="inBlockLeft">/</span>
                      <span class="blockOfHid">
                          <input class="width100" type="text" name="templateFolder" placeholder="templates" value="">
                      </span>
                  </div>
                </label>
              </div>
              <div class="clearSpace"></div>
              <div id="developmentSettings" style="display:none">
                <p>
                  <label>????
                    <input type="text" name="wth" value="/">
                  </label>
                </p>
              </div>
              <div class="clearSpace"></div>
            </fieldset>
            <input type="submit" value="Create Config"><input type="reset" value="Reset">
          </form>
        </div>
    </div>
</div>

<?php


echo '<pre>';

print_r($_POST);

echo '</pre>';

echo '<pre>';

echo '

$domain = $_SERVER[\'HTTP_HOST\'];
$docRoot = realpath($_SERVER[\'DOCUMENT_ROOT\']);
$dirRoot = __DIR__;
/**
 * @todo convert ssl to configurable across whole application
 */
$urlDir = str_replace("includes", "",str_replace($docRoot, "", $dirRoot));
$urlDir = str_replace("\\\\", "/" ,$urlDir);
$site_path = "//".$domain.$urlDir;
define ("AMS_URL", $site_path);
define ("AMS_SEO_URL", AMS_URL);
define( "TEMPLATE_PATH", "templates" );
define( "TEMPLATE", "base" );
define( "DEVELOPMENT_ENVIRONMENT", true);
define( "PREFERED_PROTOCOL", "http:" );
';

echo '</pre>';




 ?>
