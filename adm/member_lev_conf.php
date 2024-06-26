<?php
//<- 오류 모두 표시 
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$sub_menu = "200150";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
    alert('등급수정은 최고관리자만 가능합니다.');

if (!isset($config['lev_cf_1'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `lev_cf_1` VARCHAR(255) NOT NULL DEFAULT '비회원' AFTER `cf_10`,
                    ADD `lev_cf_2` VARCHAR(255) NOT NULL AFTER `lev_cf_1`,
                    ADD `lev_cf_3` VARCHAR(255) NOT NULL AFTER `lev_cf_2`,
                    ADD `lev_cf_4` VARCHAR(255) NOT NULL AFTER `lev_cf_3`,
                    ADD `lev_cf_5` VARCHAR(255) NOT NULL AFTER `lev_cf_4`,
                    ADD `lev_cf_6` VARCHAR(255) NOT NULL AFTER `lev_cf_5`,
                    ADD `lev_cf_7` VARCHAR(255) NOT NULL AFTER `lev_cf_6`,
                    ADD `lev_cf_8` VARCHAR(255) NOT NULL AFTER `lev_cf_7`,
                    ADD `lev_cf_9` VARCHAR(255) NOT NULL AFTER `lev_cf_8`,
                    ADD `lev_cf_10` VARCHAR(255) NOT NULL DEFAULT '최고관리자' AFTER `lev_cf_9` ", true);
}

if ($w == '') {
    //$mb['mb_open'] = 1;
    //$mb['mb_level'] = $config['cf_register_level'];
} else if ($w == 'u') {
    check_admin_token();

    $sql = " update {$g5['config_table']}
            set cf_register_level = '{$_POST['cf_register_level']}',
                lev_cf_2 = '{$_POST['lev_cf_2']}',
                lev_cf_3 = '{$_POST['lev_cf_3']}',
                lev_cf_4 = '{$_POST['lev_cf_4']}',
                lev_cf_5 = '{$_POST['lev_cf_5']}',
                lev_cf_6 = '{$_POST['lev_cf_6']}',
                lev_cf_7 = '{$_POST['lev_cf_7']}',
                lev_cf_8 = '{$_POST['lev_cf_8']}',
                lev_cf_9 = '{$_POST['lev_cf_9']}' ";
    sql_query($sql);
    goto_url($PHP_SELF, false);
}

$g5['title'] .= '회원등급설정 ';
include_once('./admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm" style="width:800px;">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="' . G5_URL . '/">메인으로</a>
</div>';

$colspan = 2;
?>

<div class="local_desc01 local_desc">
    <p>
        회원권한을 한글로 표기하여 관리 할수있는 페이지입니다.
        <br><strong>그누보드5 , 영카드5</strong> 에서 사용 가능합니다.
    </p>
</div>

<form name="fmb_lev_conf" id="fmb_lev_conf" method="post" onsubmit="return fmb_lev_conf_submit(this);" enctype="MULTIPART/FORM-DATA">
    <input type="hidden" name="w" value="u">
    <input type="hidden" name="token" value="" id="token">

    <div class="tbl_head01 tbl_wrap">
        <table style="width:800px;">
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th scope="col">회원등급</th>
                    <th scope="col">등급</th>
                </tr>
            </thead>
            <tbody>
                <? for ($i = 1; $i <= 10; $i++) { ?>
                    <tr>
                        <td class="td_category"><?= $i ?></td>
                        <td>
                            <?
                            if ($i == 10 || $i == 1)    echo $config["lev_cf_" . $i];
                            else {
                                echo "<input type='text' name='lev_cf_{$i}' value='" . $config["lev_cf_" . $i] . "' class='frm_input'>";
                            }
                            ?>
                        </td>
                    </tr>
                <? } ?>
                <tr>
                    <td class="td_category"><label for="cf_register_level">회원가입시 권한</label></td>
                    <td><?php echo get_member_level_select('cf_register_level', 1, 9, $config['cf_register_level']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <? echo $frm_submit; ?>

</form>
<script>
    function fmb_lev_conf_submit() {
        if (confirm("등급설정 변경은 개발자에게 문의후 하시는게 좋습니다\n\n등급을 수정하시겠습니까?")) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?php
include_once('./admin.tail.php');
?>