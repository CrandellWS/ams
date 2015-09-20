<?php
/**
 * @see _AMSgo
 */
defined('_AMSgo') or die;
$showNavbar = true;
$showCarousel = false;
$pageFooter = true;
$xml=("https://github.com/CrandellWS.atom");

function getFeed($feed_url) {
        $feeds = file_get_contents($feed_url);
        $rss = simplexml_load_string($feeds);
    return $rss;
}


function summarizeText($summary) {

    $summary = strip_tags($summary);
    // Truncate summary line to 500 characters
    $max_len = 300;
    if (strlen($summary) > $max_len)
        $summary = substr($summary, 0, $max_len);
    $summary = explode(' ', $summary);
    array_pop($summary);
    $summary = implode(' ', $summary);

    return $summary . '...';
}



function getIdTitle($title) {
    $r = preg_replace("/[^a-zA-Z]/", "", $title);
    $r = substr($r, 0, 20);
    return $r;
}

function getLettersOnly($string) {
    $r = preg_replace("/[^a-zA-Z]/", "", $string);
    return $r;
}
$rss = getFeed($xml);
?>

<div class="row row-centered">
    <div class="col-md-9 col-centered" role="main">


        <form>
            <div name="editor1" contenteditable="true">

              <?php
                  //show navbar
              if($showNavbar){
                  include( AMSDIR_BASE . DS . 'components/extras/navbar.php');
              }
              //end navbar
              ?>

                    <div class="jumbotron" itemscope itemtype="http://schema.org/BlogPosting">
                      <h2 itemprop="headline"><?php echo $rss->entry[0]->title ?></h2>

                      <div class="clearfix">
                          <p class="lead" itemprop="description"><?php

                              echo summarizeText($rss->entry[0]->content);
                              //~echo $item->description;
                          ?></p>
                          <div class="pull-right">
                              <a href="#collapseGitHubRss"
                              role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseGitHubRss"
                              class="btn btn-lg btn-success">
                                  Read The Full Post Now
                              </a>
                          </div>
                      </div>



                      <div class="collapse" id="collapseGitHubRss">
                        <div class="well">
                          <p class="lead" itemprop="articleBody">
                          <?php
                              echo $rss->entry[0]->content;
                          ?>
                          </p>

              <div itemprop="author" class="pull-right">
                  <span class="byline-author" itemscope itemtype="http://schema.org/Person">
                      Posted by
                      <span itemprop="name"><?php echo $rss->entry[0]->author->name ?></span>
                  </span>
              </div>
                          <a class="pull-left" itemprop="url" href="<?php echo $rss->entry[0]->link->attributes()->href ?>" title="link to the <?php echo $rss->entry[0]->title ?> article">link to the <?php echo $rss->entry[0]->title ?> article</a>

                          <!-- article footer -->
                          <meta itemprop="datePublished" content="<?php echo date('c', strtotime($rss->entry[0]->published))?>"/>
                        </div>
                      </div>
                    </div>

              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <?php

                  function createArtRows($rss){
                      $iNum = 0;
                      foreach($rss->entry as $item){
                          if($iNum === 0){
                              $iNum++;
                              continue;
                          }
                          $tId  = getIdTitle($item->title);
                      ?>
                    <div class="panel panel-default" itemscope itemtype="http://schema.org/BlogPosting">
                      <div class="panel-heading" role="tab" id="<?php echo $tId ?>">
                        <h4 class="panel-title" itemprop="headline">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#col<?php echo $tId ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo $item->title ?>
                          </a>
                        </h4>
                      </div>
                      <div id="col<?php echo $tId ?>" class="panel-collapse collapse <?php if($iNum == 1){echo 'in';} ?>" role="tabpanel" aria-labelledby="<?php echo $tId ?>">
                        <div class="panel-body" itemprop="articleBody">
                          <?php echo $item->content; ?>
                           <div itemprop="author" class="pull-right">
                               <span class="byline-author" itemscope itemtype="http://schema.org/Person">
                                   Posted by
                                   <span itemprop="name"><?php echo $item->author->name ?></span>
                               </span>
                           </div>
                          <a class="pull-left" itemprop="url" href="<?php echo $item->link->attributes()->href ?>" title="link to the <?php echo $rss->title ?> article">link to the <?php echo $rss->title ?> article</a>

                          <!-- article footer -->
                          <meta itemprop="datePublished" content="<?php echo date('c', strtotime($item->published))?>"/>

                          </div>
                      </div>
                    </div>

              <?php
                          $iNum++;
                      }
                  }
              createArtRows($rss);
              ?>
                          </div>

                          <p><?php echo (string) $rss->title.' '.date("m/d/Y H:i:s", strtotime((string) $rss->updated)) ?></p>

              <?php
              //start navbar
              if($pageFooter){
                  include( AMSDIR_BASE . DS . 'components/extras/footer.php');
              }
              //end navbar
              ?>
            </div>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                // CKEDITOR.disableAutoInline = true;
                // CKEDITOR.replace( 'editor1' );
            </script>
        </form>


    </div>

</div>
