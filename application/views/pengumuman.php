<?php
foreach ($notif as $v) {

    if ($v->mode_notif == 1) {
        $alert_tipe = 'danger';
    } else {
        $alert_tipe = 'success';
    }

    echo '<div class="alert alert-block alert-' . $alert_tipe . '">
        <p>
            <strong>
                <i class="ace-icon fa fa-bullhorn"></i>
                ' . $v->isi_notif . '
            </strong>
        </p>

        <p>
           Alasan : <b>' . $v->alasan . '</b>
        </p>
    </div>';
}
?>

<!-- MODAL -->
<div id="m-pengumuman" class="modal fade in" tabindex="-1" style="margin-top: 10%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="close_modal()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="smaller lighter blue no-margin"><i class="ace-icon fa fa-bullhorn"></i> Judul Pengumuman yang akan diumumkan masukan disini</h3>
            </div>

            <div class="modal-body">
                Some content
            </div>

        </div>
    </div>
</div>
<!-- MODAL -->