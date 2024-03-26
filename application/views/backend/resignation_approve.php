<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Resignation Application</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row m-b-10">
            <?php if ($this->session->userdata('user_type') == 'EMPLOYEE') { ?>
                <div class="col-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal"
                            data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class=""
                                aria-hidden="true"></i> Add Application </a></button>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Application List
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>PIN</th>
                                        <th>Resignation Date</th>
                                        <th>Resignation Letter</th>
                                        <!-- <th>Attachment</th> -->
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($application as $value): ?>
                                        <tr style="vertical-align: top;">
                                            <td><span>
                                                    <?php echo $value->first_name . ' ' . $value->last_name; ?>
                                                </span></td>
                                            <td>
                                                <?php echo $value->em_code; ?>
                                            </td>
                                            <td>
                                                <?php echo date('jS \of F Y', strtotime($value->resignation_date)); ?>
                                            </td>
                                            <td>
                                                <?php
                                                $file_url = $value->file_url;
                                                $file_name = pathinfo($file_url, PATHINFO_BASENAME);
                                                ?>
                                                <a href="<?= base_url('Resignation/' . $file_name) ?>">
                                                    <?php echo 'Resignation Letter - '.$value->first_name . ' ' . $value->last_name; ?>
                                                </a>
                                            </td>
                                            <!-- <td><?php #echo #$value->attachment; ?></td> -->
                                            <td>
                                                <?php echo $value->resignation_status; ?>
                                            </td>
                                            <?php if ($this->session->userdata('user_type') == 'EMPLOYEE'): ?>

                                            <?php else: ?>
                                                <td class="jsgrid-align-center">

                                                    <?php if ($value->resignation_status == 'Not Approved'): ?>
                                                        <a href="#" title="Approve"
                                                            class="btn btn-sm btn-success waves-effect waves-light Status"
                                                            data-employeeId="<?= $value->em_id; ?>" data-id="<?= $value->id; ?>"
                                                            data-value="Approve">Approve</a>
                                                        <a href="#" title="Reject"
                                                            class="btn btn-sm btn-danger waves-effect waves-light Status"
                                                            data-employeeId="<?= $value->em_id; ?>" data-id="<?= $value->id; ?>"
                                                            data-value="Reject">Reject</a>
                                                        <br>

                                                        <!-- JavaScript/jQuery code to handle button clicks and make AJAX requests -->
                                                        <script>
                                                            $(document).ready(function () {
                                                                $('.Status').on('click', function (event) {
                                                                    event.preventDefault(); // Prevent the default behavior of anchor tags

                                                                    var employeeId = $(this).data('employeeid'); // Corrected data attribute name
                                                                    var newStatus = $(this).data('value');

                                                                    $.post('<?php echo base_url('Resignation/Update_Applications'); ?>', { employeeId: employeeId, new_status: newStatus }, function (data) {
                                                                        // Handle the response as needed (e.g., display a success message)
                                                                        alert(data);
                                                                    });

                                                                });
                                                            });
                                                        </script>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="appmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Resignation Application</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" action="Add_Applications" id="resignationapply" enctype="multipart/form-data">
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Employee</label>
                                <select class=" form-control custom-select selectedEmployeeID" tabindex="1" name="emid"
                                    required>
                                    <?php foreach ($employee as $value): ?>
                                        <option value="<?php echo $value->em_id ?>">
                                            <?php echo $value?->first_name . ' ' . $value->last_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group" id="resignationdate" style="display:none">
                                <label class="control-label">Resignation Date</label>
                                <input type="text" name="enddate" class="form-control mydatetimepickerFull"
                                    id="recipient-name1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Attachment</label>
                                <label for="recipient-name1" class="control-label">Title</label>
                                <input type="file" name="file_url" class="form-control" id="recipient-name1" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Reason</label>
                                <textarea class="form-control" name="reason" id="message-text1"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" class="form-control" id="recipient-name1" required>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            /*DATETIME PICKER*/
            $("#bbbSubmit").on("click", function (event) {
                event.preventDefault();
                var typeid = $('.typeid').val();
                var datetime = $('.mydatetimepicker').val();
                var emid = $('.emid').val();
                //console.log(datetime);
                $.ajax({
                    url: "GetemployeeGmResignation?year=" + datetime + "&typeid=" + typeid + "&emid=" + emid,
                    type: "GET",
                    dataType: '',
                    data: 'data',
                    success: function (response) {
                        // console.log(response);
                        $('.resignationval').html(response);
                    },
                    error: function (response) {
                        // console.log(response);
                    }
                });
            });
            <script>
                $(".Status").on("click", function(event){
                    event.preventDefault();
                // console.log($(this).attr('data-value'));
                $.ajax({
                    url: "approveResignationStatus",
                type:"POST",
                data:
                {
                    'employeeId': $(this).attr('data-employeeId'),
                'rid': $(this).attr('data-id'),
                'rvalue': $(this).attr('data-value'),
          },
                success: function(response) {
                    // console.log(response);
                    $(".message").fadeIn('fast').delay(30000).fadeOut('fast').html(response);
                window.setTimeout(function(){location.reload()}, 30000);
          },
                error: function(response) {
                    //console.error();
                }
      });
  });           
        </script>

        <script type="text/javascript">
    $(document).ready(function() {
        $(".resignationapp").click(function (e) {
            e.preventDefault(e);
            // Get the record's ID via attribute
            var iid = $(this).attr('data-id');
            $('#resignationapply').trigger("reset");
            $('#appmodel').modal('show');
            $.ajax({
                url: 'ResignationAppbyid?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).done(function (response) {
                // console.log(response);
                // Populate the form fields with the data returned from server
                $('#resignationapply').find('[name="id"]').val(response.resignationapplyvalue.id).end();
                $('#resignationapply').find('[name="emid"]').val(response.resignationapplyvalue.em_id).end();
                $('#resignationapply').find('[name="resignation_date"]').val(response.resignationapplyvalue.resignation_date).end();
                $('#resignationapply').find('[name="attachment"]').val(response.resignationapplyvalue.attachment).end();
                $('#resignationapply').find('[name="reason"]').val(response.resignationapplyvalue.reason).end();
                $('#resignationapply').find('[name="status"]').val(response.resignationapplyvalue.leave_status).end();

            });
        });
            });
        </script>
        <?php $this->load->view('backend/footer'); ?>