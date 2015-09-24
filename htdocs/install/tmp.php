
<script src='install.js' type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href='install.css'>
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
              <div class="clearSpace"></div>
              <label>Site Name:
                <div class="inLabel">
                    <span class="inBlockRight"></span>
                    <span class="inBlockLeft"></span>
                    <span class="blockOfHid">
                        <input class="width100" type="text" name="userName" placeholder="user" value="">
                    </span>
                </div>
              </label>
              <div class="clearSpace"></div>
              <label>User Password:
                <div class="inLabel">
                    <span class="inBlockRight"></span>
                    <span class="inBlockLeft"></span>
                    <span class="blockOfHid">
                        <input class="width100" type="password" name="userPassword" placeholder="password" value="">
                    </span>
                </div>
              </label>
              <div class="clearSpace"></div>
              <label>User Email:
                <div class="inLabel">
                    <span class="inBlockRight"></span>
                    <span class="inBlockLeft"></span>
                    <span class="blockOfHid">
                        <input class="width100" type="email" name="userEmail" placeholder="user@ams.localhost" value="">
                    </span>
                </div>
              </label>
            </fieldset>
            <div class="clearSpace"></div>
            <fieldset>
              <legend>Url and Domain Configuration</legend>
              <fieldset>
                <legend>Configuration Type</legend>
                <div class="inLabel">
                  <span class="inBlockRight">
                    <label>
                      <input type="radio" onchange="swapConfig(this)" name="urlOptions" id="production" checked="checked" value="production"/>
                      <span class="sm-lr-pad"> Production </span>
                    </label>
                  </span>
                  <span class="inBlockLeft">
                    <label>
                      <input type="radio" onchange="swapConfig(this)" name="urlOptions" id="development" value="development"/>
                      <span class="sm-lr-pad"> Development </span>
                    </label>
                  </span>
                  <span class="blockOfHid"><p class="width100"></p></span>
                </div>
              </fieldset>
              <div class="clearSpace"></div>
              <div id="productionSettings">
                <fieldset>
                  <legend>Prefered Protocol</legend>
                    <div class="inLabel">
                      <span class="inBlockRight">
                        <label>
                          <input type="radio" name="preferedProtocol" id="https" value="https://" onchange="updateValues(this, 'HtVal')" />
                          <span class="sm-lr-pad"> https:// </span>
                        </label>
                      </span>
                      <span class="inBlockLeft">
                        <label>
                          <input type="radio" name="preferedProtocol" id="http" value="http://" onchange="updateValues(this, 'HtVal')" checked="checked" />
                          <span class="sm-lr-pad"> http:// </span>
                        </label>
                      </span>
                      <span class="blockOfHid"><p class="width100"></p></span>
                  </div>
                </fieldset>
                <div class="clearSpace"></div>
                <label>Domain:
                  <div class="inLabel">
                      <span class="inBlockRight"></span>
                      <span class="inBlockLeft HtVal">http://</span>
                      <span class="blockOfHid">
                          <input class="width100" type="text" name="proDomain" placeholder="localhost" value="locahost" onchange="updateValues(this, 'domain')">
                      </span>
                  </div>
                  <span class="text-center width100"><span class="sm-lr-pad">Do Not Include http:// or https://</span></span><br/>
                  <span class="text-center width100"><span class="sm-lr-pad">Do Not Include Trailing /</span></span>
                </label>
                <div class="clearSpace"></div>
                <label>AMS Url Root Directory:
                  <div class="inLabel">
                      <span class="inBlockRight"></span>
                      <span class="inBlockLeft"><span class="sm-lr-pad"><span class="HtVal">http://</span><span class="domain">locahost/</span></span></span>
                      <span class="blockOfHid">
                          <input class="width100" type="text" name="amsFolder" placeholder="ams" value="" onchange="updateValues(this, 'amsFolder')">
                      </span>
                  </div>
                  <span class="text-center width100"><span class="sm-lr-pad">Leave Blank if Using Root Directoy</span></span><br/>
                  <span class="text-center width100"><span class="sm-lr-pad">index.php?a= if No mod_rewrite</span></span>
                </label>
                <div class="clearSpace"></div>
                <label>SEO Root Folder:
                  <div class="inLabel">
                      <span class="inBlockRight"></span>
                      <span class="inBlockLeft"><span class="HtVal">http://</span><span class="domain">locahost/</span></span>
                      <span class="blockOfHid">
                          <input class="width100" type="text" name="seoFolder" placeholder="ams" value="">
                      </span>
                  </div>
                  <span class="text-center width100"><span class="sm-lr-pad">Leave Blank if Using Root Directoy</span></span>

                </label>
                <div class="clearSpace"></div>
                <label>Template Folder:
                  <div class="inLabel">
                      <span class="inBlockRight">/</span>
                      <span class="inBlockLeft"><span class="HtVal">http://</span><span class="domain">locahost/</span><span class="amsFolder"></span></span>
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
            <div class="clearSpace"></div>
            <fieldset>
              <legend>Display Errors</legend>
              <div class="inLabel">
                <span class="inBlockRight">
                  <label><span class="sm-lr-pad"><input type="radio" name="displayErrors" id="On" value="On" checked="checked" /> On </span></label>
                </span>
                <span class="inBlockLeft">
                  <label><span class="sm-lr-pad"><input type="radio" name="displayErrors" id="Off" value="Off" /> Off </span></label>
                </span>
                <span class="blockOfHid"><p class="width100"></p></span>
              </div>
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
if($_POST[seoFolder] !== '')
var_dump($_POST[seoFolder]);
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
