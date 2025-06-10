<tr id="category-<?php echo esc_attr($update->id) ?>">
    <td data-title="شناسه">
        <?php echo esc_attr($update->service_id) ?>
    </td>
    <td data-title="سرویس">
        <?php echo esc_attr($update->service_name) ?>
    </td>
    <td data-title="تاریخ">
        <?php
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        echo date_i18n($date_format.' '.$time_format, strtotime($update->date)) ?>
    </td>
    <td data-title="دسته">
        <?php
        if(!is_null($update->cate_id) || !empty($update->cate_id)){
            $cate_info = samyar\Category::find($update->cate_id);
            if($cate_info){
                echo $cate_info->name;
            }else{
                echo '-';
            }
        }else{
            echo '-';
        }
        ?>
    </td>
    <td data-title="عنوان">
        <?php
        switch($update->update_type){
            case 'disable':
                echo '<span class="button button-default badge-error-orders">'.$update->update_title.'</span>';
                break;
            case 'enable':
                echo '<span class="button button-green badge-error-orders">'.$update->update_title.'</span>';
                break;
            case 'increase_amount':
                echo '<span class="button button-blue badge-error-orders">'.$update->update_title.'</span>';
                break;
            case 'decrease_amount':
                echo '<span class="button button-orange badge-error-orders">'.$update->update_title.'</span>';
                break;
        }
        ?>

    </td>
    <?php if(samyar_user_is_admin(get_current_user_id())): ?>
    <td data-title="عملیات ها">
        <span class="button button-aqua btn-small delete-update" data-id="<?php echo esc_attr($update->id) ?>" data-tooltip="حذف"><i class="fal fa-trash"></i></span>
    </td>
    <?php endif; ?>
</tr>