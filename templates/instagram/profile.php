<style>
    .instagram-profile {
        padding: 40px;
        margin: 10px;
        border: 1px solid #d6d6d6;
        border-radius: 10px;
        background: #f6f6f6;
    }

    .profile-picture {
        border-radius: 50%;
        /*filter: blur(8px);*/
        /*-webkit-filter: blur(8px);*/
    }

    .username-title {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #262626;
        font-weight: 300;
        font-size: 20px;
        line-height: 32px;
        margin: -5px 0 -6px;
        margin-bottom: 20px;
    }

    .info {

    }

    .info .number {
        color: #262626;
        font-weight: 600;
    }

    .bio {
        margin-top: 20px;
        font-size: 16px;
        line-height: 24px;
        word-wrap: break-word;
        display: block;
    }

    .bio h1 {
        display: inline;
        font-weight: 600;
        font-size: 18px;
    }

    .link {
        display: block;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 14px;
    }

    @media (max-width: 991px) {
        .avatar {
            text-align: center;
        }

        .username-title {
            text-align: center;
        }
        .instagram-profile{
            padding-right: 0;
            padding-left: 0;
        }
    }

</style>
<?php
$save_image = SAMYAR_URI."/templates/instagram/Instagram.png'";
$image_url = $json['graphql']['user']['profile_pic_url'];
$posts = $json['graphql']['user']['edge_owner_to_timeline_media']['count'];
$followers = $json['graphql']['user']['edge_followed_by']['count'];
$following = $json['graphql']['user']['edge_follow']['count'];
$username = $json['graphql']['user']['username'];
$biography = $json['graphql']['user']['biography'];
$external_url = $json['graphql']['user']['external_url'];
$full_name = $json['graphql']['user']['full_name'];

function save_image($inPath,$outPath)
{ //Download images from remote server
    $in=    fopen($inPath, "rb");
    $out=   fopen($outPath, "wb");
    while ($chunk = fread($in,8192))
    {
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}
//if(isset($image_url)){
//    save_image($image_url,SAMYAR_PATH . '/templates/instagram/'.$username.'.jpg');
//    $save_image = SAMYAR_URI . '/templates/instagram/'.$username.'.jpg';
//    $save_image = "";
//}




//print_r($json);
?>
<div class="kt-row instagram-profile">
    <div class="column kt-col-xs-12 kt-col-md-3 avatar">
        <img class="profile-picture"
             src="<?=$profile_pic_url?>">
    </div>
    <div class="column kt-col-xs-12 kt-col-md-9 float-left">
        <h2 class="username-title"><?=$username?></h2>
        <div class="column kt-col-xs-4 kt-col-md-4">
                            <span class="info">
                                <span class="number"><?=number_format($posts)?></span>
                                پست
                            </span>
        </div>
        <div class="column kt-col-xs-4 kt-col-md-4">
                            <span class="info">
                                <span class="number"><?=number_format($followers) ?></span>
                                دنبال کننده
                            </span>
        </div>
        <div class="column kt-col-xs-4 kt-col-md-4">
                            <span class="info">
                                <span class="number"><?=number_format($following) ?></span>
                                دنبال شونده
                            </span>
        </div>
        <div class="kt-col-xs-12 kt-col-md-12">

            <div class="bio">
                <h1><?=$full_name ?></h1><br>
                <span><?=nl2br($biography)?></span>
                <a class="link" href="<?=$external_url?>" rel="me nofollow noopener noreferrer" target="_blank"><?=$external_url?></a></div>
        </div>
    </div>

</div>