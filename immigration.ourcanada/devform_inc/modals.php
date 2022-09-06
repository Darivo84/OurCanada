<!-- Modal -->
<div class="modal fade" id="languageChangeModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleModalLabel">OurCanada</h5>
            </div>
            <div class="modal-body static_label" id="languageChangeLabel"></div>
            <div class="modal-footer">
                <input id="prevLang" hidden>
                <button id="langChangeLink" hidden></button>
                <button type="button" class="btn btn-secondary static_label" data-dismiss="modal"  id="langChangeNo"><?php echo $allLabelsArray[41] ?></button>
                <button type="button" class="btn btn-primary static_label"  id="langChangeYes"><?php echo $allLabelsArray[40] ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleModalLabel">OurCanada</h5>
            </div>
            <div class="modal-body static_label" id="editLabel"><?php echo $allLabelsArray[36] ?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal static_label" data-dismiss="modal" ><?php echo $allLabelsArray[41] ?></button>
                <button type="button" class="btn btn-primary btnModal2 static_label" id="yesBtn2" ><?php echo $allLabelsArray[40] ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="submitModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleModalLabel">OurCanada</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-success urduCheckBox"><i class="fa fa-check"></i> <span id="subModalBody" class="static_label"><?php echo $allLabelsArray[30] ?></span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal static_label" data-dismiss="modal" hidden><?php echo $allLabelsArray[41] ?></button>
                <button type="button" class="btn btn-primary btnModal2 static_label" id="yesBtn1"><?php echo $allLabelsArray[6] ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="commentModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleModalLabel">OurCanada</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group2" id="comment_box">
                            <label style="margin-bottom: 7px;" class="static_label"><?php echo $allLabelsArray[60] ?></label>
                            <textarea name="com" id="com" class="form-control comments"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal static_label" data-dismiss="modal" hidden><?php echo $allLabelsArray[41] ?></button>
                <button type="button" class="btn btn-primary btnModal2 static_label" id="yesBtn3"><?php echo $allLabelsArray[22] ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="endModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleModalLabel"><?php echo $allLabelsArray[23] ?></h5>
            </div>
            <div class="modal-body static_label" id="endBody"><?php echo $allLabelsArray[4] ?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal static_label" data-dismiss="modal"><?php echo $allLabelsArray[5] ?></button>
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header2">
                <h5 class="modal-title static_label" id="exampleModalLabel"><?php echo $allLabelsArray[26] ?></h5>
            </div>
            <div class="modal-body static_label" id="logouttxt"><?php echo $allLabelsArray[25] ?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal static_label" data-dismiss="modal"><?php echo $allLabelsArray[5] ?></button>
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header2">
                <h5 class="modal-title static_label" id="exampleModalLabel"><?php echo $allLabelsArray[26] ?></h5>
            </div>
            <div class="modal-body static_label" id="error_msg"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary static_label" id="yesBtn4"><?php echo $allLabelsArray[5] ?></button>
                <button type="button" class="btn btn-primary btnModal3 static_label" id="noBtn4"><?php echo $allLabelsArray[103] ?></button>
                <button type="button" hidden class="btn btn-secondary static_label closeModal" data-dismiss="modal"><?php echo $allLabelsArray[41] ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="errorModal2" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header2">
                <h5 class="modal-title static_label" id="exampleModalLabel"><?php echo $allLabelsArray[26] ?></h5>
            </div>
            <div class="modal-body static_label" id="error_msg2"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal static_label" data-dismiss="modal"><?php echo $allLabelsArray[5] ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="logoutConformModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"
     aria-labelledby="exampleMolLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleMolLabel">OurCanada</h5>
            </div>
            <div class="modal-body static_label" id="editl"><?php echo $allLabelsArray[180] ?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info btnModal static_label" data-dismiss="modal"><?php echo $allLabelsArray[5] ?></button>
                <a href="<?php echo $currentTheme; ?>logout<?php echo $langURL; ?>" class="btn btn-primary btnModal2 static_label" >Logout</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="draftModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleModalLabel">OurCanada</h5>
            </div>
            <div class="modal-body static_label" id="editLabel"><?php echo $allLabelsArray[306] ?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal static_label closeDraftModal" data-dismiss="modal"><?php echo $allLabelsArray[41] ?></button>
                <button type="button" class="btn btn-primary btnModal2 static_label" id="draftupdatebtn"><?php echo $allLabelsArray[40] ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button hidden  type="button" id="btnModal" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
    Launch demo modal
</button>
<button hidden type="button" id="btnModal2" class="btn btn-primary" data-toggle="modal" data-target="#warningModal">
    Launch demo modal
</button>