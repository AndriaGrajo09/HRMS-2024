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
                <li class="breadcrumb-item active">SALN Application</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row m-b-10">
            <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
            <div class="col-12">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add SALN Form </a></button>
            </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> SALN List
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
                                        <th>Filed_date</th>
                                        <th>File_url</th>
                                        <!-- <th>Status</th> -->
                                        
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach($application as $value): ?>
                                    <tr style="vertical-align: top">
                                        <td><?php echo $value->id; ?></td>
                                        <td><mark><?php echo $value?->first_name.' '.$value->last_name ?></mark></td>
                                        <td><?php echo $value->em_code; ?></td>
                                        <td><?php echo date('jS \of F Y',strtotime($value->date_filed)); ?></td>
                                        <td>
                                            <?php
                                            $file_url = $value->file_url;
                                            $file_name = pathinfo($file_url, PATHINFO_BASENAME);
                                            ?>
                                            <a href="<?= base_url('SALN/' . $file_name) ?>">
                                               <?php echo $value?->first_name.' '.$value->last_name. '- SALN' ?>
                                            </a>
                                        </td>
                                
                                        
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
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">SALN Application</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" action="SALN_Applications" id="resignationapply" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <!-- <label type="hidden" for="employeeInput">Employee</label> -->
                        <input type="hidden" class="form-control custom-select selectedEmployeeID" tabindex="1" name="emid" id="employeeInput" value="<?php echo $employee->em_id ?>" required>
                    </div>

                    <div class="form-group" id="resignation_date">
                        <label class="control-label">Effective Date</label>
                        <input type="date" name="resignation_date" class="form-control" id="recipient-name1">
                    </div>

                    <script>
                        // Get the current date in the format "YYYY-MM-DD"
                        const currentDate = new Date().toISOString().split('T')[0];

                        // Set the input field's value to the current date
                        document.getElementById('recipient-name1').value = currentDate;
                    </script>

                    <div class="form-group">
                        <label class="control-label">Attach SALN</label>
                        <input type="file" name="file_url" class="form-control" id="file_url" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="form-control" id="recipient-name1" required>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button id="downloadPdf" class="btn btn-primary">Save SALN</button>
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
            $('#resignationapply').trigger("reset");
            $('#appmodel').modal('show');
            $.ajax({
                url: 'ResignationAppbyid?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).done(function(response) {
                console.log(response);
                // Populate the form fields with the data returned from the server
                $('#resignationapply').find('[name="emid"]').val(response.resignationapplyvalue.em_id).end();
                $('#resignationapply').find('[name="resignation_date"]').val(response.resignationapplyvalue.resignation_date).end();
                // Add the file input field
                 var fileInput = $('<input type="file" name="file_url" />'); // Uncomment this line if you want to add a file input
                $('#resignationapply').find(fileInput).val(response.resignationapplyvalue.file_url).end();
            });
        });
    });
</script>



        <?php $this->load->view('backend/footer'); ?>