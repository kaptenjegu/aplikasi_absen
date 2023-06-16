<div class="row">
    <!--div class="vspace-12-sm"></div-->

    <!-- box waktu server -->
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header widget-header-flat widget-header-small">
                <h5 class="widget-title">
                    <i class="ace-icon glyphicon glyphicon-time"></i>
                    Waktu Server
                </h5>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div id="waktu_absen" style="text-align: center; font-size: 65px; font-weight: bold;font-family: Arial, Helvetica, sans-serif;">
                        <?php date_default_timezone_set('Asia/Jakarta');
                        echo date('H') . '<span class="blink_me">:</span>' . date('i'); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- box waktu server -->
    <div class="col-xs-12">
        <button class="btn btn-inverse col-xs-5" onclick="regAbsen('masuk')"><i class="glyphicon glyphicon-time"></i> Masuk</button>

        <div class="col-xs-2"></div>

        <button class="btn btn-inverse col-xs-5" onclick="regAbsen('pulang')"><i class="glyphicon glyphicon-time"></i> Pulang</button>
    </div>

</div><!-- /.row -->

<div class="hr hr32 hr-dotted"></div>

<!-- Tabel Info Absen -->
<div class="row">
    <div class="col-sm-12">
        <div class="widget-box transparent">

            <div class="widget-body">
                <div class="widget-main no-padding">
                    <table class="table table-bordered table-striped">
                        <thead class="thin-border-bottom">
                            <tr>
                                <th>
                                    Tanggal Hari ini
                                </th>

                                <th>
                                    Jam Absen Masuk
                                </th>

                                <th>
                                    Jam Absen Pulang
                                </th>
                                <th>
                                    Lokasi Kerja
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <b>
                                        <?php echo date('d-m-Y'); ?>
                                    </b>
                                </td>

                                <td>
                                    <span id="jam_masuk"><b><?= $absen->absen_masuk ?? '-' ?></b></span>
                                </td>

                                <td>
                                    <span id="jam_pulang"><b><?= $absen->absen_pulang ?? '-' ?></b></span>
                                </td>

                                <td>
                                    <span><b><?= $_SESSION['nama_lokasi'] ?></b></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Tabel Info Absen -->

<!-- block MAP -->
<input type="hidden" id="lat">
<input type="hidden" id="long">
<input type="hidden" id="dist">
<div id="map" style="width:100%; height:380px;"></div>

<br><br>

<button class="btn btn-success col-xs-12" onclick="getLocation()">
    <i class="glyphicon glyphicon-refresh"></i> Refresh Map
</button>
<!-- block MAP -->