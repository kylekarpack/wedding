<?php include("header.php"); ?>

<div class="container">
	<h1>Wedding Registry</h1>
    <p>Thanks for thinking of us! Click any one of these to see our registries. The universal registry contains items that aren't online if you'd prefer to go to a store.</p>

    <div class="registries">
        <a class="reg" href="#" data-show="amazon">
            <img src="img/amazon.jpg" />
        </a>


	    <a class="reg" href="#" data-show="universal">
		    <img src="img/universal.png" />
	    </a>

    </div>

    <div class="clear"></div>


    <div class="amazon">
        <h2>Amazon</h2>

        <?php
        require("database.php");

        $DOM = new DOMDocument();

        try {
            $content = file_get_contents("http://www.amazon.com/registry/wedding/S1EIMOHHAKPF");
        } catch(Exception $e) {
            die("Could not retrieve registry at this time, sorry");
        }
        libxml_use_internal_errors(true);
        $DOM->loadHTML($content);
        while (($r = $DOM->getElementsByTagName("script")) && $r->length) {
            $r->item(0)->parentNode->removeChild($r->item(0));
        }
        $tbls = $DOM->getElementsByTagName("table");
        $styles = $DOM->getElementsByTagName("style");

        ?>

        <style>
            img {-webkit-filter:none;}
            h2 {font-size: 36px;
                margin: 2% 0 0;}
            td {vertical-align: top;
                padding-top: 20px;}
            td.tiny {float:left;padding:0 0 10px;}
            .wrcSpacer, .commentBlock { display:none; }
            td[colspan='5'] {
                padding-top: 0;
            }
            .iterator-item-separator {
                display:none;
            }
            }
            <?php
        foreach($styles as $s) {
            // String processing
            $str = (str_replace("<!--", "", $s->nodeValue));
            $str = (str_replace("-->", "", $str));
            $str = (str_replace("body", "tk", $str));
            $str = (str_replace("nav", "tk", $str));
            $str = (str_replace("a:visited", "tk", $str));
            $str = (str_replace("a:hover", "tk", $str));
            $str = (str_replace("font-family", "tk", $str));

            echo $str;
        }
        ?>
        </style>
        <?php

        foreach ($tbls as $tbl) {
            if($tbl -> getAttribute('class') == "wrcItemTable")  {
                echo "<table>";
                $str = str_replace("/gp", "http://amazon.com/gp", DOMinnerHTML($tbl));
                $str = (str_replace("onmouseout", "tk", $str));
                $str = (str_replace("onmouseover", "tk", $str));
                echo($str);

                echo "</table>";
            }
        }
        ?>
    </div>


    <div class="universal">
        <h2>Universal Registry<small>Generally things found in-store only</small></h2>

	    <?php

	    // Run a query
	    $STH = $DBH->query("select * from registry");
	    $STH->setFetchMode(PDO::FETCH_ASSOC);

	    if ($STH->rowCount() < 1) {
		       echo "Nothing here! Thanks guys!";
	    } else {
		    while($row = $STH->fetch()) {
		        if ($row["desired"] > 0) { ?>
		        <div class="item">
		            <img src="<?php echo $row['img']; ?>" />

		            <a class="title" href="<?php echo trim($row['link']) == "" ? "#" : $row["link"]; ?>">
		                 <?php echo $row['title']; ?>
		            </a>
		            <p class="wlPriceBold">
		                $<?php echo $row['price']; ?>
		            </p>

			        <p>
				        <b>Desired:</b> <span class="desired"><?php echo $row['desired']; ?></span>
			        </p>
			        <p>
				        <b>Found at:</b> <span class="desired"><?php echo $row['where']; ?></span>
			        </p>
			        <p style="margin-top:15px">
				        <?php echo $row['desc']; ?>
			        </p>
		            <div class="purchased">
		                <button class="purchase" data-id="<?php echo $row['ind']; ?>">I bought this!</button><img src="img/loading.gif" style="display:none;margin:10px;"/>
		            </div>
		        </div>
		        <?php } ?>
		    <?php  }
	    }?>

    </div>

</div>

<?php include("footer.html"); ?>

