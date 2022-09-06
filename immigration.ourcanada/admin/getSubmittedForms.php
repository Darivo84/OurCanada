<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <select class="form-control" id="filterSearch">
                <option value="All">All</option>
                <option value="Professional">Professional</option>
                <option value="Signed">Signed</option>
                <option value="Guest">Guest</option>

            </select>
        </div>
    </div>
</div>
<table id="datatable1" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
    <tr>
        <th>#</th>
        <th>Form ID</th>
        <th>First Name</th>
        <th>User Email</th>
        <th>Total Score</th>
        <th>Created Date</th>
        <th>Account Type</th>
        <th>Account Email</th>
        <th>IP Address</th>
        <th>Access</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $getQuery = mysqli_query($conn , "SELECT * FROM user_form where status = 1 order by id desc");
    $count = 1;
    while($Row = mysqli_fetch_assoc($getQuery)){
        $blocked='';
        $block=false;
        $userId = $Row['user_id'];

        $userInfo = getUserDetail($userId);

        $getQuery3 = mysqli_query($conn , "SELECT * FROM blocked_ip where `ip_address`='{$Row['ip_address']}'");
        if(mysqli_num_rows($getQuery3)>0)
        {
            $row3=mysqli_fetch_assoc($getQuery3);
            $blocked='Blocked';
            $block=true;

        }


        if(!empty($userInfo))
        {
            $blocked='';
            $block=false;
        }

        $getQuery2 = mysqli_query($conn , "SELECT * FROM score_calculation2 where user={$Row['id']} order by id desc");
        $total_score=0;
        while($srow = mysqli_fetch_assoc($getQuery2)) {
            if(ctype_digit($srow['score']))
                $total_score += $srow['score'];
        }

        ?>

        <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $Row['id'] ?></td>
            <td><?php echo $Row['user_name'] ?></td>
            <td><?php echo $Row['user_email'] ?></td>
            <td><?php echo $total_score ?></td>
            <td><?php echo $Row['created_date']; ?></td>
            <td><?php if(!empty($userInfo)){ if($userInfo['role'] == "1" || $userInfo['role'] == 1) { echo "Professional"; } else { echo "Signed"; } } else { echo "Guest"; } ?></td>
            <td><?php echo $userInfo['email']; ?></td>

            <td><?php echo $Row['ip_address']; ?></td>
            <td><?php echo $blocked; ?></td>
            <td>
                <a href="view_form?id=<?php echo $Row['id']; ?>" class="btn btn-sm btn-info waves-effect waves-light" title="View Form"><i class="fas fa-eye"></i></a>
                <a href="scores?id=<?php echo $Row['id']; ?>"  class="btn btn-sm btn-primary waves-effect waves-light" title="Check Score"><i class="fa fa-calculator"></i></a>
                <a target="_blank" href="<?php echo $currentTheme ?>/view_form2?id=<?php echo $Row['id']; ?>" class="btn btn-sm btn-success waves-effect waves-light" title="View Form from user side"><i class="fas fa-list"></i></a>

                <a href="javascript:void(0)" onClick="resendMail('<?php echo $Row['id']; ?>')" class="btn btn-sm btn-warning waves-effect waves-light" title="Resend Email"><i class="fas fa-envelope"></i></a>
                <?php if(empty($userInfo)) { if($block) { ?>
                    <a href="javascript:void(0)" onClick="DeleteModal('<?php echo $Row['ip_address']; ?>',1)" class="btn btn-sm btn-success waves-effect waves-light"><i class="fas fa-unlock"></i></a>

                <?php } else { ?>
                    <a href="javascript:void(0)" onClick="DeleteModal('<?php echo $Row['ip_address']; ?>',0)" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-ban"></i></a>

                <?php }
                }
                ?>
            </td>
        </tr>
        <?php $count++; } ?>
    </tbody>

</table>
