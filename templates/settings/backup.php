<?php
defined('ABSPATH') || exit('No Access!');
?>
<div class="samyar-settings-area samyar-settings-backup">

    <h3 class="samyar-settings-title">
        <span class="samyar-title-icon"><span uk-icon="database"></span></span>
        <strong>برونبری و درونریزی تنظیمات</strong>
    </h3>


    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label">تنظیمات درون ریزی</label>
            <div class="uk-margin-small">
                <div class="uk-alert-danger uk-alert" uk-alert="">
                    خطر: لطفا با احتیاط عمل کنید! توجه کنید تمامی مقادیر فعلی جایگزین می شود
                </div>
                <button class="uk-button uk-button-default show-import-textarea" data-type="all" type="button">درونریزی
                    با اطلاعات
                </button>
                <!--
                <button class="uk-button uk-button-default show-import-file" data-type="all" type="button">درونریزی
                    با فایل
                </button>
                -->
            </div>

            <div class="uk-margin-small import-textarea">

                    <label>
                        <textarea class="uk-textarea" id="import-data-text" dir="ltr"></textarea>
                        <div class="uk-margin-small">
                            <button class="uk-button uk-button-yellow" id="kando_import_btn" type="button">درونریزی</button>
                        </div>
                    </label>

            </div>

            <div class="uk-margin-small import-file">


                    <input type="file" name="import-file" id="import-file">
                    <div class="uk-margin-small">
                        <button class="uk-button uk-button-yellow" id="kando_import_file_btn" type="button">درونریزی</button>
                    </div>


            </div>


        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-margin">
            <label class="uk-form-label">تنظیمات برون بری</label>
            <div class="uk-margin-small">
                <div class="uk-alert-primary uk-alert" uk-alert="">
در این بخش می توانید از تنظیمات سایت خود پشتیبان تهیه کنید و برای انتقال تنظیمات از سایت خودتون به سایت جدید استفاده کنید و یا اگر اطلاعات تنظیمات تغییر کرد بتونید به راحتی برگردونید<br>
                    کافی است این اطلاعات رو کپی کرده و در یک فایل text ذخیره کنید و در جای ایمن نگه دارید
                </div>
                <button class="uk-button uk-button-default show-backup-textarea" data-type="all" type="button">کپی
                    اطلاعات تنظیمات
                </button>


                <?php
                $secret = md5(md5(AUTH_KEY . SECURE_AUTH_KEY) . '-samyar_options');
                $link = esc_url(admin_url('admin-ajax.php?action=kando_download_options-samyar_options' . '&secret=' . $secret));
                ?>
                <!--
                <a class="uk-button uk-button-yellow" href="<?php echo $link; ?>">دانلود فایل تنظیمات</a>
-->

            </div>
            <div class="uk-margin-small backup-textarea">
                <label>
                    <textarea class="uk-textarea" id="backup-data-text" dir="ltr"></textarea>
                </label>
            </div>

        </div>
    </div>

</div>