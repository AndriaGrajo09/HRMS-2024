<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-fighter-jet" style="color:#1976d2"> </i> Resignations</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Resignation List</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Resignation List
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
                                        <th>Resignation Date</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($resignations as $value): ?>
                                    <tr style="vertical-align:top">
                                        <td><?php echo $value->id; ?></td>
                                        <td><mark><?php echo $value->first_name.' '.$value->last_name ?></mark></td>
                                        <td><?php echo $value->em_code; ?></td>
                                        <td><?php echo date('jS \of F Y', strtotime($value->resignation_date)); ?></td>
                                        <td><?php echo $value->reason; ?></td>
                                        <td><?php echo $value->resignation_status; ?></td>
                                        <td class="jsgrid-align-center">
                                            <?php if($value->resignation_status == 'Pending'): ?>
                                                <a href="" title="Approve" class="btn btn-sm btn-success waves-effect waves-light resignation-approval" data-id="<?php echo $value->id; ?>">Approve</a>
                                                <a href="" title="Reject" class="btn btn-sm btn-danger waves-effect waves-light resignation-rejection" data-id="<?php echo $value->id; ?>">Reject</a>
                                            <?php elseif($value->resignation_status == 'Approved'): ?>
                                                <!-- Display additional actions for approved resignations if needed -->
                                            <?php endif; ?>
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
    </div>
</div>

<!-- Add your modal for approval/rejection here -->

<script>
    $(document).ready(function () {
        var selectedResignationId;

        $('.resignation-approval').click(function () {
            // Set the action to 'Approve' and show the modal
            $('#resignationAction').text('Approve');
            selectedResignationId = $(this).data('id');
            $('#resignationModal').modal('show');
        });

        $('.resignation-rejection').click(function () {
            // Set the action to 'Reject' and show the modal
            $('#resignationAction').text('Reject');
            selectedResignationId = $(this).data('id');
            $('#resignationModal').modal('show');
        });

        $('#approveResignationBtn').click(function () {
            // Handle the approval logic here
            // You might want to make an AJAX request to the server to update the status
            // After approval, you can close the modal and update the UI as needed
            $('#resignationModal').modal('hide');
        });

        $('#rejectResignationBtn').click(function () {
            // Handle the rejection logic here
            // Similar to approval, you might want to make an AJAX request to update the status
            // After rejection, you can close the modal and update the UI as needed
            $('#resignationModal').modal('hide');
        });
    });
</script>

<?php $this->load->view('backend/footer'); ?>