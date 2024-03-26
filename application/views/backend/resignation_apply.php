<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-fighter-jet" style="color:#1976d2"> </i> Application</h3>
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
            <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
            <div class="col-12">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button>
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
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                        <th>Name</th>
                                        <th>PIN</th>
                                        <th>Effective Date</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach($application as $value): ?>
                                    <tr style="vertical-align:top">
                                        <td><?php echo $value->id; ?></td>
                                        <td><mark><?php echo $value?->first_name.' '.$value->last_name ?></mark></td>
                                        <td><?php echo $value->em_code; ?></td>
                                        <td><?php echo date('jS \of F Y',strtotime($value->resignation_date)); ?></td>
                                        <td>
    <?php
    $file_url = $value->file_url;
    $file_name = pathinfo($file_url, PATHINFO_BASENAME);
    ?>
    <a href="<?= base_url('Resignation/' . $file_name) ?>">
        <?php echo $file_url; ?>
    </a>
</td>
                                        <td><?php echo $value->resignation_status; ?></td>
                                        <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                        
                                        <?php } else { ?>
                                        <td class="jsgrid-align-center">
                                            <?php if($value->resignation_status =='Approve'){ ?>
                                            
                                            <?php } elseif($value->resignation_status =='Not Approve'){ ?>
                                            <a href="" title="Edit" class="btn btn-sm btn-success waves-effect waves-light resignationapproval" data-id="<?php echo $value->id; ?>">Approved</a>
                                            <a href="" title="Edit" class="btn btn-sm btn-danger waves-effect waves-light  Status" data-id = "<?php echo $value->id; ?>" data-value="Rejected" >Reject</a><br>
                                            <?php } elseif($value->leave_status =='Rejected'){ ?>
                                            <?php } ?>
                                            <a href="" title="Edit" class="btn btn-sm btn-primary waves-effect waves-light resignationapp" data-id="<?php echo $value->id; ?>" ><i class="fa fa-pencil-square-o"></i> Edit</a>
                                        </td>
                                        <?php } ?>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" action="Add_Applications" id="resignationapply" enctype="multipart/form-data">
                        <div class="modal-body">
                            
                            <div class="form-group">
                                <!-- <label type ="hidden" for="employeeInput">Employee</label> -->
                                <input type="hidden" class="form-control custom-select selectedEmployeeID" tabindex="1" name="emid" id="employeeInput" value="<?php echo $employee?->em_id ?>" required>
                            </div>

                            <div class="form-group" id="resignation_date">
                                <label class="control-label">Effective Date</label>
                                <input type="date" name="resignation_date" class="form-control" id="recipient-name1">
                            </div>
                            <div class="form-group">
                             
                                <input type="hidden" class="form-control" value="Please check attachment" name="reason" id="message-text1">                                            
                            </div>
                            <div class="form-group">
                                <label class="control-label">Attachment</label>
                                <label for="recipient-name1" class="control-label">Title</label>
                                <input type="file" name="file_url" class="form-control" id="recipient-name1" required>
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

        <!-- Set leaves approved for ADMIN? -->
        <script type="text/javascript">
            $(document).ready(function() {
                $(".resignationapply").click(function(e) {
                    e.preventDefault(e);
                    // Get the record's ID via attribute
                    var iid = $(this).attr('data-id');
                    $('#resignationapplyval').trigger("reset");
                    $('#appmodelcc').modal('show');
                    $.ajax({
                        url: 'ResignationAppbyid?id=' + iid,
                        method: 'GET',
                        data: '',
                        dataType: 'json',
                    }).done(function(response) {
                        console.log(response);
                        // Populate the form fields with the data returned from server
                        $('#resignationapplyval').find('[name="id"]').val(response.resignationapplyvalue.id).end();
                        $('#resignationapplyval').find('[name="emid"]').val(response.resignationapplyvalue.em_id).end();
                        $('#resignationapplyval').find('[name="resignation_date"]').val(response.resignationapplyvalue.resignation_date).end();
                        $('#resignationapplyval').find('[name="reason"]').val(response.resignationapplyvalue.reason).end();
                        /* $('#resignationapplyval').find('[name="attachment"]').val(response.resignationapplyvalue.attachment).end(); */
                         // Add the file input field
                 var fileInput = $('<input type="file" name="file_url" />'); // Uncomment this line if you want to add a file input
                $('#resignationapply').find(fileInput).val(response.resignationapplyvalue.file_url).end();
                        $('#resignationapplyval').find('[name="status"]').val(response.resignationapplyvalue.resignation_status).end();

                    });
                });
            });
        </script>
        <?php $this->load->view('backend/footer'); ?>