<style>
    .swSprite { display: -moz-inline-box; display: inline-block; margin: 0;padding: 0; position: relative; overflow: hidden; vertical-align: middle; background: url(http://g-ecx.images-amazon.com/images/G/01/common/sprites/sprite-site-wide-3._V375430972_.png) no-repeat; }
    .swSprite span { position: absolute; left: -9999px; }
    .pageGradientTop { background: url(http://g-ecx.images-amazon.com/images/G/01/common/sprites/sprite-site-wide-3._V375430972_.png) repeat-x scroll 0 -240px; height: 15px; }
    .pagGradientBottom { background: url(http://g-ecx.images-amazon.com/images/G/01/common/sprites/sprite-site-wide-3._V375430972_.png) repeat-x scroll 0 -220px; height: 18px; }
    .s_starBrandBigFull  { background-position: -280px -261px; width: 32px;height: 30px; }
    .s_starBrandBigHalf  { background-position: -244px -261px; width: 32px;height: 30px; }
    .s_starBrandBigEmpty { background-position: -211px -261px; width: 32px;height: 30px; }
    .s_starBrandSmallFull  { background-position: -52px -299px; width: 16px;height: 15px; }
    .s_starBrandSmallHalf  { background-position: -68px -299px; width: 16px;height: 15px; }
    .s_starBrandSmallEmpty { background-position: -84px -299px; width: 16px;height: 15px; }
    .s_starSmallFull  { background-position: -30px 0px; width: 13px;height: 13px; }
    .s_starSmallHalf  { background-position: -82px -20px; width: 13px;height: 13px; }
    .s_starSmallEmpty { background-position: -95px 0px; width: 13px;height: 13px; }
    .s_star_0_0 { background-position: -95px 0px; width: 65px;height: 13px; }
    .s_star_0_5 { background-position: -82px -20px; width: 65px;height: 13px; }
    .s_star_1_0 { background-position: -82px 0px; width: 65px;height: 13px; }
    .s_star_1_5 { background-position: -69px -20px; width: 65px;height: 13px; }
    .s_star_2_0 { background-position: -69px 0px; width: 65px;height: 13px; }
    .s_star_2_5 { background-position: -56px -20px; width: 65px;height: 13px; }
    .s_star_3_0 { background-position: -56px 0px; width: 65px;height: 13px; }
    .s_star_3_5 { background-position: -43px -20px; width: 65px;height: 13px; }
    .s_star_4_0 { background-position: -43px 0px; width: 65px;height: 13px; }
    .s_star_4_5 { background-position: -30px -20px; width: 65px;height: 13px; }
    .s_star_5_0 { background-position: -30px 0px; width: 65px;height: 13px; }
    .s_chevron { background-position: -30px -40px; width: 11px; height: 11px; }
    .s_goTan { background-position: -50px -40px; width: 21px; height: 21px; }
    .s_email { background-position: -80px -40px; width: 16px; height: 11px; }
    .s_rss { background-position: -100px -40px; width: 12px; height: 12px; }
    .s_extLink { background-position: -120px -40px; width: 15px; height: 13px; }
    .s_close { background-position: -140px -40px; width: 15px; height: 15px; }
    .s_collapseChevron { background-position: -30px -60px; width: 9px; height: 9px; }
    .s_expandChevron { background-position: -40px -60px; width: 9px; height: 9px; }
    .s_comment { background-position: -80px -60px; width: 16px; height: 15px; }
    .s_expand { background-position: -100px -60px; width: 14px; height: 14px; }
    .s_collapse { background-position: -120px -60px; width: 14px; height: 14px; }
    .s_shvlBack { background-position: -30px -80px; width: 25px; height: 50px; }
    .s_shvlBackClick { background-position: -30px -130px; width: 25px; height: 50px; }
    .s_shvlNext { background-position: -60px -80px; width: 25px; height: 50px; }
    .s_shvlNextClick { background-position: -60px -130px; width: 25px; height: 50px; }
    .s_shvlBackSm { background-position: -90px -80px; width: 20px; height: 40px; }
    .s_shvlBackSmClick { background-position: -90px -120px; width: 20px; height: 40px; }
    .s_shvlNextSm { background-position: -110px -80px; width: 20px; height: 40px; }
    .s_shvlNextSmClick { background-position: -110px -120px; width: 20px; height: 40px; }
    .s_play { background-position: -140px -80px; width: 20px; height: 20px; }
    .s_pause { background-position: -140px -100px; width: 20px; height: 20px; }
    .s_playing { background-position: -140px -120px; width: 20px; height: 20px; }
    .s_pausing { background-position: -140px -140px; width: 20px; height: 20px; }
    .s_blueClearX { background-position: -170px 0px; width: 12px; height: 12px; }
    .s_blueStar_0_0 { background-position: -255px 0px; width: 65px; height: 13px; }
    .s_blueStar_1_0 { background-position: -242px 0px; width: 65px; height: 13px; }
    .s_blueStar_2_0 { background-position: -229px 0px; width: 65px; height: 13px; }
    .s_blueStar_3_0 { background-position: -216px 0px; width: 65px; height: 13px; }
    .s_blueStar_4_0 { background-position: -203px 0px; width: 65px; height: 13px; }
    .s_blueStar_5_0 { background-position: -190px 0px; width: 65px; height: 13px; }
    .s_notify { background-position: -0px -190px; width: 25px; height: 25px; }
    .s_confirm { background-position: -30px -190px; width: 25px; height: 25px; }
    .s_alert { background-position: -60px -190px; width: 25px; height: 25px; }
    .s_error { background-position: -90px -190px; width: 25px; height: 25px; }
    .s_notifySm { background-position: -120px -190px; width: 17px; height: 17px; }
    .s_confirmSm { background-position: -140px -190px; width: 17px; height: 17px; }
    .s_alertSm { background-position: -160px -190px; width: 17px; height: 17px; }
    .s_errorSm { background-position: -180px -190px; width: 17px; height: 17px; }
    .s_checkDisabled { background-position: -150px -170px; width: 14px;height: 14px; }
    .s_checkUnmarked { background-position: -90px -170px; width: 14px;height: 14px; }
    .s_checkHover { background-position: -110px -170px; width: 14px;height: 14px; }
    .s_checkMarked { background-position: -130px -170px; width: 14px;height: 14px; }
    .s_amznLogo { background-position: -170px -20px; width: 127px; height: 26px; }
    .s_primeBadge { background-position: -170px -50px; width: 45px; height: 13px; }
    .s_add2CartSm { background-position: -170px -70px; width: 76px; height: 17px; }
    .s_add2WishListSm { background-position: -170px -90px; width: 96px; height: 17px; }
    .s_buyWith1ClickSm { background-position: -170px -110px; width: 96px; height: 17px; }
    .s_preorderThisItemSm { background-position: -170px -130px; width: 108px; height: 17px; }
    .s_seeBuyingOptionsSm { background-position: -170px -150px; width: 122px; height: 17px; }
    .s_amznLikeBeak { background-position: -260px -200px; width: 12px; height: 10px; }
    .s_amznLikeButtonOff { background-position: -210px -170px; width: 47px; height: 20px; }
    .s_amznLikeButtonPressed { background-position: -210px -190px; width: 47px; height: 20px; }
    .s_amznLikeButtonOn { background-position: -260px -170px; width: 47px; height: 20px; }

    .s_starBigFull   { background-position: -78px -259px; width: 20px;height: 18px; }
    .s_starBigHalf   { background-position: -78px -279px; width: 20px;height: 18px; }
    .s_starBigEmpty { background-position: -97px -259px; width: 20px;height: 18px; }
    .s_starBig_0_0 { background-position: -98px -259px; width: 95px;height: 18px; }
    .s_starBig_0_5 { background-position: -79px -279px; width: 95px;height: 18px; }
    .s_starBig_1_0 { background-position: -79px -259px; width: 95px;height: 18px; }
    .s_starBig_1_5 { background-position: -60px -279px; width: 95px;height: 18px; }
    .s_starBig_2_0 { background-position: -60px -259px; width: 95px;height: 18px; }
    .s_starBig_2_5 { background-position: -41px -279px; width: 95px;height: 18px; }
    .s_starBig_3_0 { background-position: -41px -259px; width: 95px;height: 18px; }
    .s_starBig_3_5 { background-position: -22px -279px; width: 95px;height: 18px; }
    .s_starBig_4_0 { background-position: -22px -259px; width: 95px;height: 18px; }
    .s_starBig_4_5 { background-position: -3px  -279px; width: 95px;height: 18px; }
    .s_starBig_5_0 { background-position: -3px  -259px; width: 95px;height: 18px; }


</style>