<style>
    .instagram-profile {
        /*padding: 40px;*/
        margin: 10px;
        border: 1px solid #d6d6d6;
        border-radius: 3px;
        background: #f6f6f6;
    }

    .profile-picture {
        border-radius: 50%;
        height: 42px;
        width: 42px;
        border: 2px solid #d82b7e;
    }

    .description {
        background: #fff;
        background-color: rgba(var(--d87, 255, 255, 255), 1);

    }

    .avatar-content {
        border-right: 1px solid #efefef;
        border-bottom: 1px solid rgba(var(--ce3, 239, 239, 239), 1);
        padding: 10px;
        float: right;
        width: 100%;
    }

    .avatar-content img {
        float: right;
        padding: 1px;
    }

    .username {
        float: right;
        position: relative;
        right: 5px;
        top: 8px;
        color: #262626;
    }


    @media (max-width: 991px) {
        .description {
            margin-top: -10px;
        }

    }


    .text-content {
        padding: 10px;
        font-size: 11px;
        text-align: right;
        float: right;
        max-height: 330px;
        overflow: auto;
        scrollbar-width: none;
        border-bottom: 1px solid rgba(var(--ce3, 239, 239, 239), 1);
        width: 100%;
    }

    .like-content {
        padding: 11px 10px;
        float: right;
    }
</style>
<?php
$username = $json['items'][0]['caption']['user']['username'];
$text = $json['items'][0]['caption']['text'];
$like = $json['items'][0]['like_count'];
$views = $json['items'][0]['view_count'];
$comments = $json['items'][0]['comment_count'];

?>
<div class="kt-row instagram-profile">
    <div class="kt-col-xs-12 kt-col-md-8">
        <img src="<?= $post_pic_url ?>">

    </div>
    <div class="kt-col-xs-12 kt-col-md-4 description">
        <span class="avatar-content">
                    <img class="profile-picture" src="<?= $profile_pic_url ?>">
            <span class="username">
                 <?= $username ?>
            </span>

        </span>
        <span class="text-content">
                <?= nl2br($text) ?>
        </span>
        <span class="like-content">
            <?php if (isset($like)): ?>
                <?= number_format($like) ?> <span>لایک</span><br>
            <?php endif; ?>
            <?php if (isset($views)): ?>
                <?= number_format($views) ?> <span>ویو</span><br>
            <?php endif; ?>
            <?php if (isset($comments)): ?>
                <?= number_format($comments) ?> <span>کامنت</span>
            <?php endif; ?>
        </span>
    </div>

</div>