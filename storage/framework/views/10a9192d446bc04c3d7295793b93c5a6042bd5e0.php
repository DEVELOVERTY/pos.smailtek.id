 <div class="modal fade" id="paymodal" tabindex="-1" role="dialog" aria-labelledby="paymodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full payment_modal" role="document">
         <div class="modal-content" style="height: 90vh;">
             <div class="modal-header header-modal" style="height: 5vh;">
                 <h5 class="modal-title text-white" id=""><?php echo e(__('pos.payment')); ?></h5>
                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <i class="fa fa-times text-white"></i>
                 </button>
             </div>
             <div class="modal-body" style="overflow: hidden;">
                 <div class="row">
                     <div class="col-3" style="height:100vh; box-shadow: 1px 1px 1px  #00474d;">
                         <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                             <a class="nav-link active" id="cash" href="#cashpay">Cash</a>
                             <a class="nav-link" id="bank" href="#banktf">Bank Transfer</a>
                             <a class="nav-link" id="card" href="#cc">Kartu Kredit</a>
                         </div>
                     </div>
                     <div class="col-9">
                         <div class="tab-content" id="v-pills-tabContent">
                             <div class="tab-pane fade show active" id="cashpay" role="tabpanel" aria-labelledby="cash">
                                 <div class="row m-2 p-2">
                                     <div class="col-6 mb-4">
                                         <button type="button" onclick="payfull()" class="btn btn-primary btn-lg btn-rounded btn-block">
                                             <i class="fa fa-wallet"></i> | Bayar Full
                                         </button>
                                     </div>
                                     <div class="col-6 mb-4">
                                         <button type="button" onclick="duefull()" class="btn btn-warning btn-lg btn-rounded btn-block">
                                             <i class="fas fa-money-check"></i> | Full Hutang
                                         </button>
                                     </div>
                                     <div class="col-md-6 col-sm-12">
                                         <div class="input-group" style="height: 8vh;">
                                             <span class="input-group-text" id="dibayarkan">Dibayarkan</span>
                                             <input type="text" class="form-control" id="on_pay" name="on_pay" min="0" value="0">
                                         </div>
                                     </div>
                                     <div class="col-md-6 col-sm-12" id="duepay">
                                         <div class="input-group" style="height: 8vh;">
                                             <span class="input-group-text" id="dibayarkan">Hutang</span>
                                             <input type="text" class="form-control" id="on_due" name="on_due">
                                         </div>
                                     </div>
                                     <div class="col-md-6 col-sm-12 d-none" id="changepay">
                                         <div class="input-group" style="height: 8vh;">
                                             <span class="input-group-text" id="dibayarkan">Kembalian</span>
                                             <input type="text" class="form-control" id="on_change" name="on_change">
                                         </div>
                                     </div>
                                     <div id="paymentprocess"></div>
                                 </div>
                             </div>

                         </div>
                     </div>
                 </div>

             </div>
             <div class="modal-footer">
                 <table class="table">
                     <tr>
                         <td>
                             <button type="button" id="holdbutton" class="btn btn-lg btn-block btn-danger">
                                 <i class="bx bx-x d-block d-sm-none"></i>
                                 <span class="d-none d-sm-block"><i class="far fa-hand-paper"></i> <?php echo e(__('pos.hold')); ?></span>
                             </button>
                             <div id="holdinput" class="d-none"></div>
                         </td>
                         <td>
                             <button type="submit" class="btn btn-lg btn-block btn-primary ml-1">
                                 <span class="d-none d-sm-block"><i class="fas fa-money-bill-alt"></i> <?php echo e(__('pos.pay')); ?> </span>
                             </button>
                         </td>
                     </tr>
                 </table>


             </div>
         </div>
     </div>
 </div>

 <div class="modal right fade" id="choosecustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
     <div class="modal-dialog" role="document">
         <div class="modal-content">

             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title" id="myModalLabel2">Right Sidebar</h4>
             </div>

             <div class="modal-body">
                 <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                 </p>
             </div>

         </div><!-- modal-content -->
     </div><!-- modal-dialog -->
 </div><!-- modal -->


 <div class="modal fade text-left" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
         <div class="modal-content">
             <div class="modal-header header-modal" style="height: 7vh;">
                 <h4 class="modal-title text-white" id="myModalLabel33"><?php echo e(__('sidebar.add_customer')); ?></h4>
                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <i class="fa fa-times text-white"></i>
                 </button>
             </div>
             <form id="cCustomer" method="POST">
                 <?php echo csrf_field(); ?>
                 <div class="modal-body">
                     <label><?php echo e(__('customer.name')); ?> * </label>
                     <div class="form-group">
                         <input type="text" name="name" id="name" class="form-control">
                     </div>
                     <label><?php echo e(__('general.phone')); ?> </label>
                     <div class="form-group">
                         <input type="number" name="phone" class="form-control">
                     </div>
                     <label><?php echo e(__('general.email')); ?> </label>
                     <div class="form-group">
                         <input type="email" name="email" class="form-control">
                     </div>
                     <label><?php echo e(__('general.code')); ?> </label>
                     <div class="form-group">
                         <input type="text" name="code" class="form-control">
                     </div>
                     <label><?php echo e(__('general.city')); ?> </label>
                     <div class="form-group">
                         <input type="text" name="city" class="form-control">
                     </div>
                     
                     <label><?php echo e(__('general.address')); ?> </label>
                     <div class="form-group">
                         <textarea class="form-control" name="address" id="address"></textarea>
                     </div>
                     <label><?php echo e(__('general.detail')); ?> </label>
                     <div class="form-group">
                         <textarea class="form-control" name="detail" id="detail"></textarea>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <a href="javascript:void(0)" id="saveCustomer" class="btn btn-lg btn-block btn-rounded btn-primary ml-1">
                         <i class="bx bx-check d-block d-sm-none"></i>
                         <span class="d-none d-sm-block"><?php echo e(__('sidebar.add_customer')); ?></span>
                     </a>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <div class="modal fade" id="holdmodal" tabindex="-1" role="dialog" aria-labelledby="holdmodal" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full hold_modal" role="document">
         <div class="modal-content" style="height: 90vh">
             <div class="modal-header header-modal" style="height: 5vh;">
                 <h5 class="modal-title text-white" id=""><?php echo e(__('pos.hold_transac')); ?></h5>
                 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <i data-feather="x"></i>
                 </button>
             </div>
             <div class="modal-body">

                 <div class="row" id="holdlist"> </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-lg btn-block btn-rounded btn-light-secondary" data-bs-dismiss="modal">
                     <span class="d-none d-sm-block"><?php echo e(__('general.close')); ?></span>
                 </button>
             </div>
         </div>
     </div>
 </div><?php /**PATH C:\xampp\htdocs\mdhpos\resources\views/components/pos/footer-component.blade.php ENDPATH**/ ?>