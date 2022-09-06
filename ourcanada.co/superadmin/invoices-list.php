<!doctype html>
<html lang="en">


<head>
        
        <meta charset="utf-8" />
        <?php include_once("includes/style.php"); ?>

    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <?php include_once("includes/header.php"); ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Orders</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Consultation</a></li>
                                            <li class="breadcrumb-item active">Orders</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Orders</h4>

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#all-order" role="tab">
                                                    All Orders
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#processing" role="tab">
                                                    Processing
                                                </a>
                                            </li>
                                        </ul>
        
                                        <!-- Tab panes -->
                                        <div class="tab-content p-3">
                                            <div class="tab-pane active" id="all-order" role="tabpanel">
                                                <form>
                                                    <div class="row">
                                                        
                                                        <div class="col-xl col-sm-6">
                                                            <div class="form-group mt-3 mb-0">
                                                                <label>Date :</label>
                                                                <input type="text" class="form-control" id="orderid-input" placeholder="Select date" data-date-format="dd M, yyyy" data-date-orientation="bottom auto" data-provide="datepicker" data-date-autoclose="true">
                                                            </div>
                                                        </div>
        
                                                        <div class="col-xl col-sm-6">
                                                            <div class="form-group mt-3 mb-0">
                                                                <label>Type</label>
                                                                <select class="form-control select2-search-disable">
                                                                    <option value="paypal" selected>Paypal</option>
                                                                    <option value="card">Master/Visa Card</option>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
        
                                                        
                                                        <div class="col-xl col-sm-6">
                                                            <div class="form-group mt-3 mb-0">
                                                                <label>Status</label>
                                                                <select class="form-control select2-search-disable">
                                                                    <option value="CO" selected>Completed</option>
                                                                    <option value="PE">Pending</option>
                                                                </select>
                                                            </div>
                                                        </div>
        
                                                        <div class="col-xl col-sm-6 align-self-end">
                                                            <div class="mt-3">
                                                                <button type="button" class="btn btn-primary w-md">Search Order</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="table-responsive mt-5">
                                                    <table class="table table-hover datatable dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Date</th>
                                                                <th scope="col">Type</th>
                                                                
                                                                <th scope="col">Value</th>
                                                                <th scope="col">Value in USD</th>
                                                                <th scope="col">Status</th>
                                                            </tr>
                                                            
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td>03 Mar, 2020</td>
                                                                <td>Paypal</td>
                                                                
                                                                <td>1.00952 </td>
                                                                <td>$ 9067.62</td>
                                                                <td>
                                                                    <span class="badge badge-success font-size-10">Completed</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>04 Mar, 2020</td>
                                                                <td>Credit Card</td>
                                                                
                                                                <td>0.00413 </td>
                                                                <td>$ 2123.01</td>
                                                                <td>
                                                                    <span class="badge badge-success font-size-10">Completed</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>04 Mar, 2020</td>
                                                                <td>Paypal</td>
                                                                
                                                                <td>0.00321 </td>
                                                                <td>$ 1802.62</td>
                                                                <td>
                                                                    <span class="badge badge-warning font-size-10">Pending</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>05 Mar, 2020</td>
                                                                <td>Paypal</td>
                                                                
                                                                <td>0.00224 </td>
                                                                <td>$ 1773.01</td>
                                                                <td>
                                                                    <span class="badge badge-success font-size-10">Completed</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>06 Mar, 2020</td>
                                                                <td>Paypal</td>
                                                                
                                                                <td>1.04321 </td>
                                                                <td>$ 9423.73</td>
                                                                <td>
                                                                    <span class="badge badge-danger font-size-10">Failed</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>07 Mar, 2020</td>
                                                                <td>Credit Card</td>
                                                                
                                                                <td>0.00413 </td>
                                                                <td>$ 2123.01</td>
                                                                <td>
                                                                    <span class="badge badge-success font-size-10">Completed</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>07 Mar, 2020</td>
                                                                <td>Paypal</td>
                                                                
                                                                <td>1.00952 </td>
                                                                <td>$ 9067.62</td>
                                                                <td>
                                                                    <span class="badge badge-warning font-size-10">Pending</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>08 Mar, 2020</td>
                                                                <td>Credit Card</td>
                                                                
                                                                <td>0.00413 </td>
                                                                <td>$ 2123.01</td>
                                                                <td>
                                                                    <span class="badge badge-success font-size-10">Completed</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>09 Mar, 2020</td>
                                                                <td>Credit Card</td>
                                                                
                                                                <td>1.00952 </td>
                                                                <td>$ 9067.62</td>
                                                                <td>
                                                                    <span class="badge badge-success font-size-10">Completed</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>10 Mar, 2020</td>
                                                                <td>Paypal</td>
                                                                
                                                                <td>0.00413 </td>
                                                                <td>$ 2123.01</td>
                                                                <td>
                                                                    <span class="badge badge-warning font-size-10">Pending</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td>11 Mar, 2020</td>
                                                                <td>Paypal</td>
                                                                
                                                                <td>1.04321 </td>
                                                                <td>$ 9423.73</td>
                                                                <td>
                                                                    <span class="badge badge-success font-size-10">Completed</span>
                                                                </td>
                                                            </tr>
        
                                                            <tr>
                                                                <td>12 Mar, 2020</td>
                                                                <td>Credit Card</td>
                                                                
                                                                <td>0.00413 </td>
                                                                <td>$ 2123.01</td>
                                                                <td>
                                                                    <span class="badge badge-success font-size-10">Completed</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="processing" role="tabpanel">
                                                <div>
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-hover datatable dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Date</th>
                                                                    <th scope="col">Type</th>
                                                                   
                                                                    <th scope="col">Value</th>
                                                                    <th scope="col">Value in USD</th>
                                                                    <th scope="col">Status</th>
                                                                </tr>
                                                                
                                                            </thead>
    
                                                            <tbody>
                                                                <tr>
                                                                    <td>03 Mar, 2020</td>
                                                                    <td>Paypal</td>
                                                                    
                                                                    <td>1.00952 </td>
                                                                    <td>$ 9067.62</td>
                                                                    <td>
                                                                        <span class="badge badge-success font-size-10">Completed</span>
                                                                    </td>
                                                                </tr>
    
                                                                <tr>
                                                                    <td>04 Mar, 2020</td>
                                                                    <td>Credit Card</td>
                                                                    
                                                                    <td>0.00413 </td>
                                                                    <td>$ 2123.01</td>
                                                                    <td>
                                                                        <span class="badge badge-success font-size-10">Completed</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>04 Mar, 2020</td>
                                                                    <td>Paypal</td>
                                                                    
                                                                    <td>0.00321 </td>
                                                                    <td>$ 1802.62</td>
                                                                    <td>
                                                                        <span class="badge badge-warning font-size-10">Pending</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>05 Mar, 2020</td>
                                                                    <td>Paypal</td>
                                                                    
                                                                    <td>0.00224 </td>
                                                                    <td>$ 1773.01</td>
                                                                    <td>
                                                                        <span class="badge badge-success font-size-10">Completed</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>06 Mar, 2020</td>
                                                                    <td>Paypal</td>
                                                                    
                                                                    <td>1.04321 </td>
                                                                    <td>$ 9423.73</td>
                                                                    <td>
                                                                        <span class="badge badge-danger font-size-10">Failed</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>07 Mar, 2020</td>
                                                                    <td>Credit Card</td>
                                                                    
                                                                    <td>0.00413 </td>
                                                                    <td>$ 2123.01</td>
                                                                    <td>
                                                                        <span class="badge badge-success font-size-10">Completed</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>07 Mar, 2020</td>
                                                                    <td>Paypal</td>
                                                                    
                                                                    <td>1.00952 </td>
                                                                    <td>$ 9067.62</td>
                                                                    <td>
                                                                        <span class="badge badge-warning font-size-10">Pending</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>08 Mar, 2020</td>
                                                                    <td>Credit Card</td>
                                                                    
                                                                    <td>0.00413 </td>
                                                                    <td>$ 2123.01</td>
                                                                    <td>
                                                                        <span class="badge badge-success font-size-10">Completed</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>09 Mar, 2020</td>
                                                                    <td>Credit Card</td>
                                                                    
                                                                    <td>1.00952 </td>
                                                                    <td>$ 9067.62</td>
                                                                    <td>
                                                                        <span class="badge badge-success font-size-10">Completed</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>10 Mar, 2020</td>
                                                                    <td>Paypal</td>
                                                                    
                                                                    <td>0.00413 </td>
                                                                    <td>$ 2123.01</td>
                                                                    <td>
                                                                        <span class="badge badge-warning font-size-10">Pending</span>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td>11 Mar, 2020</td>
                                                                    <td>Paypal</td>
                                                                    
                                                                    <td>1.04321 </td>
                                                                    <td>$ 9423.73</td>
                                                                    <td>
                                                                        <span class="badge badge-success font-size-10">Completed</span>
                                                                    </td>
                                                                </tr>
            
                                                                <tr>
                                                                    <td>12 Mar, 2020</td>
                                                                    <td>Credit Card</td>
                                                                    
                                                                    <td>0.00413 </td>
                                                                    <td>$ 2123.01</td>
                                                                    <td>
                                                                        <span class="badge badge-success font-size-10">Completed</span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <?php include_once("includes/footer.php"); ?>
				
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        

        <?php include_once("includes/script.php"); ?>

    </body>

</html>
