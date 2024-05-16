<?php require_once ('header.php');

// Path to your shell script
$script_path = "/var/www/html/callanalog/admin/serverdetails.sh";
// Execute the shell script
$output = shell_exec("bash " . $script_path);
$response = file_get_contents('system_info.txt');
$lines = explode("\n", $response);
foreach ($lines as $value) {
    $columns[] = preg_split('/\s+/', $value);
}
?>
<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Server Details(146.0.237.17)
                            <span style="margin-left:50px;"></span>
                        </h2>
                        <div class="table-data__tool-right">
                            <a href=""><button class="au-btn au-btn-icon au-btn--blue"><i
                                        class="fa fa-refresh"></i>Refresh</button></a>
                        </div>
                    </div>
                    <span style="font-size:20px;">Timezone:
                        <?php echo $columns[9][3] . $columns[9][4] . $columns[9][5]; ?></span>
                </div>
            </div>
            <style>
                .show {
                    display: block !important;
                    opacity: 1;
                    background: #0000004d !important;
                }

                .panel-collapse {
                    background: white !important;
                }
            </style>
            <div class="row">
                <div class="col-md-12">
                    <h3>Disk Space</h3>
                    <!-- <div class="overview-wrap custom_show">
                        &nbsp;
                    </div> -->
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <!-- Table -->
                        <table class='display dataTable table manage_queue_table'>
                            <thead class="table_title">
                                <tr>
                                    <th>Filesystem</th>
                                    <th>Size</th>
                                    <th>Used</th>
                                    <th>Avail</th>
                                    <th>Use%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $columns[1][0]; ?></td>
                                    <td><?php echo $columns[1][1]; ?></td>
                                    <td><?php echo $columns[1][2]; ?></td>
                                    <td><?php echo $columns[1][3]; ?></td>
                                    <td><?php echo $columns[1][4]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <h3>CPU Usage</h3>
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <table class='table dataTable display manage_queue_table'>
                            <thead class="table_title">
                                <tr>
                                    <th></th>
                                    <th>%usr</th>
                                    <th>%sys</th>
                                    <th>%nice</th>
                                    <th>%idle</th>
                                    <th>%iowait</th>
                                    <th>%hard</th>
                                    <th>%soft</th>
                                    <th>%steal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $columns[15][0]; ?></td>
                                    <td><?php echo $columns[15][1] . ' ' . $columns[15][2]; ?></td>
                                    <td><?php echo $columns[15][3] . ' ' . $columns[15][4]; ?></td>
                                    <td><?php echo $columns[15][5] . ' ' . $columns[15][6]; ?></td>
                                    <td><?php echo $columns[15][7] . ' ' . $columns[15][8]; ?></td>
                                    <td><?php echo $columns[15][9] . ' ' . $columns[15][10]; ?></td>
                                    <td><?php echo $columns[15][11] . ' ' . $columns[15][12]; ?></td>
                                    <td><?php echo $columns[15][13] . ' ' . $columns[15][14]; ?></td>
                                    <td><?php echo $columns[15][15] . ' ' . $columns[15][16]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-md-12">
                    <h3>Uptime</h3>
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <table class='table dataTable display manage_queue_table'>
                            <thead class="table_title">
                                <tr>
                                    <th>Current Time</th>
                                    <th>Uptime</th>
                                    <th>No. of active users</th>
                                    <th>Load Average</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $columns[12][1] ?></td>
                                    <td><?php echo $columns[12][3] . ' ' . $columns[12][4] . ' ' . $columns[12][5]; ?>
                                    </td>
                                    <td><?php echo $columns[12][6]; ?></td>
                                    <td><?php echo $columns[12][10] . ' ' . $columns[12][11] . ' ' . $columns[12][12]; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <h3>Memory Usage</h3>
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <table class='table dataTable display manage_queue_table'>
                            <thead class="table_title">
                                <tr>
                                    <th>Total</th>
                                    <th>Used</th>
                                    <th>Free</th>
                                    <th>Shared</th>
                                    <th>Buff/cache</th>
                                    <th>Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $columns[5][1]; ?></td>
                                    <td><?php echo $columns[5][2]; ?></td>
                                    <td><?php echo $columns[5][3]; ?></td>
                                    <td><?php echo $columns[5][4]; ?></td>
                                    <td><?php echo $columns[5][5]; ?></td>
                                    <td><?php echo $columns[5][6]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <h3>Bandwidth</h3>
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <table class='table dataTable display manage_queue_table'>
                            <thead class="table_title">
                                <tr>
                                    <th>IFACE</th>
                                    <th>rxpck/s</th>
                                    <th>txpck/s</th>
                                    <th>rxkB/s</th>
                                    <th>txkB/s</th>
                                    <th>rxcmp/s</th>
                                    <th>txcmp/s</th>
                                    <th>rxmcst/s</th>
                                    <th>Total Bandwidth</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $columns[18][1]; ?></td>
                                    <td><?php echo $columns[18][2]; ?></td>
                                    <td><?php echo $columns[18][3] ?></td>
                                    <td><?php echo $columns[18][4]; ?></td>
                                    <td><?php echo $columns[18][5]; ?></td>
                                    <td><?php echo $columns[18][6]; ?></td>
                                    <td><?php echo $columns[18][7]; ?></td>
                                    <td><?php echo $columns[18][8]; ?></td>
                                    <td><?php echo $columns[21][2] . $columns[21][3]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12">
                    <h3>CPU Abbreviation</h3>
                    <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                        <table class='table dataTable display manage_queue_table'>
                            <tbody>
                                <tr>
                                    <td>usr</td>
                                    <td style="text-align:left;">user cpu time (or) % CPU time spent in user space</td>
                                </tr>
                                <tr>
                                    <td>sys</td>
                                    <td style="text-align:left;">system cpu time (or) % CPU time spent in kernel space
                                    </td>
                                </tr>
                                <tr>
                                    <td>nice</td>
                                    <td style="text-align:left;">user nice cpu time (or) % CPU time spent on low
                                        priority processes</td>
                                </tr>
                                <tr>
                                    <td>idle</td>
                                    <td style="text-align:left;">idle cpu time (or) % CPU time spent idle</td>
                                </tr>
                                <tr>
                                    <td>iowait</td>
                                    <td style="text-align:left;">io wait cpu time (or) % CPU time spent in wait (on
                                        disk)</td>
                                </tr>
                                <tr>
                                    <td>hard</td>
                                    <td style="text-align:left;">hardware irq (or) % CPU time spent servicing/handling
                                        hardware interrupts</td>
                                </tr>
                                <tr>
                                    <td>soft</td>
                                    <td style="text-align:left;">software irq (or) % CPU time spent servicing/handling
                                        software interrupts</td>
                                </tr>
                                <tr>
                                    <td>steal</td>
                                    <td style="text-align:left;">steal time % CPU (or) % CPU time stolen from a virtual
                                        machine</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once ('footer.php'); ?>