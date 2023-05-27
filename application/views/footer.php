</div>
</div>
</div>
</div>
</div>

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

<div class="footer">
    <div class="footer-inner">
        <div class="footer-content">
            <span class="bigger-120">
                PT. Falcon Prima Tehnik &copy; 2023
            </span>
        </div>
    </div>
</div>



<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
</div>


<script src="<?= base_url() ?>assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='<?= base_url() ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>
<script src="<?= base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.easypiechart.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.sparkline.index.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.flot.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.flot.pie.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.flot.resize.min.js"></script>
<script src="<?= base_url() ?>assets/js/ace-elements.min.js"></script>
<script src="<?= base_url() ?>assets/js/ace.min.js"></script>
<script src="<?= base_url() ?>assets/js/leaflet.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.select.min.js"></script>
<script src="<?= base_url() ?>assets/js/moment.min.js"></script>
<script src="<?= base_url() ?>assets/js/daterangepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/daterangepicker.css" />

<?php if ($page == 'Pengumuman') { ?>
    <script type="text/javascript">
        // Get the modal Lihat Pengumuman
        var modal = document.getElementById("m-pengumuman");
        var btn = document.getElementById("BtnLihat");

        function show_modal() {
            modal.style.display = "block";
        }

        function close_modal() {
            modal.style.display = "none";
        }
    </script>
<?php } ?>

<?php if ($page == 'Riwayat') { ?>
    <script type="text/javascript">
        jQuery(function($) {
            //initiate dataTables plugin
            var myTable =
                $('#dynamic-table')
                .DataTable({
                    bAutoWidth: false,
                    "aoColumns": [
                        null, null, null,null
                    ],
                    "aaSorting": [],
                    select: {
                        style: 'multi'
                    }
                });

        })
    </script>
<?php } ?>

<?php if ($page == 'Absen') { ?>
    <!-- Custom script -->
    <script type="text/javascript">
        function showTime() {
            $.ajax({
                url: "<?= base_url() ?>Absen/time_server/",
                type: "GET",
                dataType: "HTML",
                success: function(data) {
                    document.getElementById('waktu_absen').innerHTML = data;

                    console.log(data);
                },
                error: function(data) {
                    document.getElementById('waktu_absen').innerHTML = 'Error';
                }
            });
        }
        setInterval(showTime, 900);
    </script>

    <script>
        //var x = document.getElementById("demo");
        var min_dist = 0.2; // 0.2 - 60 meter

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                //x.innerHTML = "Geolocation is not supported by this browser.";
                console.log('Geolocation is not supported by this browser.');
            }
        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            var long = position.coords.longitude;

            var dist = distance(lat, long);
            var jarak = (dist * 300) / 1000;

            document.getElementById("lat").value = lat;
            document.getElementById("long").value = long;
            document.getElementById("dist").value = dist;
            console.log(lat + ' - ' + long);
            console.log(distance(lat, long));
            console.log((distance(lat, long) * 300) / 1000); //jarak dalam KM

            //x.innerHTML = "Latitude: " + lat +
            //    "<br>Longitude: " + long + 
            //    "<br>Jarak ke kantor: " + jarak.toFixed(2) + " KM";

            // Creating map options
            var mapOptions = {
                center: [lat, long],
                zoom: 17
            }
            // Creating a map object
            var map = new L.map('map', mapOptions);

            // Creating a Layer object
            var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

            // Adding layer to the map
            map.addLayer(layer);

            // Creating a marker
            var marker = L.marker([lat, long]);

            // Adding marker to the map
            marker.addTo(map);
        }

        function distance(lat, long) {
            var cx = -7.297968; //latitude kantor
            var cy = 112.777079; //longitude kantor

            mx = Math.abs(lat - cx);
            my = Math.abs(long - cy);

            dist = ((mx ** 2) + (my ** 2)) ** 0.5;

            dist = dist * 100;

            return dist;
        }

        function regAbsen(mode) {
            var lat = document.getElementById("lat").value;
            var long = document.getElementById("long").value;
            var dist = document.getElementById("dist").value;

            if (dist <= min_dist) {
                //alert('absen berhasil');
                if (mode == 'masuk') {
                    $.ajax({
                        url: "<?= base_url() ?>Absen/masuk/<?= $_SESSION['id_akun'] ?>",
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            if (data['status'] == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Good',
                                    text: data['msg']
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data['msg']
                                })
                            }

                            if (data['jam'] != 0) {
                                document.getElementById("jam_masuk").innerHTML = '<b>' + data['jam'] + '</b>';
                            }

                            console.log(data);
                        },
                        error: function(data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Tidak berhasil load data'
                            })
                        }
                    });
                } else { //pulang
                    $.ajax({
                        url: "<?= base_url() ?>Absen/pulang/<?= $_SESSION['id_akun'] ?>",
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            if (data['status'] == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Good',
                                    text: data['msg']
                                })
                                if (data['jam'] != 0) {
                                    document.getElementById("jam_pulang").innerHTML = '<b>' + data['jam'] + '</b>';
                                }

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data['msg']
                                })
                            }


                            console.log(data);
                        },
                        error: function(data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Tidak berhasil load data' + JSON.stringify(data)
                            })
                        }
                    });
                } //pulang

            } else {
                //alert('Anda terlalu jauh ' + ((dist * 300) / 1000).toFixed(2) + ' KM');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Anda terlalu jauh ' + ((dist * 300) / 1000).toFixed(2) + ' KM'
                })
            }
        }
    </script>
<?php } ?>
</body>

</html>